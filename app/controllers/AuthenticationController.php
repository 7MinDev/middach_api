<?php
use Illuminate\Http\JsonResponse;
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
	 *
	 */
	public function login()
	{
		return JsonResponse::create($this->authorizer->issueAccessToken());
	}

	/**
	 *
	 */
	public function logout()
	{
		$accessToken = $this->authorizer->getChecker()->getAccessToken();

		if ($accessToken != null && AuthenticationService::logout($accessToken))
		{
			return JsonResponse::create('logged out', JsonResponse::HTTP_OK);
		}
		else
		{
			return JsonResponse::create('logged out failed', JsonResponse::HTTP_BAD_REQUEST);
		}
	}
}