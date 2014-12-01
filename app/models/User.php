<?php

use Cartalyst\Sentinel\Users\EloquentUser;
use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

/**
 * User
 *
 * @property integer $id
 * @property string $email
 * @property string $password
 * @property string $permissions
 * @property string $last_login
 * @property string $first_name
 * @property string $last_name
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $username
 * @property-read \Illuminate\Database\Eloquent\Collection|\static::$rolesModel[] $roles
 * @property-read \Illuminate\Database\Eloquent\Collection|\static::$persistencesModel[] $persistences
 * @property-read \Illuminate\Database\Eloquent\Collection|\static::$activationsModel[] $activations
 * @property-read \Illuminate\Database\Eloquent\Collection|\static::$remindersModel[] $reminders
 * @property-read \Illuminate\Database\Eloquent\Collection|\static::$throttlingModel[] $throttle
 * @method static \Illuminate\Database\Query\Builder|\User whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\User whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\User wherePassword($value)
 * @method static \Illuminate\Database\Query\Builder|\User wherePermissions($value)
 * @method static \Illuminate\Database\Query\Builder|\User whereLastLogin($value)
 * @method static \Illuminate\Database\Query\Builder|\User whereFirstName($value)
 * @method static \Illuminate\Database\Query\Builder|\User whereLastName($value)
 * @method static \Illuminate\Database\Query\Builder|\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\User whereUsername($value)
 */
class User extends EloquentUser implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;

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
