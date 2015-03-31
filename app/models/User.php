<?php namespace App\Models;

use Cartalyst\Sentinel\Users\EloquentUser;

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
	 * restaurants relationship
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function restaurants()
	{
		return $this->hasMany(Restaurant::class, 'user_id');
	}

	/**
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function menus()
	{
		return $this->hasMany(Menu::class, 'user_id');
	}
}