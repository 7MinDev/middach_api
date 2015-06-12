<?php

/**
 * Base Testcase for all tests that need the authorization header (controllers)
 * because i dont have a clue how to disable middleware
 *
 * @author pschmidt
 */
class ControllerTestCase extends TestCase {

	private $access_token = 'oj1zALA5emd42XmmzbJRMSmO8ClRBySPuzcHlvvA';

    public function call($method, $uri, $parameters = [], $cookies = [], $files = [], $server = [], $content = null)
	{
//		$server['HTTP_Authorization'] = 'Bearer ' . $this->access_token;

		return parent::call($method, $uri, $parameters, $cookies, $files, $server, $content);
	}
}