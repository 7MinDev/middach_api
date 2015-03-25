<?php namespace App\Repositories\Contracts; 
/**
 * @author pschmidt
 */
interface OpeningTimeRepositoryContract {

	/**
	 * @param $data
	 * @return mixed
	 */
	public function create($data);

	/**
	 * @param $restaurant_id
	 * @return mixed
	 */
	public function findAllByRestaurantId($restaurant_id);

	/**
	 * @param $id
	 * @return mixed
	 */
	public function findById($id);

	/**
	 * @param $id
	 * @param $data
	 * @return mixed
	 */
	public function update($id, $data);

	/**
	 * @param $id
	 * @return bool
	 */
	public function delete($id);
}