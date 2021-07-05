<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\AttributesRequest;
use App\Models\Groups;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Redirect;
use phpDocumentor\Reflection\Location;

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

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {


        CRUD::setModel(\App\Models\Attributes::class);

        CRUD::setRoute(config('backpack.base.route_prefix') . '/attributes');

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
            'label' => 'Тип',
            'type' => 'view',
            'view' => 'vendor.backpack.base.columns.color',
        ]);

        CRUD::addColumn([
            'name' => 'slug',
            'label' => 'Символьный код',
            'type' => 'text',
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
        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number']));
         */

        CRUD::setValidation(AttributesRequest::class);

        $entry = CRUD::getCurrentEntry();
        $attributeGroups = Groups::select('name', 'type')->get();

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

        CRUD::addField([
            'name' => 'value',
            'label' => 'Цвет',
            'type' => 'color_picker',
            'tab' => 'Информация',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-2',
                'id' => 'color'
            ],
        ]);

        CRUD::addField([
            'name' => 'attributes',
            'label' => 'Дополнительно',
            'type' => 'attributes-create',
            'data' => $attributeGroups,
            'tab' => 'Информация',
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
}
