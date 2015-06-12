<?php

use App\Models\User;
use Cartalyst\Sentinel\Laravel\Facades\Reminder;

/**
 * Tests for the AuthenticationController class
 *
 * TODO rewrite these tests, they are shit
 *
 * @author pschmidt
 */
class AuthenticationControllerTest extends TestCase
{
    /**
     *
     * @test
     */
    public function generate_no_warning_until_tests_are_rewritten()
    {
        $this->assertTrue(true);
    }

    /**
     * POST request without data should result in a client error.
     *
     * test
     */
    public function login_should_fail_without_any_data()
    {
        $response = $this->call('POST', route('login'));
        $this->assertTrue($response->isClientError(), 'Response was not an client error.');
    }

    /**
     * POST request with OAuth2 fields but without credentials should result in an error.
     *
     * test
     */
    public function login_should_fail_without_credential_data()
    {
        $credentials = [
            'grant_type' => 'password',
            'client_id' => 'testClient',
            'client_secret' => 'testSecret',
        ];

        $response = $this->call('POST', route('login'), $credentials);
        $this->assertTrue($response->isClientError(), 'Response was not an client error');
    }

    /**
     * POST request with correct data (username as username)
     * should result in a 200 response with a valid token
     *
     * test
     */
    public function login_should_succeed_with_valid_username_credentials()
    {
        factory(User::class)->create([
            'username' => 'testuser',
            'password' => Crypt::encrypt('test'),
        ]);

        // TODO create/mock a OAuthClient

        $credentials = [
            'grant_type' => 'password',
            'client_id' => 'testClient',
            'client_secret' => 'testSecret',
            'username' => 'testuser',
            'password' => 'test'
        ];

        $response = $this->call('POST', route('login'), $credentials);

        $this->assertTrue($response->isOk(), 'Response was not ok.' . $response);

        $this->assertNotEmpty($response->getContent(), 'Response content is empty');

        $jsonResponse = json_decode($response->getContent());
        $token = $jsonResponse->access_token;

        $this->assertNotEmpty($token, 'Token is empty');
    }

    /**
     * POST request with correct data (email as username)
     * should result in a 200 response with a valid token
     *
     * TODO rewrite tests
     * test
     */
    public function login_should_succeed_with_valid_email_credentials()
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
     * test
     */
    public function login_should_fail_with_invalid_credentials()
    {
        $credentials = [
            'grant_type' => 'password',
            'client_id' => 'testClient',
            'client_secret' => 'testSecret',
            'username' => 'wronguser',
            'password' => 'testwhat'
        ];

        $response = $this->call('POST', route('login'), $credentials);

        $this->assertTrue($response->isClientError(), 'Response was not an client error');
    }

    /**
     * Test a valid registration process
     * It should return a 200 OK
     *
     * test
     */
    public function registration_should_succeed_with_valid_user_data()
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
            'Response code was an error' . $response);
    }

    /**
     * test a invalid activation code
     *
     * test
     */
    public function activation_should_fail_because_of_a_invalid_token()
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
     * test
     */
    public function registration_should_succeed_with_a_valid_token()
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
     * test
     */
    public function request_password_reset_should_fail_with_invalid_credentials()
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
     * TODO rewrite tests
     * test
     */
    public function request_password_reset_should_succeed_with_valid_username()
    {
        $credentials = ['loginName' => 'testuser'];

        $response = $this->call('POST', route('reset'), $credentials);

        $this->assertTrue($response->isOk(),
            'Response was an error');
    }

    /**
     * TODO rewrite
     *
     * test
     */
    public function request_password_reset_should_succeed_with_valid_email()
    {
        $credentials = ['loginName' => 'testuser@test.de'];

        $response = $this->call('POST', route('reset'), $credentials);

        $this->assertTrue($response->isOk(),
            'Response was an error');
    }

    /**
     * TODO rewrite
     *
     * test
     */
    public function password_reset_should_fail_with_invalid_reset_token()
    {
        factory(User::class)->create([
            'id' => 1
        ]);

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
     * TODO rewrite
     * test
     */
    public function password_reset_should_succeed_with_valid_reset_token()
    {
        factory(User::class)->create([
            'id' => 1
        ]);

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
