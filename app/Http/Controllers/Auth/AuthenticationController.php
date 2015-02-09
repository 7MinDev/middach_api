<?php namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\ActivateAccountRequest;
use App\Http\Requests\ProcessResetPasswordRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Services\Authenticator;

use Activation;
use LucaDegasperi\OAuth2Server\Authorizer;
use Mail;
use Response;
use Sentinel;
use Symfony\Component\HttpFoundation\Response as Status;
use Reminder;

/**
 *
 * @author pschmidt
 */

class AuthenticationController extends Controller {

	/**
	 * @var Authorizer
	 */
	private $authorizer;

	/**
	 * @param Authorizer $authorizer
	 */
	function __construct(Authorizer $authorizer)
	{
		$this->authorizer = $authorizer;
	}

	/**
	 *
	 */
	public function login()
	{
		return Response::json($this->authorizer->issueAccessToken());
	}

	/**
	 *
	 */
	public function logout()
	{
		$accessToken = $this->authorizer->getChecker()->getAccessToken();

		if ($accessToken != null && Authenticator::logout($accessToken))
		{
			return Response::json('logged out');
		}
		else
		{
			return Response::json('logged out failed', Status::HTTP_BAD_REQUEST);
		}
	}

	/**
	 * Endpoint for registering a new user.
	 *
	 * @param RegisterUserRequest $request
	 * @return Response
	 */
	public function register(RegisterUserRequest $request)
	{
		$user = Sentinel::register($request->except('password_confirmation'));

		$activation = Activation::create($user);

		$code = $activation->code;

		Mail::queue(
			'emails.auth.activate',
			compact('user', 'code'),
			function($message) use ($user)
			{
				$message
					->to($user->email)
					->subject('Account Activation');
			});

		return Response::json([
			'status' => 'success',
			'message' => 'registration_complete'
		]);
	}

	/**
	 * Endpoint for activating a user
	 *
	 * @param ActivateAccountRequest $request
	 * @return Status
	 */
	public function activate(ActivateAccountRequest $request)
	{
		$userId = $request->get('userId');
		$code = $request->get('code');

		$user = Sentinel::getUserRepository()->findById($userId);

		if (!Activation::complete($user, $code))
		{
			return Response::json([
				'status' => 'error',
				'message' => 'invalid_or_expired_activation_code'
			], Status::HTTP_BAD_REQUEST);

		}

		return Response::json([
			'status' => 'success',
			'message' => 'activation_complete'
		]);
	}

	/**
	 * Endpoint for starting a password reset process.
	 *
	 * @param ResetPasswordRequest $request
	 * @return Status
	 */
	public function reset(ResetPasswordRequest $request)
	{
		$loginName = $request->get('loginName');

		if (!$loginName || empty($loginName))
		{
			return Response::json([
				'status' => 'error',
				'message' => 'loginName field is missing or empty',
			], Status::HTTP_BAD_REQUEST);
		}

		$credentials = [
			'login' => $loginName
		];

		$user = Sentinel::getUserRepository()->findByCredentials($credentials);

		if (!$user)
		{
			return Response::json([
				'status' => 'error',
				'message' => 'user_doesnt_exist'
			], Status::HTTP_NOT_FOUND);
		}

		$reminder = Reminder::exists($user);

		if (!$reminder || $reminder == null)
		{
			$reminder = Reminder::create($user);
		}

		$code = $reminder->code;

		Mail::queue('emails.auth.reminder', compact('user', 'code'),
			function($message) use ($user)
			{
				$message->to($user->email)
					->subject('Reset your account password');
			});

		return Response::json([
			'status' => 'success',
			'message' => 'password_reset_successfully'
		]);
	}

	/**
	 * @param ProcessResetPasswordRequest $request
	 * @return Status
	 */
	public function processReset(ProcessResetPasswordRequest $request)
	{
		$credentials = [
			'password' => $request->get('password'),
			'password_confirmation' => $request->get('password_confirmation')
		];

		$userId = $request->get('userId');
		$code = $request->get('code');

		$user = Sentinel::getUserRepository()->findById($userId);

		if (!$user)
		{
			return Response::json([
				'status' => 'error',
				'message' => 'user_doesnt_exist'
			], Status::HTTP_NOT_FOUND);
		}

		$resetComplete = Reminder::complete($user, $code, $credentials['password']);

		if (!$resetComplete)
		{
			return Response::json([
				'status' => 'error',
				'message' => 'invalid_or_expired_code'
			], Status::HTTP_BAD_REQUEST);
		}

		return Response::json([
			'status' => 'success',
			'message' => 'password_reset_success'
		]);
	}
}
