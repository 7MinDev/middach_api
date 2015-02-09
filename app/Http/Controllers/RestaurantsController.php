<?php namespace App\Http\Controllers;
/**
 * @author pschmidt
 */

use App\Http\Requests\CreateRestaurantRequest;
use App\Repositories\Contracts\RestaurantRepositoryContract;
use Response;
use Sentinel;

class RestaurantsController extends Controller
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
	}


	public function create(CreateRestaurantRequest $request)
	{
		$data = $request->all();

		$data['user_id'] = Sentinel::getUser()->getUserId();

		return Response::json($this->restaurant->create($data));
	}
}