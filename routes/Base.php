<?php
namespace App\Base\routes;

use Illuminate\Routing\Route;


Route::group(['prefix' => 'base'], function () use ($namespacePrefix) {
    dd("In the base route");
    $namespacePrefix = __DIR__ . '/../Http/Controllers';

    Route::get('/', ['uses' => $namespacePrefix . 'BaseControllerEditor@index',              'as' => 'index']);
    Route::get('{table}/create', ['uses' => $namespacePrefix . 'BaseControllerEditor@create',     'as' => 'create']);
    Route::post('/', ['uses' => $namespacePrefix . 'BaseControllerEditor@store',   'as' => 'store']);
    Route::get('{table}/edit', ['uses' => $namespacePrefix . 'BaseControllerEditor@edit', 'as' => 'edit']);
    Route::put('{id}', ['uses' => $namespacePrefix . 'BaseControllerEditor@update',  'as' => 'update']);
    Route::delete('{id}', ['uses' => $namespacePrefix . 'BaseControllerEditor@destroy',  'as' => 'delete']);
    Route::post('relationship', ['uses' => $namespacePrefix . 'BaseControllerEditor@addRelationship',  'as' => 'relationship']);
    Route::get('delete_relationship/{id}', ['uses' => $namespacePrefix . 'BaseControllerEditor@deleteRelationship',  'as' => 'delete_relationship']);
});
