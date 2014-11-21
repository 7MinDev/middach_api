<?php
use Illuminate\Support\ServiceProvider;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;


/**
 * @author pschmidt
 */

class ExceptionServiceProvider extends ServiceProvider
{

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		App::error(function (MethodNotAllowedHttpException $e, $code)
		{
			return new \Illuminate\Http\JsonResponse([
				'error' => $e->getMessage() ?: 'Method not allowed.'
			], $code);
		});
	}
}