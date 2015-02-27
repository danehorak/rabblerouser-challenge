<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model {

	protected $table = 'location';

	protected $fillable = ['parent_id', 'address', 'lat', 'long'];

	public $timestamps = false;

	public function findChildren($id)
	{
		// All Decendants
		$offspring = array();

		// Immediate children
		$children = $this->where('parent_id', '=', $id)->get();

		// Find Children's Children
		foreach($children as $child) {
			$offspring[] = $child;
			$offspring = array_merge($offspring, $this->findChildren($child['id']));
		}

		return $offspring;
	}
    /**
	 * Find closest ancestor.
	 *
	 * @param  int  Location 1 id
	 * @param  int  Location 2 id
	 * @return Array
	 */
	public function findClosestAncestor($id1, $id2)
	{
		// Ancestors for Location1
		$A1 = array();

		// Ancestors for Location2
		$A2 = array();

		// Find Location1 and Location2 Parents
		$L1['parent_id'] = $id1;
		$L2['parent_id'] = $id2;
		do {
			if ($L1['parent_id'] > 0) {
				$L1 = $this->find($L1['parent_id'])->toArray();
				$A1[] = $L1['id'];
			}
			if ($L2['parent_id'] > 0) {
				$L2 = $this->find($L2['parent_id'])->toArray();
				$A2[] = $L2['id'];
			}
		} while ($L1['parent_id'] > 0 OR $L2['parent_id'] > 0);

		// Common Ancestors
		$common = array_intersect($A1, $A2);

		// Return the closest shared ancestor
		if (count($common) > 0) {
			return $this->find(head($common));

		// No shared ancestors
		} else {
			return [];
		}
	}

	public function isValid($data)
	{
		foreach ($this->fillable as $field)
			if (!isset($data[$field]))
				return FALSE;
		return TRUE;
	}

}
