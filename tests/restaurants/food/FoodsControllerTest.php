<?php

use App\Models\User;

/**
 * @author pschmidt
 */
class FoodsControllerTest extends TestCase
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
        $this->user = factory(User::class)
            ->make(['id' => 1]);
        Sentinel::setUser($this->user);
    }

    /**
     *
     * POST /restaurants/foods/create should call create method on the repository
     * and return with a http ok.
     *
     * @test
     */
    public function create_should_call_create_and_return_with_a_http_ok()
    {
        $foodMock = Mockery::mock('App\Repositories\Contracts\FoodRepositoryContract');
        $foodMock->shouldReceive('create')
            ->once()
            ->andReturn('foo');
        App::instance('App\Repositories\Contracts\FoodRepositoryContract', $foodMock);

        $data = [
            'title' => 'Schnitzel vom Schwein',
            'sub_title' => 'Pfefferrahmsoße / Jägersoße',
            'price' => 5.20,
            'additional_info' => 'Inhaltsstoffe blabla',
        ];

        $response = $this->call('POST', route('restaurants.foods.create'), $data);

        $this->assertTrue($response->isOk(),
            'Response was not ok. Got code ' . $response->getStatusCode() . ' instead.');
    }

    /**
     *
     * @test
     */
    public function update_should_call_update_and_return_with_a_http_ok()
    {
        $food = factory(\App\Models\Food::class)
            ->make(['id' => 1, 'restaurant_id' => 1])
            ->restaurant()
            ->associate(factory(\App\Models\Restaurant::class)
                ->make(['id' => 1, 'user_id' => $this->user->id]));

        $foodMock = Mockery::mock('App\Repositories\Contracts\FoodRepositoryContract');
        $foodMock->shouldReceive('findById')->andReturn($food);
        $foodMock->shouldReceive('update')->once()->andReturn('Foo');
        App::instance('App\Repositories\Contracts\FoodRepositoryContract', $foodMock);

        $data = [
            'price' => 6.00
        ];

        $response = $this->call('PUT', route('restaurants.foods.update', 1), $data);

        $this->assertTrue($response->isOk(),
            'Response was not ok. Got code ' . $response->getStatusCode() . ' instead.' . $response->getContent());
    }
}
