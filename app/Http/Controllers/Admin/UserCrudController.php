<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\UserRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class UserCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class UserCrudController extends CrudController
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
        CRUD::setModel(\App\Models\User::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/user');
        CRUD::setEntityNameStrings('пользователя', 'Пользователи');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::addColumn([
            'name' => 'name', // the db column name (attribute name)
            'label' => 'Имя', // the human-readable label for it
            'type' => 'text' // the kind of column to show
        ]);

        CRUD::addColumn([
            'name' => 'email', // the db column name (attribute name)
            'label' => 'Логин / E-mail', // the human-readable label for it
            'type' => 'text' // the kind of column to show
        ]);

        CRUD::addColumn([
            'name' => 'is_admin', // the db column name (attribute name)
            'label' => 'Роль', // the human-readable label for it
            'type' => 'closure',
            'function' => function ($entry) {
                return $entry->is_admin ? 'Администратор' : 'Пользователь';
            }
        ]);

        CRUD::addColumn([
                'label' => 'Информация', // Table column heading
                'type'  => 'view',
                'view'  => 'vendor.backpack.base.columns.user-dates', // or path to blade file
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
        CRUD::setValidation(UserRequest::class);


        CRUD::addField([
            'name' => 'name',
            'label' => 'Имя',
            'type' => 'text'
        ]);

        CRUD::addField([
            'name' => 'email',
            'label' => 'Почта',
            'type' => 'text'
        ]);

        CRUD::addField([
            'name' => 'is_admin',
            'label' => 'Роль',
            'type' => 'radio',
            'options' => [
                1 => 'Администратор',
                0 => 'Пользователь'
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
}
