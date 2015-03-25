<?php namespace App\Http\Requests;

class RestaurantUpdateRequest extends Request {

	private $rules = [
		'name' => 'sometimes|required',
		'street' => 'sometimes|required',
		'town' => 'sometimes|required',
		'postal_code' => 'sometimes|required'
	];

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return $this->rules;
	}

}
