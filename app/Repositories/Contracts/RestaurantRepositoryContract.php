<?php namespace App\Repositories\Contracts;

/**
 * @author pschmidt
 */

interface RestaurantRepositoryContract {

	/**
	 * find by id
	 *
	 * @param $id
	 * @return mixed
	 */
	public function findById($id);

	/**
	 * create a new restaurant
	 *
	 * @param $data
	 * @return mixed
	 */
	public function create($data);
}