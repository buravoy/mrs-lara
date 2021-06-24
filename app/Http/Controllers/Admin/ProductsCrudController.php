<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ProductsRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class ProductsCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ProductsCrudController extends CrudController
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
        CRUD::setModel(\App\Models\Products::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/products');
        CRUD::setEntityNameStrings('товар', 'Товары');
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
            'name' => 'name',
            'type' => 'text'
        ]);

        CRUD::addColumn([
            'name' => 'category',
            'type' => 'relationship',
            'label' => 'Категория'
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
        CRUD::setValidation(ProductsRequest::class);

        $entry = CRUD::getCurrentEntry();

        CRUD::addField([
            'name' => 'name',
            'label' => 'Название',
            'type' => 'text',
        ]);

        CRUD::addField([
            'name' => 'category_id',
            'label' => 'Категория',
            'type' => 'select2',
            'entity' => 'category',
        ]);

        CRUD::addField([
            'name' => 'description',
            'label' => 'Описание',
            'type' => 'text',
        ]);

        CRUD::addField([
            'name' => 'price',
            'label' => 'Цена',
            'type' => 'text',
        ]);

        CRUD::addField([
            'name' => 'old_price',
            'label' => 'Старая цена',
            'type' => 'text',
        ]);

        CRUD::addField([
            'name' => 'discount',
            'label' => 'Скидка',
            'type' => 'text',
        ]);

        CRUD::addField([
            'name' => 'brand',
            'label' => 'Бренд',
            'type' => 'text',
        ]);

        CRUD::addField([
            'name' => 'size',
            'label' => 'Размер',
            'type' => 'text',
        ]);

        CRUD::addField([
            'name' => 'color',
            'label' => 'Цвет',
            'type' => 'text',
        ]);

        CRUD::addField([
            'name' => 'image',
            'label' => 'Картинка',
            'type' => 'text',
        ]);

        CRUD::addField([
            'name' => 'sort',
            'label' => 'Сортировака',
            'type' => 'text',
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
}
