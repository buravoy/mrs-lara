<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CategoryRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

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

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Category::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/category');
        CRUD::setEntityNameStrings('категорию', 'Категории');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {

        CRUD:: addButtonFromView('top', 'import', 'import', 'end');

//        CRUD::setFromDb(); // columns

        CRUD::addColumn([
            'name' => 'name',
            'type' => 'text'
        ]);

        CRUD::addColumn([
            'name' => 'parent',
            'type' => 'relationship',
            'label' => 'Parent'
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
        CRUD::setValidation(CategoryRequest::class);

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
            'entity' => 'parent',
        ]);

        CRUD::addField([
            'name' => 'description',
            'label' => 'Описание',
            'type' => 'text',
        ]);

        CRUD::addField([
            'name' => 'image',
            'label' => 'Картинка',
            'type' => 'text',
        ]);

        CRUD::addField([
            'name' => 'sort',
            'label' => 'Сортировка',
            'type' => 'text',
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

    public function import()
    {
        // whatever you decide to do
    }
}
