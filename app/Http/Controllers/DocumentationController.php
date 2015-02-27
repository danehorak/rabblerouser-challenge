<?php namespace App\Http\Controllers;

class DocumentationController extends Controller {

	/**
	 * Show the API documentation screen to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
		return view('documentation');
	}

}
