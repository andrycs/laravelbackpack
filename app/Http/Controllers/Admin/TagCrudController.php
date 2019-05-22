<?php

namespace App\Http\Controllers\Admin;

use App\Models\Art;
use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\TagRequest as StoreRequest;
use App\Http\Requests\TagRequest as UpdateRequest;
use Backpack\CRUD\CrudPanel;

/**
 * Class TagCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class TagCrudController extends CrudController
{
    public function __construct()
    {
        parent::__construct();
        \DB::enableQueryLog();
    }

    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\Tag');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/tag');
        $this->crud->setEntityNameStrings('tag', 'tags');
        $this->crud->allowAccess(['show']);
//        $this->crud->denyAccess(['update', 'delete', 'clone']);

        /*
        |--------------------------------------------------------------------------
        | CrudPanel Configuration
        |--------------------------------------------------------------------------
        */

        // TODO: remove setFromDb() and manually define Fields and Columns
//        $this->crud->setFromDb();
//


        $this->crud->addFilter([ // simple filter
            'type' => 'text',
            'name' => 'details',
            'label'=> 'Description'
        ],
        false,
        function($value) { // if the filter is active
             $this->crud->addClause('where', 'details', 'LIKE', "%$value%");
        } );

        $this->crud->addFilter([ // simple filter
            'type' => 'text',
            'name' => 'art',
            'label'=> 'ART'
        ],
            false,
            function($value) { // if the filter is active
                $this->crud->addClause('whereHas', 'art', function ($query) use ($value) {
                       $query->where('name', $value);
                });
            } );


        $this->crud->addFilter([ // simple filter
            'type' => 'text',
            'name' => 'burt',
            'label'=> 'BURT'
        ],
            false,
            function($value) { // if the filter is active
                $this->crud->addClause('whereHas', 'art', function ($query) use ($value) {
                    $query->whereHas('burt', function($query) use ($value) {
                        $query->where('name', $value);
                    });
                });
            } );

        $this->crud->addColumn([
            'name' => 'details',
            'type' => 'text',
            'label' => 'Details',
        ]);
//
        $this->crud->addColumn([
            'name' => 'name',
            'type' => 'text',
            'label' => 'Name',
        ]);

        $this->crud->addColumn([
            'type' => 'select',
            'label' => 'BURT',
            'name' => 'art_id',
            'entity' => 'art.burt',
//            'attribute' => 'name',
            'attribute' => 'array.a',
            'key' => 'parent_last_name',
            'searchLogic' => false
        ]);
//
        $this->crud->addColumn([
            'name' => 'art_id',
            'entity' => 'art',
            'type' => 'select',
            'label' => 'Art',
            'attribute' => "name",
            'model' => Art::class,
        ]);




            $this->crud->addField([
                'name' => 'details',
                'type' => 'text',
                'label' => 'Detail',
            ]);

        $this->crud->addField([
            'type' => 'select',
            'label' => 'Category',
            'name' => 'art_id',
            'entity' => 'art',
            'attribute' => 'name',
            'model' => Art::class,
        ]);

        $this->crud->addField([
            'name' => 'name',
            'type' => 'text',
            'label' => 'Name',
        ]);

        // add asterisk for fields that are required in TagRequest
        $this->crud->setRequiredFields(StoreRequest::class, 'create');
        $this->crud->setRequiredFields(UpdateRequest::class, 'edit');
    }

    public function store(StoreRequest $request)
    {
        // your additional operations before save here
        $redirect_location = parent::storeCrud($request);
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
    }

    public function update(UpdateRequest $request)
    {
        // your additional operations before save here
        $redirect_location = parent::updateCrud($request);
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
    }
//    public function search()
//    {
//        parent::search();
//        dd(\DB::getQueryLog());
//    }
}
