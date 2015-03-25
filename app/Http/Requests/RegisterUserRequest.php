<?php namespace App\Http\Requests;

class RegisterUserRequest extends Request {

	/**
	 * Validation rules for registering users
	 *
	 * @var array
	 */
	private $rules = [
		'email' 					=> 'required|email|unique:users',
		'username' 					=> 'required|alpha|unique:users',
		'first_name' 				=> 'required|alpha|min:2',
		'last_name' 				=> 'required|alpha|min:2',
		'password' 					=> 'required|min:6|confirmed',
		'password_confirmation' 	=> 'required|min:6'
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
