<?php namespace App\Http\Requests;

class RestaurantCreateRequest extends Request
{
	private $rules = [
		'name' => 'required',
		'street' => 'required',
		'town' => 'required',
		'postal_code' => 'required'
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
