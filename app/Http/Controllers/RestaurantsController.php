<?php namespace App\Http\Controllers;
/**
 * @author pschmidt
 */

use App\Http\Requests\CreateRestaurantRequest;
use App\Repositories\Contracts\RestaurantRepositoryContract;
use Response;
use Sentinel;
use Symfony\Component\HttpFoundation\JsonResponse;

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
		parent::__construct();
		$this->restaurant = $restaurant;
	}

	/**
	 * @param CreateRestaurantRequest $request
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function create(CreateRestaurantRequest $request)
	{
		$data = $request->all();

		$data['user_id'] = Sentinel::getUser()->getUserId();

		return Response::json($this->restaurant->create($data));
	}

	/**
	 * @param null $restaurantId
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function show($restaurantId = null)
	{
		if ($restaurantId == null)
		{
			return Response::json([
				'status' => 'error',
				'message' => 'restaurantId param is missing'
			], JsonResponse::HTTP_BAD_REQUEST);
		}

		$restaurant = $this->restaurant->findById($restaurantId);

		return Response::json([
			'status' => 'ok',
			'data' => $restaurant]);
	}
}