<?php namespace App\Repositories;

use App\Models\Restaurant;
use App\Repositories\Contracts\RestaurantRepositoryContract;
use App\Repositories\Traits\CallOnUnderlyingModel;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
	 * Get a restaurant by its id
	 *
	 * @param $id
	 * @return mixed|null
	 */
	public function findById($id)
	{
		return $this->model->find($id);
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

	/**
	 * update a restaurant
	 *
	 * @param $id
	 * @param $data
	 * @return mixed
	 */
	public function update($id, $data)
	{
		$restaurant = $this->findById($id);

		if (!$restaurant || empty($restaurant))
		{
			throw new NotFoundHttpException;
		}

		$restaurant->fill($data);
		$restaurant->save();

		return $restaurant;
	}

	/**
	 * delete a restaurant with the given id
	 *
	 * @param $id
	 * @return bool
	 */
	public function delete($id)
	{
		$restaurant = $this->findById($id);

		if ($restaurant->delete())
		{
			return true;
		}

		return false;
	}


}