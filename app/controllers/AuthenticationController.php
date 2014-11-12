<?php
use Illuminate\Http\JsonResponse;
use Illuminate\Mail\Message;
use LucaDegasperi\OAuth2Server\Authorizer;

/**
 * @author pschmidt
 */

class AuthenticationController extends Controller {

	/**
	 * @var Authorizer
	 */
	private $authorizer;

	/**
	 *
	 * @param Authorizer $authorizer
	 */
	function __construct(Authorizer $authorizer)
	{
		$this->authorizer = $authorizer;
	}

	/**
	 * @return \Symfony\Component\HttpFoundation\Response|static
	 */
	public function login()
	{
		return JsonResponse::create($this->authorizer->issueAccessToken());
	}

	/**
	 * @return \Symfony\Component\HttpFoundation\Response|static
	 */
	public function logout()
	{
		$accessToken = $this->authorizer->getChecker()->getAccessToken();

		if ($accessToken != null && AuthenticationService::logout($accessToken))
		{
			return new JsonResponse('logged out', JsonResponse::HTTP_OK);
		}
		else
		{
			return new JsonResponse('logged out failed', JsonResponse::HTTP_BAD_REQUEST);
		}
	}

	/**
	 * @return \Symfony\Component\HttpFoundation\Response|static
	 */
	public function register()
	{
		$credentials = Input::all();
		$validator = Validator::make($credentials, User::$registrationRules);

		if ($validator->fails())
		{
			return new JsonResponse([
				'status' => 'error',
				'message' => 'validation_failed',
				'fields' => $validator->failed(),
			], JsonResponse::HTTP_BAD_REQUEST);
		}

		unset($credentials['password_confirmation']);
		$user = Sentinel::register($credentials);

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
	public function activate($userId, $code)
	{
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
	 *
	 */
	public function reset()
	{
		// TODO implement
	}

	/**
	 * @param $userId
	 * @param $code
	 */
	public function processReset($userId, $code)
	{
		// TODO implement
	}
}
