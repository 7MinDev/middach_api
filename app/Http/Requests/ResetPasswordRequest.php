<?php namespace App\Http\Requests;

class ResetPasswordRequest extends Request {

	/**
	 * Validation rules for resetting user password
	 *
	 * @var array
	 */
	private $rules = [
		'loginName' => 'required'
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
