<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Http\Request;
use App\Models\Location;
use App\Models\LatLong;

class LocationController extends Controller {

	/**
	 * Location Repository
	 *
	 * @var Location
	 */
	protected $location;

	/**
	 * LatLong Helper
	 *
	 * @var LatLong
	 */
	protected $latlong;

	/**
	 * Instantiate LocationController
	 *
	 * @param  Location
	 * @return LocationController
	 */
	public function __construct()
	{
		$this->location = \App::make('App\Models\Location');
		$this->latlong = \App::make('App\Models\LatLong');
	}

	/**
	 * Create a Location.
	 *
	 * @return Response
	 */
	public function store($parent_id = NULL)
	{
		// Post Variables
		$input = \Input::all();

		// Helper to Find Lat Long
		if (isset($input['address'])) {

			// Get LatLong
			$latlong = $this->latlong->setAddress($input['address'])->get();

			// Set Parent Id; Perhaps we are creating a child Location
			$input['parent_id'] = is_null($parent_id) ? 0 : $parent_id;

			// Merge LatLong Data with Address Data
			$input = array_merge($input, $latlong);

		// Bad Post Data
		} else {
			throw new HttpException(400, 'Expected POST parameters not found. Please see API documentation.');
		}

		// Check Lat Long
		if (!isset($input['lat']) OR !isset($input['long']) OR ($input['lat'] == 0 AND $input['long'] == 0))
			throw new HttpException(400, 'Unable to accurately determine Latitude and Longitude. Please try adjusting the supplied Address.');

		// Validate Input
		if (!$this->location->isValid($input))
			throw new HttpException(400, 'Something is wrong. Please try reformatting your address.');

		// Store the Address and Associated Lat Long
		return $this->location->firstOrCreate($input);
	}

	/**
	 * Display a listing of Locations.
	 *
	 * @return Response
	 */
	public function index($id = NULL)
	{
		if (!is_null($id))
			return $this->location->findChildren($id);

		return $this->location->all();
	}

	/**
	 * Display the specified Location.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		return $this->location->find($id);
	}

	/**
	 * Update the specified Location.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		// Get Current Location
		$location = $this->location->find($id);

		// Put Variables
		$input = \Input::all();

		// Helper to Find Lat Long
		if (isset($input['address'])) {

			// Get LatLong
			$latlong = $this->latlong->setAddress($input['address'])->get();

			// Update Lat, Long, Address
			$location->lat = $latlong['lat'];
			$location->long = $latlong['long'];
			$location->address = $input['address'];

		// Bad Post Data
		} else {
			throw new HttpException(400, 'Expected POST parameters not found. Please see API documentation.');
		}

		// Validate Input
		if (!$this->location->isValid($location->toArray()))
			throw new HttpException(400, 'Something is wrong. Please try reformatting your address.');

		// Store the Address and Associated Lat Long
		$location->save();
		return $location;
	}

	/**
	 * Find closest ancestor.
	 *
	 * @param  int  $id1
	 * @param  int  $id2
	 * @return Response
	 */
	public function ancestor($id1, $id2)
	{
		return $this->location->findClosestAncestor($id1, $id2);
	}

	/**
	 * Remove the specified Location.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		if ($location = $this->location->find($id)){
			foreach ($location->findChildren($id) as $child)
				$child->delete();
			$location->delete();
		}
		return '';
	}

}
