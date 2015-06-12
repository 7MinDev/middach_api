<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller as Controller;
use App\Models\User;
use Authorizer;
use Sentinel;

/**
 * @author pschmidt
 */
class BaseController extends Controller
{

	protected $userId;

	/**
	 * sets the authorized user as the logged in Sentinel user
	 */
	function __construct()
	{
		if (Authorizer::getChecker()->getAccessToken() != null)
		{
			$this->userId = Authorizer::getResourceOwnerId();
			Sentinel::setUser(User::find($this->userId)->first());
		}
	}
}
