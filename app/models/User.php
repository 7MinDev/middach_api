<?php namespace App\Models;

use Cartalyst\Sentinel\Users\EloquentUser;
use Illuminate\Database\Eloquent\Model;
/**
 * @author pschmidt
 */

class User extends EloquentUser {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * array of login column names
	 *
	 * @var array
	 */
	protected $loginNames = ['email', 'username'];

	protected $fillable = [
		'email',
		'username',
		'password',
		'first_name',
		'last_name',
		'permissions'
	];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password');

	/**
	 * Validation rules for registering users
	 *
	 * @var array
	 */
	public static $registrationRules = [
		'email' 					=> 'required|email|unique:users',
		'username' 					=> 'required|alpha|unique:users',
		'first_name' 				=> 'required|alpha|min:2',
		'last_name' 				=> 'required|alpha|min:2',
		'password' 					=> 'required|min:6|confirmed',
		'password_confirmation' 	=> 'required|min:6'
	];

	/**
	 * Validation rules for resetting user password
	 *
	 * @var array
	 */
	public static $resetRules = [
		'email'						=> 'required_without:username',
		'username'					=> 'required_without:email'
	];

	public static $passwordRules = [
		'password'					=> 'required|min:6|confirmed',
		'password_confirmation'		=> 'required|min:6'
	];
}