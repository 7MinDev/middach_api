<?php namespace App\Providers;

use App\Http\Controllers\Filter\OAuthFilter;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider {

	/**
	 * Bootstrap any application services.
	 *
	 * @return void
	 */
	public function boot()
	{
		//
	}

	/**
	 * Register any application services.
	 *
	 * This service provider is a great spot to register your various container
	 * bindings with the application. As you can see, we are registering our
	 * "Registrar" implementation here. You can add your own bindings too!
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app->bind(
			'App\Repositories\Contracts\RestaurantRepositoryContract',
			'App\Repositories\RestaurantRepository');

		$this->app->bind(
			'App\Repositories\Contracts\OpeningTimeRepositoryContract',
			'App\Repositories\OpeningTimeRepository');

		$this->app->bind(
			'App\Repositories\Contracts\MenuRepositoryContract',
			'App\Repositories\MenuRepository');

		$this->app->bind(
			'App\Repositories\Contracts\FoodRepositoryContract',
			'App\Repositories\FoodRepository');
	}

}
