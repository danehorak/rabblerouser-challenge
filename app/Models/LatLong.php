<?php namespace App\Models;

class LatLong {

	protected $address;

	/**
	 * Set Address.
	 *
	 * @param String An address to lookup the latitude and longitude
	 * @return LatLong
	 */
	public function setAddress($address)
	{
		$this->address = $address;

		// Do we need to urlencode the address? Lets just make sure
		$this->address = urldecode($this->address);

		return $this;
	}

	/**
	 * Get the Coordinates.
	 *
	 * @return void
	 */
	public function get()
	{
		// Geocoder Lookup
		$haystack = file_get_contents('http://geocoder.us/demo.cgi?address=' . urlencode($this->address));

		// Look for needle in haystack
		$needle = '"https://maps.google.com/maps?q=';
		$position = strpos($haystack, $needle);

		// Needle Found!
		if ($position !== FALSE) {
			// Grab 30 Characters after Needle
			$haystack = urldecode(substr($haystack, $position + strlen($needle), 30));

			// Get everything up to the first quotation
			$haystack = substr($haystack, 0, strpos($haystack, '"'));

			// Return Address, Lat, and Long
			$tmp = explode(',', $haystack);
			return ['lat'=>$tmp[0],'long'=>$tmp[1]];
		} else {
			return ['lat'=>0,'long'=>0];
		}
	}
}
