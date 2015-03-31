<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests\MenuCreateRequest;
use App\Http\Requests\MenuUpdateRequest;
use App\Repositories\Contracts\MenuRepositoryContract;
use Response;
use Sentinel;
use Symfony\Component\HttpFoundation\JsonResponse as Status;

/**
 * @author pschmidt
 */
class MenusController extends BaseController
{
	/**
	 * @var MenuRepositoryContract
	 */
	private $repository;

	/**
	 * @param MenuRepositoryContract $repository
	 */
	function __construct(MenuRepositoryContract $repository)
	{
		$this->repository = $repository;
		parent::__construct();
	}


	/**
	 * @param MenuCreateRequest $request
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function create(MenuCreateRequest $request)
	{
		$userId = Sentinel::getUser()->getUserId();
		$data = $request->all();
		$data['user_id'] = $userId;

		$menu = $this->repository->create($data);

		return Response::json([
			'status' => 'ok',
			'data' => $menu
		]);
	}

	/**
	 * @param $id
	 * @param MenuUpdateRequest $request
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function update($id, MenuUpdateRequest $request)
	{
		$userId = Sentinel::getUser()->getUserId();

		$menu = $this->repository->findById($id);

		if ($menu->user->id != $userId)
		{
			return Response::json([
				'status' => 'error',
				'message' => 'Menus User ID does not match the current user.'
			], Status::HTTP_FORBIDDEN);
		}

		$menu = $this->repository->update($id, $request->all());

		return Response::json([
			'status' => 'ok',
			'data' => $menu
		]);
	}

	/**
	 * @param $id
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function delete($id)
	{
		$userId = Sentinel::getUser()->getUserId();
		$menu = $this->repository->findById($id);

		if ($menu->user->id != $userId)
		{
			return Response::json([
				'status' => 'error',
				'message' => 'Menus User ID does not match the current user.'
			], Status::HTTP_FORBIDDEN);
		}

		if (!$this->repository->delete($id))
		{
			return Response::json([
				'status' => 'error',
				'message' => 'Something went wrong while deleting the menu with id ' . $id
			], Status::HTTP_INTERNAL_SERVER_ERROR);
		}

		return Response::json([
			'status' => 'ok',
		]);
	}
}