<?php namespace App\Repositories\Contracts;
use App\Models\Food;

/**
 * @author pschmidt
 */
interface FoodRepositoryContract
{
	/**
	 * @param $data
	 * @return Food
	 */
	public function create($data);

	/**
	 * @param $id
	 * @param $data
	 * @return Food
	 */
	public function update($id, $data);

	/**
	 * @param $id
     * @param $relations
	 * @return mixed
	 */
	public function findById($id, $relations = []);
}
