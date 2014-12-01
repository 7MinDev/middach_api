<?php
use League\OAuth2\Server\Exception\InvalidCredentialsException;
use League\OAuth2\Server\Exception\InvalidRequestException;

/**
 * Tests for the AuthenticationController class
 *
 * Tests are separated into 2 categories:
 * - first we check if our routes work by calling them and receiving correct responses
 * - second we check if the controller logic works
 *
 * @author pschmidt
 */

class AuthenticationControllerTest extends TestCase {

	/*
	 * Basic route tests
	 */

	/**
	 * POST request without data should result in a client error.
	 * @test
	 */
	public function testLoginReturnsErrorWithoutData()
	{
		try {
			$this->call('POST', route('login'));
		}
		catch (InvalidRequestException $e)
		{
			return;
		}

		$this->fail('InvalidRequestException was not thrown.');
	}

	/**
	 * POST request with OAuth2 fields but without credentials should result in an error.
	 *
	 * @test
	 */
	public function testLoginReturnsErrorWithoutCredentials()
	{
		try {
			$credentials = [
				'grant_type' => 'password',
				'client_id' => 'testClient',
				'client_secret' => 'testSecret',
			];

			$this->call('POST', route('login'), $credentials);
		}
		catch (InvalidRequestException $e)
		{
			return;
		}

		$this->fail('InvalidRequestException was not thrown.');
	}

	/**
	 * POST request with correct data (username as username)
	 * should result in a 200 response with a valid token
	 *
	 * @test
	 */
	public function testLoginWithValidUsernameCredentials()
	{
		$credentials = [
			'grant_type' => 'password',
			'client_id' => 'testClient',
			'client_secret' => 'testSecret',
			'username' => 'testuser',
			'password' => 'test'
		];

		$response = $this->call('POST', route('login'), $credentials);

		$this->assertTrue($response->isOk(), 'Response was not ok.');

		$this->assertNotEmpty($response->getContent(), 'Response content is empty');

		$jsonResponse = json_decode($response->getContent());
		$token = $jsonResponse->access_token;

		$this->assertNotEmpty($token, 'Token is empty');
	}

	/**
	 * POST request with correct data (email as username)
	 * should result in a 200 response with a valid token
	 *
	 * @test
	 */
	public function testLoginWithValidEmailCredentials()
	{
		$credentials = [
			'grant_type' => 'password',
			'client_id' => 'testClient',
			'client_secret' => 'testSecret',
			'username' => 'testuser@test.de',
			'password' => 'test'
		];

		$response = $this->call('POST', route('login'), $credentials);

		$this->assertTrue($response->isOk(), 'Response was not ok.');

		$this->assertNotEmpty($response->getContent(), 'Response content is empty');

		$jsonResponse = json_decode($response->getContent());
		$token = $jsonResponse->access_token;

		$this->assertNotEmpty($token, 'Token is empty');
	}

	/**
	 * POST request /login with incorrect login data
	 * should result in an error
	 *
	 * @test
	 */
	public function testLoginWithInvalidCredentials()
	{
		$credentials = [
			'grant_type' => 'password',
			'client_id' => 'testClient',
			'client_secret' => 'testSecret',
			'username' => 'wronguser',
			'password' => 'testwhat'
		];

		try {
			$this->call('POST', route('login'), $credentials);
		}
		catch (InvalidCredentialsException $e)
		{
			return;
		}

		$this->fail('InvalidCredentialsException was not thrown.');
	}

	/**
	 * Testing validation rules (mostly the 'required' ones)
	 * (this should be validated by the client anyway but for sure)
	 *
	 * @test
	 */
	public function testRegistrationValidationRules()
	{
		/*
		 * 1. forgot the username
		 */
		$userData = [
			'email' => 'johndoe@example.com',
			'first_name' => 'John',
			'last_name' => 'Doe',
			'password' => 'test123!',
			'password_confirmation' => 'test123!'
		];

		$response = $this->call('POST', route('register'), $userData);

		$this->assertTrue($response->isClientError(),
			'Response code was not an error');

		/*
		 * 2. forgot email
		 */
		unset($userData['email']);
		$userData['username'] = 'johndoe';

		$response = $this->call('POST', route('register'), $userData);

		$this->assertTrue($response->isClientError(),
			'Response code was not an error');

		/*
		 * 3. validating email
		 */
		$userData['email'] = 'johndoe';

		$response = $this->call('POST', route('register'), $userData);

		$this->assertTrue($response->isClientError(),
			'Response code was not an error');

		/*
		 * 4. forgot first_name
		 */

		$userData['email'] = 'johndoe@example.com';
		unset($userData['first_name']);

		$response = $this->call('POST', route('register'), $userData);

		$this->assertTrue($response->isClientError(),
			'Response code was not an error');

		/*
		 * 5. forgot last_name
		 */
		$userData['first_name'] = 'John';
		unset($userData['last_name']);

		$response = $this->call('POST', route('register'), $userData);

		$this->assertTrue($response->isClientError(),
			'Response code was not an error');

		/*
		 * 6. forgot password
		 */

		$userData['last_name'] = 'Doe';
		unset($userData['password']);

		$response = $this->call('POST', route('register'), $userData);

		$this->assertTrue($response->isClientError(),
			'Response code was not an error');

		/*
		 * 7. password confirmation doesnt match password field
		 */
		$userData['password'] = 'test123!';
		$userData['password_confirmation'] = 'anotherpassword';

		$response = $this->call('POST', route('register'), $userData);

		$this->assertTrue($response->isClientError(),
			'Response code was not an error');

		/*
		 * 8. unique email
		 */
		$userData['email'] = 'testuser@test.de';

		$response = $this->call('POST', route('register'), $userData);

		$this->assertTrue($response->isClientError(),
			'Response code was not an error');

		/*
		 * 9. unique username
		 */
		$userData['username'] = 'testuser';

		$response = $this->call('POST', route('register'), $userData);

		$this->assertTrue($response->isClientError(),
			'Response code was not an error');
	}

