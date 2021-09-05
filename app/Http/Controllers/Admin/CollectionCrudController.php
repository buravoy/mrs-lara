<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CollectionRequest;
use App\Models\Collection;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class CollectonCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class CollectionCrudController extends CrudController
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
        CRUD::setModel(\App\Models\Collection::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/collection');
        CRUD::setEntityNameStrings('Подборку', 'Подборки на главной');
        CRUD::addClause('withTrashed');
        CRUD::set('softdelete', true);
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
            'name' => 'name',
            'type' => 'text',
            'label' => 'Заголовок'
        ]);

        CRUD::addColumn([
            'name' => 'description',
            'type' => 'text',
            'label' => 'Подзаголовок'
        ]);

        CRUD::addColumn([
            'name'  => 'content',
            'label' => 'Элементы',
            'type'  => 'table',
            'columns' => [
                'title'        => 'Name',
                'link'       => 'Ссылка',
            ]
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
        CRUD::setValidation(CollectionRequest::class);

        $entry = CRUD::getCurrentEntry();

        CRUD::addField([
            'name' => 'name',
            'label' => 'Название',
            'type' => 'text',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-6',
            ],
        ]);

        CRUD::addField([
            'name' => 'sort',
            'label' => 'Порядок',
            'type' => 'text',
            'value' => !empty($entry->sort) ? $entry->sort : 1,
            'wrapperAttributes' => [
                'class' => 'form-group col-md-2',
            ],
        ]);

        CRUD::addField([
            'name' => 'slug',
            'label' => 'Символьный код',
            'type' => 'text',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-4 ml-auto',
            ],
        ]);

        CRUD::addField([
            'name' => 'description',
            'label' => 'Описание',
            'type' => 'textarea',
        ]);

        CRUD::addField([
            'name'  => 'content',
            'label' => 'Элементы подборки',
            'type'  => 'repeatable',
            'fields' => [
                [
                    'name'    => 'title',
                    'type'    => 'text',
                    'label'   => 'Заголовок',
                    'wrapper' => ['class' => 'form-group col-md-3'],
                ],
                [
                    'name'    => 'size',
                    'type'    => 'select2_from_array',
                    'label'   => 'Размер',
                    'options' => [
                        'col-12 col-md-6 col-lg-3' => '25%',
                        'col-12 col-md-6 col-lg-4' => '33.3%',
                        'col-12 col-lg-6' => '50%',
                        'col-12' => '100%'
                    ],
                    'default'     => 'one',
                    'allows_null' => false,
                    'allows_search' => false,
                    'wrapper' => ['class' => 'form-group col-md-3'],
                ],
                [
                    'name'    => 'link',
                    'type'    => 'text',
                    'label'   => 'Ссылка без домена (/category/obuv)',
                    'wrapper' => ['class' => 'form-group col-md-3'],
                ],
                [
                    'name'    => 'sort',
                    'type'    => 'number',
                    'label'   => 'порядок',
                    'default' => 1,
                    'wrapper' => ['class' => 'form-group col-md-3'],
                ],
                [
                    'name'  => 'image',
                    'type'  => 'browse',
                    'label' => 'Картинка',
                ],
                [
                    'name'  => 'description',
                    'type'  => 'textarea',
                    'label' => 'Описание',
                ],
            ],

            // optional
            'new_item_label'  => 'Добавить элемент в подборку', // customize the text of the button
            'init_rows' => 0, // number of empty rows to be initialized, by default 1


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

    public function restore($id)
    {
        Collection::withTrashed()->find($id)->restore();
        return back();
    }

    public function disable($id)
    {
        Collection::where('id', $id)->delete();
        return back();
    }

    public function delete($id)
    {
        Collection::withTrashed()->find($id)->forceDelete();
        return back();
    }
}
