<?php namespace App\Http\Controllers;
use App\Models\User;
use Authorizer;
use Sentinel;

/**
 * @author pschmidt
 */
class BaseController extends Controller
{
	/**
	 * sets the authorized user as the logged in Sentinel user
	 */
	function __construct()
	{
		$ownerId = Authorizer::getResourceOwnerId();
		Sentinel::setUser(User::find($ownerId)->first());
	}
}