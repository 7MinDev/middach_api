<?php

use LucaDegasperi\OAuth2Server\Authorizer;

class BaseController extends Controller {

	protected $authorizer;

	/**
	 * @param Authorizer $authorizer
	 */
	function __construct(Authorizer $authorizer)
	{
		$this->authorizer = $authorizer;

		$userId = $this->authorizer->getResourceOwnerId();
		$user = Sentinel::getUserRepository()->findById($userId);

		Sentinel::setUser($user);
	}

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}

}
