<?php namespace App\Http\Requests;


class FoodsUpdateRequest extends Request
{
	private $rules = [
		'title' => 'sometimes|required',
		'price' => 'sometimes|required|numeric',
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
