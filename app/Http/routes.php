<?php

/*
|--------------------------------------------------------------------------
| Documentation Routes
|--------------------------------------------------------------------------
*/
Route::get('/', 'DocumentationController@index');				// API Documentation

/*
|--------------------------------------------------------------------------
| Location Routes
|--------------------------------------------------------------------------
*/
Route::group(['prefix' => 'api/v1'], function() {
	// Location Root Level Routes
	Route::post		('location',		'LocationController@store');	// Create Root Level Location

	Route::get		('location',		'LocationController@index');	// ReadList of ALL Locations
	Route::get		('location/{id}',	'LocationController@show');		// Read Specific Location

	Route::put		('location/{id}',	'LocationController@update');	// Update Specific Location

	Route::delete	('location/{id}',	'LocationController@destroy');	// Delete Specific Location


	// Decendent Level Routes
	Route::post		('location/{parent_id}/location',		'LocationController@store');	// Create Child Location for Specific Parent Location

	Route::get		('location/{parent_id}/location',		'LocationController@index');	// ReadList of Specific Location


	// Find Closest Ancestor
	Route::get		('location/{id1}/{id2}',	'LocationController@ancestor');		// Location1 identified by id1 and Location2 identified by id2

});
