<?php
/*****************用户管理*****************/
Route::group(['prefix' => 'role'], function () {

    Route::get('/', 'RoleCRUDController@getIndex')->name(config('qla.rolecrud.route_name_prefix', 'Crud.Role') . 'index');
    Route::get('indexJson', 'RoleCRUDController@getIndexJson')->name(config('qla.rolecrud.route_name_prefix', 'Crud.Role') . 'indexJson');

    Route::get('add', 'RoleCRUDController@getAdd')->name(config('qla.rolecrud.route_name_prefix', 'Crud.Role') . 'add');
    Route::post('add', 'RoleCRUDController@postAdd')->name(config('qla.rolecrud.route_name_prefix', 'Crud.Role') . 'add.post');
    Route::get('edit/{id}', 'RoleCRUDController@getEdit')->name(config('qla.rolecrud.route_name_prefix', 'Crud.Role') . 'edit');
    Route::post('edit', 'RoleCRUDController@postEdit')->name(config('qla.rolecrud.route_name_prefix', 'Crud.Role') . 'edit.post');
    Route::post('del/{id}', 'RoleCRUDController@del')->name(config('qla.rolecrud.route_name_prefix', 'Crud.Role') . 'del');

    Route::get('grant/{id}', 'RoleCRUDController@getGrant')->name(config('qla.rolecrud.route_name_prefix', 'Crud.Role') . 'grant');
    Route::post('grant', 'RoleCRUDController@postGrant')->name(config('qla.rolecrud.route_name_prefix', 'Crud.Role') . 'grant.post');
});