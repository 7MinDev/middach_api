<?php namespace App\Http\Requests;

use App;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Response;

class Request extends FormRequest {

	public function rules()
	{
		return [];
	}

	public function authorize()
	{
		return true;
	}

	public function response(array $errors)
	{
		if (App::environment('testing'))
		{
			return Response::json($errors, JsonResponse::HTTP_BAD_REQUEST);
		}

		return parent::response($errors);
	}


}
