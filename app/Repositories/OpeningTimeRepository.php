<?php namespace App\Repositories;

use App\Models\OpeningTime;
use App\Models\Restaurant;
use App\Repositories\Contracts\OpeningTimeRepositoryContract;
use App\Repositories\Traits\CallOnUnderlyingModel;

/**
 * @author pschmidt
 */
class OpeningTimeRepository implements OpeningTimeRepositoryContract
{
	use CallOnUnderlyingModel;

	/**
	 * @var OpeningTime
	 */
	protected $model;

	/**
	 * @param OpeningTime $openingTime
	 */
	function __construct(OpeningTime $openingTime)
	{
		$this->model = $openingTime;
	}

	/**
	 * @param $data
	 * @return mixed
	 */
	public function create($data)
	{
		return $this->model->create($data);
	}

	/**
	 * @param $restaurant_id
	 * @return static
	 */
	public function findAllByRestaurantId($restaurant_id)
	{
		return $this->model->all()
			->where('restaurant_id', $restaurant_id);
	}

	/**
	 * @param $id
	 * @return OpeningTime
	 */
	public function findById($id)
	{
		return $this->model->find($id);
	}

	/**
	 * @param $id
	 * @param $data
	 * @return OpeningTime
	 */
	public function update($id, $data)
	{
		$openingTime = $this->findById($id);

		$openingTime->fill($data);
		$openingTime->save();

		return $openingTime;
	}

	/**
	 * @param $id
	 * @return bool
	 */
	public function delete($id)
	{
		$openingTime = $this->findById($id);

		if ($openingTime->delete())
		{
			return true;
		}

		return false;
	}


}
