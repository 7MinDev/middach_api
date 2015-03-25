<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests\CreateRestaurantRequest;
use App\Repositories\Contracts\RestaurantRepositoryContract;
use Response;

/**
 * @author pschmidt
 */
class RestaurantsController extends BaseController
{
	/**
	 * @var RestaurantRepositoryContract
	 */
	private $restaurant;

	/**
	 * @param RestaurantRepositoryContract $restaurant
	 */
	public function __construct(RestaurantRepositoryContract $restaurant)
	{
		$this->restaurant = $restaurant;
		parent::__construct();
	}

	/**
	 * @param CreateRestaurantRequest $request
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function create(CreateRestaurantRequest $request)
	{
		$data = $request->all();

		$data['user_id'] = $this->userId;

		return Response::json([
			'status' => 'ok',
			'data' => $this->restaurant->create($data)]);
	}
}