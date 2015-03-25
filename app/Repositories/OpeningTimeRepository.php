<?php namespace App\Repositories;

use App\Models\OpeningTime;
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
}
