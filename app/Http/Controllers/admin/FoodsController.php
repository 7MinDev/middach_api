<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests\FoodsCreateRequest;
use App\Http\Requests\FoodsUpdateRequest;
use App\Repositories\Contracts\FoodRepositoryContract;
use Response;
use Sentinel;
use Symfony\Component\HttpFoundation\JsonResponse as Status;

/**
 * @author pschmidt
 */
class FoodsController extends BaseController
{
	/**
	 * @var FoodRepositoryContract
	 */
	private $repository;

	function __construct(FoodRepositoryContract $repository)
	{
		$this->repository = $repository;
		parent::__construct();
	}

	/**
	 * @param FoodsCreateRequest $request
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function create(FoodsCreateRequest $request)
	{
		$data = $request->all();
		$data['user_id'] = Sentinel::getUser()->getUserId();

		$food = $this->repository->create($data);

		return Response::json([
			'status' => 'ok',
			'data' => $food
		]);
	}

	/**
	 * @param $id
	 * @param FoodsUpdateRequest $request
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function update($id, FoodsUpdateRequest $request)
	{
		$food = $this->repository->findById($id);

		if (empty($food) || $food == null)
		{
			return Response::json([
				'status' => 'error',
				'message' => 'food with id ' . $id . ' not found.'
			], Status::HTTP_BAD_REQUEST);
		}

		if ($food->user_id != Sentinel::getUser()->getUserId())
		{
			return Response::json([
				'status' => 'error',
				'message' => 'foods user_id does not match the current user'
			], Status::HTTP_FORBIDDEN);
		}

		$data = $request->all();
		$food = $this->repository->update($id, $data);

		return Response::json([
			'status' => 'ok',
			'data' => $food,
		]);
	}
}
