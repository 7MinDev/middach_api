<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests\OpeningTimeCreateRequest;
use App\Http\Requests\OpeningTimeUpdateRequest;
use App\Models\User;
use App\Repositories\Contracts\OpeningTimeRepositoryContract;
use Response;
use Sentinel;
use Symfony\Component\HttpFoundation\Response as Status;

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

    /**
     * @param $id
     * @param OpeningTimeUpdateRequest $request
     * @return Status
     */
    public function update($id, OpeningTimeUpdateRequest $request)
    {
        $openingTime = $this->openingTime->findById($id);

        $owner = $openingTime->restaurant->owner;

        if ($owner->id != Sentinel::getUser()->getUserId()) {
            return Response::json([
                'status' => 'error',
                'message' => 'Trying to update opening time of a restaurant which does not belong to the current user.'
            ], Status::HTTP_FORBIDDEN);
        }
        $data = $request->all();

        $openingTime = $this->openingTime->update($id, $data);

        return Response::json([
            'status' => 'ok',
            'data' => $openingTime
        ]);
    }

    public function delete($id)
    {
        $openingTime = $this->openingTime->findById($id);

        $owner = $openingTime->restaurant->owner;

        if ($owner->id != Sentinel::getUser()->getUserId()) {
            return Response::json([
                'status' => 'error',
                'message' => 'Trying to delete opening time of a restaurant which does not belong to the current user'
            ], Status::HTTP_FORBIDDEN);
        }

        if (!$this->openingTime->delete($id)) {
            return Response::json([
                'status' => 'error',
                'message' => 'Something went wrong while deleting the opening time id: ' . $id
            ], Status::HTTP_INTERNAL_SERVER_ERROR);
        }

        return Response::json([
            'status' => 'ok'
        ]);
    }
}
