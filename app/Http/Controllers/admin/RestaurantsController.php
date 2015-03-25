<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests\RestaurantCreateRequest;
use App\Http\Requests\RestaurantUpdateRequest;
use App\Repositories\Contracts\RestaurantRepositoryContract;
use Response;
use Sentinel;
use Symfony\Component\HttpFoundation\Response as Status;

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
	 * @param RestaurantCreateRequest $request
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function create(RestaurantCreateRequest $request)
	{
		$data = $request->all();

		$data['user_id'] = $this->userId;

		return Response::json([
			'status' => 'ok',
			'data' => $this->restaurant->create($data)]);
	}

	public function update($id, RestaurantUpdateRequest $request)
	{
		$restaurant = $this->restaurant->findById($id);

		if ($restaurant->user_id != Sentinel::getUser()->getUserId())
		{
			return Response::json([
				'status' => 'error',
				'message' => 'restaurant does not belong to the current user.'
			], Status::HTTP_FORBIDDEN);
		}

		$data = $request->all();

		return Response::json([
			'status' => 'ok',
			'data' => $this->restaurant->update($id, $data)
		]);
	}

	/**
	 *
	 * @param $id
	 * @return Status
	 */
	public function delete($id)
	{
		$restaurant = $this->restaurant->findById($id);

		if ($restaurant->owner->id != Sentinel::getUser()->getUserId())
		{
			return Response::json([
				'status' => 'error',
				'message' => 'Deleting failed because the restaurants owner does not match the current user.'
			], Status::HTTP_FORBIDDEN);
		}

		if (!$this->restaurant->delete($id))
		{
			return Response::json([
				'status' => 'error',
				'message' => 'Something went wrong while deleting the restaurant with the id: ' . $id
			], Status::HTTP_INTERNAL_SERVER_ERROR);
		}

		return Response::json([
			'status' => 'ok'
		]);
	}
}
