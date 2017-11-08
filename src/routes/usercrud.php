<?php
/*****************用户管理*****************/
Route::group(['prefix' => 'user'], function () {
    Route::get('/', 'UserCRUDController@getIndex')->name( config('qla.usercrud.route_name_prefix', 'Crud.User') . 'index');
    Route::get('indexJson', 'UserCRUDController@getIndexJson')->name(config('qla.usercrud.route_name_prefix', 'Crud.User') . '.indexJson');
    Route::get('add', 'UserCRUDController@getAdd')->name(config('qla.usercrud.route_name_prefix', 'Crud.User') . '.add');
    Route::post('add', 'UserCRUDController@postAdd')->name(config('qla.usercrud.route_name_prefix', 'Crud.User') . '.add.post');
    Route::get('edit/{id}', 'UserCRUDController@getEdit')->name(config('qla.usercrud.route_name_prefix', 'Crud.User') . '.edit');
    Route::post('edit', 'UserCRUDController@postEdit')->name(config('qla.usercrud.route_name_prefix', 'Crud.User') . '.edit.post');
    Route::post('del/{id}', 'UserCRUDController@del')->name(config('qla.usercrud.route_name_prefix', 'Crud.User') . '.del');
    Route::post('grant/{id}', 'UserCRUDController@postGrant')->name(config('qla.usercrud.route_name_prefix', 'Crud.User') . '.grant');
});