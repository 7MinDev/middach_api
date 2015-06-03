<?php namespace App\Repositories;

use App\Models\Food;
use App\Repositories\Contracts\FoodRepositoryContract;
use App\Repositories\Traits\CallOnUnderlyingModel;

/**
 * @author pschmidt
 */
class FoodRepository implements FoodRepositoryContract
{
	use CallOnUnderlyingModel;

	/**
	 * @var Food
	 */
	private $model;

	/**
	 * @param Food $model
	 */
	function __construct(Food $model)
	{
		$this->model = $model;
	}


	/**
	 * @param $data
	 * @return Food
	 */
	public function create($data)
	{
		$food = $this->model->create($data);
		return $food;
	}

	/**
	 * @param $id
	 * @return Food
	 */
	public function findById($id)
	{
		return $this->model->find($id);
	}


	/**
	 * @param $id
	 * @param $data
	 * @return Food
	 */
	public function update($id, $data)
	{
		$food = $this->findById($id);

		$food->fill($data);
		$food->save();

		return $food;
	}
}
