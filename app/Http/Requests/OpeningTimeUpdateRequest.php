<?php namespace App\Http\Requests;


class OpeningTimeUpdateRequest extends Request {

	private $rules = [
		'day_of_week' => 'sometimes|required|between:1,7',
		'opening_time' => 'sometimes|required|date_format:H:i:s',
		'closing_time' => 'sometimes|required|date_format:H:i:s',
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
