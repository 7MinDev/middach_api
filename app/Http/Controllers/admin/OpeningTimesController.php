<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests\OpeningTimeCreateRequest;
use App\Repositories\Contracts\OpeningTimeRepositoryContract;
use Response;

/**
 * @author pschmidt
 */
class OpeningTimesController extends BaseController
{
	/**
	 * @var OpeningTimeRepositoryContract
	 */
	private $openingTime;

	function __construct(OpeningTimeRepositoryContract $openingTime)
	{
		$this->openingTime = $openingTime;
		parent::__construct();
	}

	/**
	 * @param OpeningTimeCreateRequest $request
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function create(OpeningTimeCreateRequest $request)
	{
		$openingTime = $this->openingTime->create($request->all());

		return Response::json([
			'status' => 'ok',
			'data' => $openingTime
		]);
	}
}