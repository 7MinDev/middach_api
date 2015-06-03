<?php
use App\Models\User;

/**
 * Base Testcase for all tests that need the authorization header (controllers)
 * because i dont have a clue how to disable middleware
 *
 * @author pschmidt
 */
class ControllerTestCase extends TestCase {

	private $access_token = 'oj1zALA5emd42XmmzbJRMSmO8ClRBySPuzcHlvvA';

	protected $ignore_authorization = false;

	public function setUp()
	{
		parent::setUp();

		/**
		 * @var $user User
		 */
		$user = User::find(1);
		Sentinel::setUser($user);
	}


	/**
	 * @param boolean $ignore_authorization
	 */
	protected function setIgnoreAuthorization($ignore_authorization)
	{
		$this->ignore_authorization = $ignore_authorization;
	}
}