<?php

namespace App\Http\Controllers\Admin;

use App\Models\Categories;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Http\Request;
use App\Http\Requests\CategoriesRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class CategoryCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class CategoriesCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ReorderOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(Categories::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/category');
        CRUD::setEntityNameStrings('категорию', 'Категории');
        CRUD::addClause('withTrashed');
        CRUD::set('softdelete', true);

        CRUD::addFilter(
            [
                'name' => 'id',
                'type' => 'select2',
                'label' => 'Родительская категория',
            ],
            function () {
                return Categories::pluck('name', 'id')->toArray();
            },
            function ($value) {
                $this->crud->addClause('where', 'parent_id', $value);
            }
        );
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupReorderOperation()
    {
        // define which model attribute will be shown on draggable elements
        CRUD::set('reorder.label', 'name');
        // define how deep the admin is allowed to nest the items
        // for infinite levels, set it to 0
        CRUD::set('reorder.max_level', 0);
    }

    public function reorder()
    {
        $this->crud->hasAccessOrFail('reorder');

        if (! $this->crud->isReorderEnabled()) {
            abort(403, 'Reorder is disabled.');
        }

//        $this->crud->addClause('where', 'parent_id', 39);

//        dd($this->crud->getEntries());
        // get all results for that entity

        $this->data['entries'] = $this->crud->getEntries();
        $this->data['crud'] = $this->crud;
        $this->data['title'] = $this->crud->getTitle() ?? trans('backpack::crud.reorder').' '.$this->crud->entity_name;

        // load the view from /resources/views/vendor/backpack/crud/ if it exists, otherwise load the one in the package
        return view($this->crud->getReorderView(), $this->data);
    }

    /**
     *  Reorder the items in the database using the Nested Set pattern.
     *
     *  Database columns needed: id, parent_id, lft, rgt, depth, name/title
     *
     *  @return Response
     */

    protected function setupListOperation()
    {

        CRUD::addButtonFromView('top', 'import', 'import-categories', 'end');

        CRUD::addButtonFromView('top', 'clear', 'clear-categories', 'end');

//        CRUD::setFromDb(); // columns

        CRUD::addColumn([
            'name' => 'id',
            'type' => 'text',
            'label' => 'ID'
        ]);

        CRUD::addColumn([
            'name' => 'name',
            'type' => 'text',
            'label' => 'Название',
        ]);

        CRUD::addColumn([
            'label' => 'Информация',
            'type' => 'view',
            'view' => 'vendor.backpack.base.columns.category-view',
        ]);

        CRUD::addColumn([
            'label' => 'Дочерние 1 уровня',
            'type' => 'view',
            'view' => 'vendor.backpack.base.columns.childrens',
        ]);

        CRUD::addColumn([
            'name' => 'show',
            'type' => 'check',
            'label' => 'В меню'
        ]);

        CRUD::addColumn([
            'name' => 'slug',
            'type' => 'text',
            'label' => 'Символьный код'
        ]);



        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']);
         */
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */

    protected function setupCreateOperation()
    {
        CRUD::setValidation(CategoriesRequest::class);

        $entry = CRUD::getCurrentEntry();

//        CRUD::setFromDb(); // fields

        CRUD::addField([
            'name' => 'name',
            'label' => 'Название',
            'type' => 'text',
            'tab' => 'Информация',
            'wrapper' => [
                'class' => 'form-group col-md-6',
            ],
        ]);

        CRUD::addField([
            'name' => 'short_name',
            'label' => 'Короткое название',
            'type' => 'text',
            'tab' => 'Информация',
            'wrapper' => [
                'class' => 'form-group col-md-4',
            ],
        ]);

        CRUD::addField([
            'name' => 'xml_id',
            'label' => 'ID из XML файла',
            'type' => 'text',
            'tab' => 'Информация',
            'wrapper' => [
                'class' => 'form-group col-md-2',
            ],
            'attributes' => [
                'readonly'    => 'readonly',
            ],
        ]);

        CRUD::addField([
            'name' => 'parent_id',
            'label' => 'Родительская категория',
            'type' => 'select2',
            'entity' => 'parent',
            'tab' => 'Информация',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-6',
            ],
        ]);

        CRUD::addField([
            'name' => 'form',
            'label' => 'Словоформа',
            'type' => 'radio',
            'options'     => [
                'муж' => "Мужской",
                'жен' => "Женский",
                'сред' => "Средний",
                'множ' => "Множественный",
            ],
            'inline' => true,
            'tab' => 'Информация',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-6',
            ],
        ]);

        CRUD::addField([
            'name' => 'show',
            'label' => 'Показывать в главном меню',
            'type' => 'checkbox',
            'tab' => 'Информация',
            'inline' => true,
            'wrapper' => [
                'class' => 'form-group col-md-6',
            ],
        ]);

        CRUD::addField([
            'name' => 'short_description',
            'label' => 'Короткое описание',
            'type' => 'textarea',
            'tab' => 'Информация',
        ]);

        CRUD::addField([
            'name' => 'description',
            'label' => 'Описание',
            'type' => 'textarea',
            'tab' => 'Информация',
        ]);

        CRUD::addField([
            'name' => 'image',
            'label' => 'Картинка',
            'type' => 'browse',
            'tab' => 'Информация',
        ]);

        CRUD::addField([
            'name' => 'meta_title',
            'label' => 'META Title',
            'type' => 'text',
            'tab' => 'META',
        ]);

        CRUD::addField([
            'name' => 'meta_description',
            'label' => 'META Description',
            'type' => 'textarea',
            'tab' => 'META',
        ]);

        CRUD::addField([
            'name' => 'slug',
            'label' => 'Символьный код',
            'type' => 'text',
            'tab' => 'Дополнительно',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-8',
            ],
        ]);

        CRUD::addField([
            'name' => 'sort',
            'label' => 'Сортировка',
            'type' => 'text',
            'value' => !empty($entry->sort) ? $entry->sort : 500,
            'tab' => 'Дополнительно',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-2 ml-auto',
            ],
        ]);

        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number']));
         */
    }

    /**
     * Define what happens when the Update operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }

    public function categoryXmlImport(Request $request)
    {

        $filepath = base_path('uploads/xml/categories/') . $request->input('filename');
        $file = simplexml_load_file($filepath);
        $categories = $file->shop->categories->category;

        $tempCategories = [];

        foreach ($categories as $category) {

            $name = $category->name ? (string)$category->name : 'Error';
            $short = $category->short ? (string)$category->short : null;
            $form = $category->form ? (string)$category->form : null;
            $xmlId = $category->attributes()->id ? (string)$category->attributes()->id : null;
            $xmlParent = $category->attributes()->parent ? (string)$category->attributes()->parent : null;



            if (Categories::where('xml_id', $xmlId)->exists()) {
                $id = Categories::where('xml_id', $xmlId)->update([
                    'name' => $name,
                    'short_name' => $short,
                    'form' => $form,
                ]);
            } else {
                $id = Categories::query()->insertGetId([
                    'name' => $name,
                    'xml_id' => $xmlId,
                    'slug' => SlugService::createSlug(Categories::class, 'slug', $name),
                    'short_name' => $short,
                    'form' => $form,
                ]);
            }

            $tempCategories[] = [
                'id' => $id,
                'xml_id' => $xmlId,
                'xml_parent_id' => $xmlParent,
            ];

        }

        foreach ($tempCategories as $category) {
            if ($category['xml_parent_id']) {
                foreach ($tempCategories as $item) {
                    if ($category['xml_parent_id'] == $item['xml_id']) {
                        $parentId = $item['id'];
                        break;
                    }
                }

                Categories::where('id', $category['id'])->update([
                    'parent_id' => $parentId ? $parentId : null
                ]);
            }
        }

        return true;
    }

    public function deleteAllCategories()
    {
        Categories::query()->forceDelete();
        return back();
    }

    public function restore($id)
    {
        Categories::withTrashed()->find($id)->restore();
        return back();
    }

    public function disable($id)
    {
        Categories::where('id', $id)->delete();
        return back();
    }

    public function delete($id)
    {
        Categories::withTrashed()->find($id)->forceDelete();
        return back();
    }
}
