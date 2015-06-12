<?php

use App\Models\Restaurant;
use App\Models\User;

/**
 *
 * @author pschmidt
 */
class RestaurantsControllerTest extends TestCase
{
    /**
     * @var User
     */
    private $user;

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
     * @test
     */
    public function find_restaurant_should_return_a_http_ok()
    {
        $mock = Mockery::mock('App\Repositories\Contracts\RestaurantRepositoryContract');
        $mock->shouldReceive('findById')
            ->once()
            ->andReturn();
        App::instance('App\Repositories\Contracts\RestaurantRepositoryContract', $mock);

        $response = $this->call('GET', route('restaurants.find', [1]));
        $this->assertTrue($response->isOk(), $response->getContent());
    }

    /**
     * @test
     */
    public function should_create_a_restaurant_and_return_a_http_ok()
    {
        $data = [
            'name' => 'Günther Haack im Bankcarrée',
            'street' => 'Rudolf-Schwander-Straße 3',
            'town' => 'Kassel',
            'postal_code' => '34117',
            'description' => 'Günter Haack im bankcarreé. Impressum: Haack Catering, Inh. Günter Haack Meisterkoch, Rudolf-Schwander-Str. 3, 34117 Kassel, Tel. 0561-78931177',
            'website' => 'http://www.meisterkoch-haack.de/',
        ];

        $mock = Mockery::mock('App\Repositories\Contracts\RestaurantRepositoryContract');
        $mock->shouldReceive('create')
            ->once()
            ->andReturn();
        App::instance('App\Repositories\Contracts\RestaurantRepositoryContract', $mock);

        $response = $this->call('POST', route('restaurants.create'), $data);
        $this->assertTrue($response->isOk(),
            'Response code should be 200. Got ' . $response->getStatusCode() . ' instead.');
    }

    /**
     *
     * @test
     */
    public function should_update_a_restaurant_and_return_with_a_http_ok()
    {
        $restaurant = factory(Restaurant::class)
            ->make(['id' => 1])
            ->owner()
            ->associate($this->user);

        $data = [
            'name' => 'Test test test',
            'postal_code' => 54321
        ];

        $restaurantMock = Mockery::mock('App\Repositories\Contracts\RestaurantRepositoryContract');
        $restaurantMock->shouldReceive('findById')->andReturn($restaurant);
        $restaurantMock->shouldReceive('update')->andReturn('Foo');
        App::instance('App\Repositories\Contracts\RestaurantRepositoryContract', $restaurantMock);

        $response = $this->call('PUT', route('restaurants.update', [1]), $data);
        $this->assertTrue($response->isOk(), 'Response not ok. Got code ' . $response->getStatusCode() . ' instead.');
    }

    /**
     *
     * @test
     */
    public function update_should_fail_because_user_ids_do_not_match()
    {
        $restaurant = factory(Restaurant::class)
            ->make(['id' => 1])
            ->owner()
            ->associate(factory(User::class)->make());

        $restaurantMock = Mockery::mock('App\Repositories\Contracts\RestaurantRepositoryContract');
        $restaurantMock->shouldReceive('findById')->andReturn($restaurant);
        $restaurantMock->shouldNotReceive('update');
        App::instance('App\Repositories\Contracts\RestaurantRepositoryContract', $restaurantMock);

        $data = [
            'name' => 'Voll das kack Restaurant',
        ];

        // should fail because restaurant id 1 belongs to user id 1
        $response = $this->call('PUT', route('restaurants.update', [1]), $data);

        $this->assertTrue($response->isClientError(), 'Response was ok. Should have failed with a forbidden response');
    }

    /**
     *
     * @test
     */
    public function should_delete_a_restaurant_and_return_with_a_http_ok()
    {
        $restaurant = factory(Restaurant::class)
            ->make(['id' => 1])
            ->owner()
            ->associate($this->user);

        $restaurantMock = Mockery::mock('App\Repositories\Contracts\RestaurantRepositoryContract');
        $restaurantMock->shouldReceive('findById')->andReturn($restaurant);
        $restaurantMock->shouldReceive('delete')->once()->andReturn('Foo');
        App::instance('App\Repositories\Contracts\RestaurantRepositoryContract', $restaurantMock);

        $response = $this->call('DELETE', route('restaurants.delete', [1]));

        $this->assertTrue($response->isOk(),
            'Response was not ok. Got code ' . $response->getStatusCode() . ' instead.' . $response->getContent());
    }

    /**
     *
     * @test
     */
    public function delete_should_fail_because_user_ids_do_not_match()
    {
        $restaurant = factory(Restaurant::class)
            ->make(['id' => 1])
            ->owner()
            ->associate(factory(User::class)->make());

        $restaurantMock = Mockery::mock('App\Repositories\Contracts\RestaurantRepositoryContract');
        $restaurantMock->shouldReceive('findById')->andReturn($restaurant);
        $restaurantMock->shouldNotReceive('delete');
        App::instance('App\Repositories\Contracts\RestaurantRepositoryContract', $restaurantMock);

        $response = $this->call('DELETE', route('restaurants.delete', [1]));
        $this->assertTrue($response->isClientError(), 'Response was ok. Restaurant should not have been deleted.');
    }
}
