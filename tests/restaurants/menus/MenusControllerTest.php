<?php

use App\Models\User;

/**
 * @author pschmidt
 */
class MenusControllerTest extends ControllerTestCase
{

	/**
	 * @test
	 */
	public function should_create_a_menu_and_return_with_a_http_ok()
	{
		$data = [
			'name' => 'Restaurant Menu ID 254',
		];

		$mock = Mockery::mock('App\Repositories\Contracts\MenuRepositoryContract');
		$mock->shouldReceive('create')
			->once()
			->andReturn();
		App::instance('App\Repositories\Contracts\MenuRepositoryContract', $mock);

		$response = $this->call('POST', route('restaurants.menus.create'), $data);

		$this->assertTrue($response->isOk(), 'Response not ok. Got code ' . $response->getStatusCode() . ' instead.' . $response->getContent());
	}

	/**
	 * @test
	 */
	public function edit_action_should_return_with_a_http_ok()
	{
		$data = [
			'name' => 'New Restaurant Menu #1'
		];

		$response = $this->call('PUT', route('restaurants.menus.update', [1]), $data);

		$this->assertTrue($response->isOk(), 'Response not ok. Got code ' . $response->getStatusCode() . ' instead.');
	}

	/**
	 *
	 * @test
	 */
	public function should_delete_a_menu_and_return_with_a_http_ok()
	{
		$response = $this->call('DELETE', route('restaurants.menus.delete', [1]));

		$this->assertTrue($response->isOk(), 'Response not ok. Got code ' . $response->getStatusCode() . ' instead.' . $response->getContent());
	}

	/**
	 * complete test annotation as soon as i know how to disable middleware
	 *
	 * @test
	 */
	public function delete_should_return_with_a_client_error_because_user_ids_do_not_match()
	{
		/**
		 * @var $wrongUser User
		 */
		$wrongUser = User::find(2);
		Sentinel::setUser($wrongUser);

		$response = $this->call('DELETE', route('restaurants.menus.delete',[1]));
		$this->assertTrue($response->isClientError(), 'Response was ok. Menu should not have been deleted');
	}

	/**
	 * TODO complete test annotation as soon as i know how to disable middleware
	 *
	 * test
	 */
	public function edit_should_return_with_a_client_error_because_user_ids_do_not_match()
	{
		/**
		 * @var $wrongUser User
		 */
		$wrongUser = User::find(2);
		Sentinel::setUser($wrongUser);

		$data = [
			'name' => 'New Restaurant Menu #1'
		];

		$response = $this->call('PUT', route('restaurants.menus.update', [1]), $data);

		$this->assertTrue($response->isClientError(), 'Response was ok. Menu should not have been updated');
	}

	/**
	 * TODO complete test annotation as soon as i know how to disable middleware
	 * test
	 */
	public function copy_should_return_with_a_http_ok()
	{
		$response = $this->call('POST', route('restaurants.menus.copy', [1]));

		$this->assertTrue($response->isOk(), 'Response not ok. Got code ' . $response->getStatusCode() . ' instead.');
	}
}
