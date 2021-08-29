<?php

namespace App\Http\Controllers\Admin;


use App\Http\Requests\AttributesRequest;
use App\Models\Attributes;
use App\Models\Products;
use App\Models\Groups;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class AttributesCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class AttributesCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation {
        create as traitCreate;
    }
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\BulkDeleteOperation { bulkDelete as traitBulkDelete; }

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {

        CRUD::setModel(\App\Models\Attributes::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/attributes');
        CRUD::orderBy('id', 'desc');

        if (!Groups::exists()) {
            \Alert::add('error', 'Сперва создайте группу атрибутов');
        }

        CRUD::setEntityNameStrings('атрибут', 'Атрибуты');

        CRUD::addFilter(
            [
                'name' => 'id',
                'type' => 'select2',
                'label' => 'Группа атрибутов',
            ],
            function () {
                return Groups::pluck('name', 'id')->toArray();
            },
            function ($value) {
                $this->crud->addClause('where', 'group_id', $value);
            }
        );

        CRUD::addFilter(
            [
                'name' => 'creator',
                'type' => 'select2',
                'label' => 'Кем создан',
            ],
            function () {
                $creator = Attributes::pluck('creator')->unique()->values()->toArray();
                $filterArr = [];
                foreach ($creator as $item) $filterArr[$item] = $item;

                return $filterArr;
            },
            function ($value) {

                $this->crud->addClause('where', 'creator', $value);
            }
        );
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
//        CRUD::setFromDb(); // columns

        CRUD::addColumn([
            'name' => 'id',
            'type' => 'text',
            'label' => 'ID',
        ]);

        CRUD::addColumn([
            'name' => 'group',
            'label' => 'Группа',
            'type' => 'relationship',
        ]);

        CRUD::addColumn([
            'name' => 'name',
            'label' => 'Значение',
            'type' => 'text',
        ]);

        CRUD::addColumn([
            'label' => 'Словоформы',
            'type' => 'view',
            'view' => 'vendor.backpack.base.columns.form',
        ]);

        CRUD::addColumn([
            'name' => 'creator',
            'type' => 'text',
            'label' => 'Кем создан',
        ]);

        CRUD::addColumn([
            'name' => 'show',
            'label' => 'Отображать',
            'type' => 'check',
            'wrapper' => [
                'class' => 'font-xl',
            ],
        ]);

//        CRUD::addColumn([
//            'name' => 'slug',
//            'label' => 'Символьный код',
//            'type' => 'text',
//            'attributes' => [
//                'readonly'    => 'readonly',
//            ],
//        ]);


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
        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number']));
         */

        CRUD::setValidation(AttributesRequest::class);

        $entry = CRUD::getCurrentEntry();
        $attributeGroups = Groups::select('name')->get();

//        CRUD::setFromDb(); // fields

        CRUD::addField([
            'name' => 'group_id',
            'label' => 'Группа',
            'entity' => 'group',
            'type' => 'select2',
            'tab' => 'Информация',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-6',
            ],
        ]);

        CRUD::addField([
            'name' => 'name',
            'label' => 'Значение атрибута',
            'type' => 'text',
            'tab' => 'Информация',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-4',
            ],
        ]);

        CRUD::addFields([
            [
                'name'     => 'form_many',
                'label'    => 'Множественный',
                'fake'     => true,
                'store_in' => 'form',
                'tab' => 'Информация',
                'wrapper' => [
                    'class' => 'form-group col-md-3',
                ],
            ],
            [
                'name'     => 'form_male',
                'label'    => 'Мужской',
                'fake'     => true,
                'store_in' => 'form',
                'tab' => 'Информация',
                'wrapper' => [
                    'class' => 'form-group col-md-3',
                ],
            ],
            [
                'name'     => 'form_female',
                'label'    => 'Женский',
                'fake'     => true,
                'store_in' => 'form',
                'tab' => 'Информация',
                'wrapper' => [
                    'class' => 'form-group col-md-3',
                ],
            ],
            [
                'name'     => 'form_neutral',
                'label'    => 'Средний',
                'fake'     => true,
                'store_in' => 'form',
                'tab' => 'Информация',
                'wrapper' => [
                    'class' => 'form-group col-md-3',
                ],
            ],

        ]);

        CRUD::addField([
            'name' => 'show',
            'label' => 'Показывать в фильтре',
            'type' => 'checkbox',
            'tab' => 'Информация',
            'default' => 1,
            'wrapper' => [
                'class' => 'form-group col-md-6',
            ],
        ]);

        CRUD::addField([
            'name' => 'creator',
            'label' => 'Кем создан',
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

    public function destroy($id)
    {
        $group = Attributes::with('group')->where('id', $id)->first()->group->slug;

        $products = Products::withTrashed()->whereJsonContains('attributes->'.$group, (integer)$id)->get();

        foreach ($products as $product) {
            $attributes = json_decode($product->attributes);
            if(($key = array_search($id, $attributes->$group)) !== false) unset($attributes->$group[$key]);
            $attributes = json_encode($attributes);

            Products::withTrashed()->where('id', $product->id)->update(['attributes' => $attributes]);
        }

        return Attributes::find($id)->delete();
    }
}
