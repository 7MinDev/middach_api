<?php

use App\Models\Menu;
use App\Models\User;

/**
 * @author pschmidt
 */
class MenusControllerTest extends TestCase
{
    /**
     * @var User
     */
    private $user;

    /**
     *
     */
    public function setUp()
    {
        parent::setUp();

        // disable oauth middleware
        $this->withoutMiddleware();

        // set a logged in user
        $this->user = factory(User::class)->make();
        Sentinel::setUser($this->user);
    }

    /**
     *
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
            ->andReturn('Foo');
        App::instance('App\Repositories\Contracts\MenuRepositoryContract', $mock);

        $response = $this->call('POST', route('restaurants.menus.create'), $data);

        $this->assertTrue($response->isOk(),
            'Response not ok. Got code ' . $response->getStatusCode() . ' instead.' . $response->getContent());
    }

    /**
     * @test
     */
    public function edit_action_should_return_with_a_http_ok()
    {
        $menu = factory(Menu::class)
            ->make(['id' => 1, 'user_id' => $this->user->id])
            ->user()
            ->associate($this->user);

        $menuMock = Mockery::mock('App\Repositories\Contracts\MenuRepositoryContract');
        $menuMock->shouldReceive('findById')->andReturn($menu);
        $menuMock->shouldReceive('update')->once()->andReturn('Foo');
        App::instance('App\Repositories\Contracts\MenuRepositoryContract', $menuMock);

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
        $menu = factory(Menu::class)
            ->make(['id' => 1, 'user_id' => $this->user->id])
            ->user()
            ->associate($this->user);

        $menuMock = Mockery::mock('App\Repositories\Contracts\MenuRepositoryContract');
        $menuMock->shouldReceive('findById')->andReturn($menu);
        $menuMock->shouldReceive('delete')->andReturn('Foo');
        App::instance('App\Repositories\Contracts\MenuRepositoryContract', $menuMock);

        $response = $this->call('DELETE', route('restaurants.menus.delete', [1]));

        $this->assertTrue($response->isOk(),
            'Response not ok. Got code ' . $response->getStatusCode() . ' instead.' . $response->getContent());
    }

    /**
     *
     * @test
     */
    public function delete_should_fail_because_user_ids_do_not_match()
    {
        $wrongUser = factory(User::class)->make();
        $menu = factory(Menu::class)
            ->make(['id' => 1])
            ->user()
            ->associate($wrongUser);

        $menuMock = Mockery::mock('App\Repositories\Contracts\MenuRepositoryContract');
        $menuMock->shouldReceive('findById')->andReturn($menu);
        $menuMock->shouldReceive('delete')->andReturn('Foo');
        App::instance('App\Repositories\Contracts\MenuRepositoryContract', $menuMock);

        $response = $this->call('DELETE', route('restaurants.menus.delete', [1]));
        $this->assertTrue($response->isClientError(), 'Response was ok. Menu should not have been deleted');
    }

    /**
     *
     * @test
     */
    public function edit_should_fail_because_user_ids_do_not_match()
    {
        $menu = factory(Menu::class)
            ->make(['id' => 1])
            ->user()
            ->associate(factory(User::class)->make());

        $menuMock = Mockery::mock('App\Repositories\Contracts\MenuRepositoryContract');
        $menuMock->shouldReceive('findById')->andReturn($menu);
        $menuMock->shouldNotReceive('update');
        App::instance('App\Repositories\Contracts\MenuRepositoryContract', $menuMock);

        $data = [
            'name' => 'New Restaurant Menu #1'
        ];

        $response = $this->call('PUT', route('restaurants.menus.update', [1]), $data);
        $this->assertTrue($response->isClientError(), 'Response was ok. Menu should not have been updated');
    }

    /**
     *
     * @test
     */
    public function copy_should_return_with_a_http_ok()
    {
        $menu = factory(Menu::class)
            ->make(['id' => 1])
            ->user()
            ->associate($this->user);

        $menuMock = Mockery::mock('App\Repositories\Contracts\MenuRepositoryContract');
        $menuMock->shouldReceive('findById')->andReturn($menu);
        $menuMock->shouldReceive('copy')->andReturn('Foo');
        App::instance('App\Repositories\Contracts\MenuRepositoryContract', $menuMock);

        $response = $this->call('POST', route('restaurants.menus.copy', [1]));
        $this->assertTrue($response->isOk(), 'Response not ok. Got code ' . $response->getStatusCode() . ' instead.');
    }

    /**
     *
     * @test
     */
    public function copy_should_fail_because_user_ids_do_not_match()
    {
        $wrongUser = factory(User::class)->make();
        $menu = factory(Menu::class)
            ->make(['id' => 1])
            ->user()
            ->associate($wrongUser);

        $menuMock = Mockery::mock('App\Repositories\Contracts\MenuRepositoryContract');
        $menuMock->shouldReceive('findById')->andReturn($menu);
        $menuMock->shouldReceive('copy')->andReturn('Foo');
        App::instance('App\Repositories\Contracts\MenuRepositoryContract', $menuMock);

        $response = $this->call('POST', route('restaurants.menus.copy', [1]));
        $this->assertTrue($response->isClientError(), 'Response was ok. Menu should not have been copied.');
    }
}
