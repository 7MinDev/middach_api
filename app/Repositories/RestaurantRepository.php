<?php namespace App\Repositories;

use App\Models\Restaurant;
use App\Repositories\Contracts\RestaurantRepositoryContract;
use App\Repositories\Traits\CallOnUnderlyingModel;

/**
 * @author pschmidt
 */
class RestaurantRepository implements RestaurantRepositoryContract
{
	use CallOnUnderlyingModel;

	/**
	 * @var Restaurant
	 */
	private $model;

	/**
	 * @param Restaurant $restaurant
	 */
	function __construct(Restaurant $restaurant)
	{
		$this->model = $restaurant;
	}

	/**
	 * find by id
	 *
	 * @param $id
	 * @return mixed
	 */
	public function findById($id)
	{
		// TODO: Implement findById() method.
	}


	/**
	 * create a new restaurant
	 *
	 * @param $data
	 * @return Restaurant
	 */
	public function create($data)
	{
		return $this->model->create($data);
	}
}