	/**
	 * Test a valid registration process
	 * It should return a 200 OK
	 *
	 * @test
	 */
	public function testRegistrationWithValidUserData()
	{
		$userData = [
			'email' => 'johndoe@example.com',
			'username' => 'johndoe',
			'first_name' => 'John',
			'last_name' => 'Doe',
			'password' => 'test123!',
			'password_confirmation' => 'test123!'
		];

		$response = $this->call('POST', route('register'), $userData);

		$this->assertTrue($response->isOk(),
			'Response code was an error');
	}

	/**
	 * test a invalid activation code
	 *
	 * @test
	 */
	public function testRegistrationInvalidActivation()
	{
		$userData = [
			'email' => 'johndoe@example.com',
			'username' => 'johndoe',
			'first_name' => 'John',
			'last_name' => 'Doe',
			'password' => 'test123!',
		];

		// just call sentinel register directly without any validation
		$user = Sentinel::register($userData);

		// create activation entry for that user
		Activation::create($user);

		// .. and forget the activation code
		$code = 'somesillycode12385';

		$activationData = [
			'userId' => $user->id,
			'code' => $code,
		];

		$response = $this->call('POST', route('activate'), $activationData);

		$this->assertTrue($response->isClientError(),
			'Response was not an error');
	}

	/**
	 * Test a valid activation
	 *
	 * @test
	 */
	public function testRegistrationValidActivation()
	{
		$userData = [
			'email' => 'johndoe@example.com',
			'username' => 'johndoe',
			'first_name' => 'John',
			'last_name' => 'Doe',
			'password' => 'test123!',
		];

		// just call sentinel register directly without any validation
		$user = Sentinel::register($userData);

		// create activation entry for that user
		$activation = Activation::create($user);

		// .. and get the correct activation code
		$code = $activation->code;

		$activationData = [
			'userId' => $user->id,
			'code' => $code,
		];

		$response = $this->call('POST', route('activate'), $activationData);

		$this->assertTrue($response->isOk(),
			'Response was an error');
	}

	/**
	 *
	 * @test
	 */
	public function testRequestPasswordResetWithInvalidCredentials()
	{
		$credentials = [];

		/*
		 * 1. no userdata at all
		 */
		$response = $this->call('POST', route('reset'));

		$this->assertTrue($response->isClientError(),
			'Response was not an client error');

		/*
		 * 2. test invalid username
		 */
		$credentials['loginName'] = 'darthvader';
		$response = $this->call('POST', route('reset'), $credentials);

		$this->assertTrue($response->isClientError(),
			'Response was not an client error');

		/*
		 * 3. test invalid email
		 */
		$credentials['loginName'] = 'darthvader@deathstar.sw';
		$response = $this->call('POST', route('reset'), $credentials);

		$this->assertTrue($response->isClientError(),
			'Response was not an client error');
	}

	/**
	 * Test
	 *
	 * @test
	 */
	public function testRequestPasswordResetWithValidUserName()
	{
		$credentials = ['loginName' => 'testuser'];

		$response = $this->call('POST', route('reset'), $credentials);

		$this->assertTrue($response->isOk(),
			'Response was an error');
	}

	/**
	 *
	 * @test
	 */
	public function testRequestPasswordResetWithValidEmail()
	{
		$credentials = ['loginName' => 'testuser@test.de'];

		$response = $this->call('POST', route('reset'), $credentials);

		$this->assertTrue($response->isOk(),
			'Response was an error');
	}

	/**
	 *
	 * @test
	 */
	public function testCompleteInvalidPasswordReset()
	{
		$user = Sentinel::getUserRepository()->findById(1);
		Reminder::create($user);

		$data = [
			'userId' => $user->getUserId(),
			'code' => 'tadaThisIsAWrongCode',
			'password' => 'lalala',
			'password_confirmation' => 'lalala'
		];

		$response = $this->call('POST', route('processReset'), $data);

		$this->assertTrue($response->isClientError(),
			'Response was not an error');
	}

	/**
	 *
	 * @test
	 */
	public function testCompleteValidPasswordReset()
	{
		$user = Sentinel::getUserRepository()->findById(1);
		$reminder = Reminder::create($user);

		$password = 'NewTest123!';

		$data = [
			'userId' => $user->getUserId(),
			'code' => $reminder->code,
			'password' => $password,
			'password_confirmation' => $password
		];

		$response = $this->call('POST', route('processReset'), $data);

		$this->assertTrue($response->isOk(),
			'Response was not an error');

		// try login with the new password

		$credentials = [
			'grant_type' => 'password',
			'client_id' => 'testClient',
			'client_secret' => 'testSecret',
			'username' => 'testuser@test.de',
			'password' => $password
		];

		$response = $this->call('POST', route('login'), $credentials);

		$this->assertTrue($response->isOk(), 'Response was not ok.');

		$this->assertNotEmpty($response->getContent(), 'Response content is empty');

		$jsonResponse = json_decode($response->getContent());
		$token = $jsonResponse->access_token;

		$this->assertNotEmpty($token, 'Token is empty');
	}
}
