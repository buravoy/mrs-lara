<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Backpack\CRUD\app\Library\CrudPanel\Traits\Filters;
use Illuminate\Http\Request;
use App\Http\Requests\CategoryRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use function PHPUnit\Framework\isEmpty;

/**
 * Class CategoryCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class CategoryCrudController extends CrudController
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
        CRUD::setModel(\App\Models\Category::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/category');
        CRUD::setEntityNameStrings('категорию', 'категории');

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
            'type' => 'text'
        ]);

        CRUD::addColumn([
            'label' => 'Категория',
            'type' => 'view',
            'view' => 'vendor.backpack.base.columns.category-view',
        ]);

        CRUD::addColumn([
            'label' => 'Дочерние 1 уровня',
            'type' => 'view',
            'view' => 'vendor.backpack.base.columns.childrens',
        ]);



        CRUD::addFilter(
            [
                'name' => 'id',
                'type' => 'select2',
                'label' => 'Родительская категория',
            ],
            function () {
                return Category::pluck('name', 'id')->toArray();
            },
            function ($value) {
                $this->crud->addClause('where', 'parent_id', $value);
            }
        );

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

    public function setupShowOperation()
    {
        CRUD::set('show.setFromDb', true);

//        CRUD::addColumn([
//            'name' => 'name',
//            'label' => 'Название',
//            'type' => 'text',
//        ]);
//
//        CRUD::addColumn([
//            'name' => 'short_name',
//            'label' => 'Короткое название',
//            'type' => 'text',
//        ]);
//
//        CRUD::addColumn([
//            'name'         => 'parent', // name of relationship method in the model
//            'type'         => 'relationship',
//            'label'        => 'Родительская',
//        ]);
//
//        CRUD::addColumn([
//            'name' => 'description',
//            'label' => 'Короткое название',
//            'type' => 'text',
//        ]);


    }
    protected function setupCreateOperation()
    {
        CRUD::setValidation(CategoryRequest::class);

        $entry = CRUD::getCurrentEntry();

//        CRUD::setFromDb(); // fields

        CRUD::addField([
            'name' => 'name',
            'label' => 'Название',
            'type' => 'text',
        ]);

        CRUD::addField([
            'name' => 'parent_id',
            'label' => 'Родительская категория',
            'type' => 'select2',
            'entity' => 'parent'
        ]);

        CRUD::addField([
            'name' => 'short_name',
            'label' => 'Короткое название',
            'type' => 'text',
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
            'inline' => true
        ]);

        CRUD::addField([
            'name' => 'short_description',
            'label' => 'Короткое описание',
            'type' => 'textarea',
        ]);

        CRUD::addField([
            'name' => 'description',
            'label' => 'Описание',
            'type' => 'textarea',
        ]);

        CRUD::addField([
            'name' => 'image',
            'label' => 'Картинка',
            'type' => 'text',
        ]);

        CRUD::addField([
            'name' => 'meta_title',
            'label' => 'META Title',
            'type' => 'text',
        ]);

        CRUD::addField([
            'name' => 'meta_description',
            'label' => 'META Description',
            'type' => 'textarea',
        ]);

        CRUD::addField([
            'name' => 'sort',
            'label' => 'Сортировка',
            'type' => 'number',
            'value' => !empty($entry->sort) ? $entry->sort : 500
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

            if (Category::where('name', $name)->exists()) {
                $id = Category::where('name', $name)->update([
                    'short_name' => $short,
                    'form' => $form,
                ])['id'];
            } else {
                $id = Category::query()->insertGetId([
                    'name' => $name,
                    'short_name' => $short,
                    'form' => $form,
                ]);
            }

            $tempCategories[] = [
                'id' => $id,
                'name' => $name,
                'short_name' => $short,
                'form' => $form,
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

                Category::where('id', $category['id'])->update([
                    'parent_id' => $parentId ? $parentId : null
                ]);
            }
        }

        return true;
    }

    public function deleteAllCategories()
    {
        Category::query()->delete();
        return back();
    }
}
