<?php namespace App\Http\Controllers\Auth;

use Activation;
use App\Http\Controllers\Controller;
use App\Models\User;
use Cartalyst\Sentinel\Sentinel;
use Illuminate\Contracts\Auth\Registrar;
use Validator;
use Illuminate\Foundation\Http\FormRequest as Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Mail\Message;
use Illuminate\Mail\Mailer as Mail;
use Reminder;


/**
 *
 * @author pschmidt
 */

class AuthenticationController extends Controller {

	/**
	 * TODO
	 * @var Authorizer
	 */
//	private $authorizer;

	/**
	 * @var Registrar
	 */
	private $registrar;

	/**
	 *
	 * @param Authorizer $authorizer
	 */
//	function __construct(Authorizer $authorizer)
//	{
//		$this->authorizer = $authorizer;
//	}

	/**
	 * @param Registrar $registrar
	 */
	function __construct(Registrar $registrar)
	{
		$this->registrar = $registrar;
	}


	/**
	 * @return \Symfony\Component\HttpFoundation\Response|static
	 */
	public function login()
	{
//		return JsonResponse::create($this->authorizer->issueAccessToken());
	}

	/**
	 * @return \Symfony\Component\HttpFoundation\Response|static
	 */
	public function logout()
	{
//		$accessToken = $this->authorizer->getChecker()->getAccessToken();
//
//		if ($accessToken != null && AuthenticationService::logout($accessToken))
//		{
//			return new JsonResponse('logged out', JsonResponse::HTTP_OK);
//		}
//		else
//		{
//			return new JsonResponse('logged out failed', JsonResponse::HTTP_BAD_REQUEST);
//		}
	}

	/**
	 * @param Request $request
	 * @return JsonResponse
	 */
	public function register(Request $request)
	{
		$validator = $this->registrar->validator($request->all());

		if ($validator->fails())
		{
			$this->throwValidationException($request, $validator);
		}

		$user = $this->registrar->create($request->all());

		if (!$user)
		{
			return new JsonResponse([
				'status' => 'server_error',
				'message' => 'failed to register user'
			], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
		}

		$activation = Activation::create($user);
		$code = $activation->code;

		Mail::queue(
			'emails.auth.activate',
			compact('user', 'code'),
			function(Message $message) use ($user)
			{
				$message
					->to($user->email)
					->subject('Account Activation');
			});

		return new JsonResponse([
			'status' => 'success',
			'message' => 'registration_complete',
		], JsonResponse::HTTP_OK);
	}

	/**
	 * @param $userId
	 * @param $code
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function activate(Request $request)
	{
		$userId = $request->get('userId');
		$code = $request->get('code');

		$user = Sentinel::getUserRepository()->findById($userId);

		if (!Activation::complete($user, $code))
		{
			return new JsonResponse([
				'status' => 'error',
				'message' => 'invalid_or_expired_activation_code'
			], JsonResponse::HTTP_BAD_REQUEST);
		}

		return new JsonResponse([
			'status' => 'success',
			'message' => 'activation_complete'
		], JsonResponse::HTTP_OK);
	}

	/**
	 * @return JsonResponse
	 */
	public function reset(Request $request)
	{
		$loginName = $request->get('loginName');

		if (!$loginName || empty($loginName))
		{
			return new JsonResponse([
				'status' => 'error',
				'message' => 'loginName field is missing or empty',
			], JsonResponse::HTTP_BAD_REQUEST);
		}

		$credentials = [
			'login' => $loginName
		];

		$user = Sentinel::getUserRepository()->findByCredentials($credentials);

		if (!$user)
		{
			return new JsonResponse([
				'status' => 'error',
				'message' => 'user_doesnt_exist'
			], JsonResponse::HTTP_NOT_FOUND);
		}

		$reminder = Reminder::exists($user);

		if (!$reminder || $reminder == null)
		{
			$reminder = Reminder::create($user);
		}

		$code = $reminder->code;

		Mail::queue('emails.auth.reminder', compact('user', 'code'),
			function(Message $message) use ($user)
			{
				$message->to($user->email)
					->subject('Reset your account password');
			});

		return new JsonResponse([
			'status' => 'success',
			'message' => 'password_reset_successfully'
		], JsonResponse::HTTP_OK);
	}

	/**
	 * @return JsonResponse
	 */
	public function processReset(Request $request)
	{
		$credentials = [
			'password' => $request->get('password'),
			'password_confirmation' => $request->get('password_confirmation')
		];

		$userId = $request->get('userId');
		$code = $request->get('code');

		$validator = Validator::make($credentials, User::$passwordRules);

		if ($validator->fails())
		{
			return new JsonResponse([
				'status' => 'error',
				'message' => 'validation_failed',
				'fields' => $validator->failed()
			], JsonResponse::HTTP_BAD_REQUEST);
		}

		$user = Sentinel::getUserRepository()->findById($userId);

		if (!$user)
		{
			return new JsonResponse([
				'status' => 'error',
				'message' => 'user_doesnt_exist'
			], JsonResponse::HTTP_NOT_FOUND);
		}

		$resetComplete = Reminder::complete($user, $code, $credentials['password']);

		if (!$resetComplete)
		{
			return new JsonResponse([
				'status' => 'error',
				'message' => 'invalid_or_expired_code'
			], JsonResponse::HTTP_BAD_REQUEST);
		}

		return new JsonResponse([
			'status' => 'success',
			'message' => 'password_reset_success'
		], JsonResponse::HTTP_OK);
	}
}
