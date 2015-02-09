<?php namespace App\Http\Requests;

class ProcessResetPasswordRequest extends Request {

	/**
	 *
	 * @var array
	 */
	private $rules = [
		'userId'					=> 'required',
		'code'						=> 'required',
		'password'					=> 'required|min:6|confirmed',
		'password_confirmation'		=> 'required|min:6'
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
