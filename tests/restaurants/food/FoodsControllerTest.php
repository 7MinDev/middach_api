<?php

/**
 * @author pschmidt
 */
class FoodsControllerTest extends ControllerTestCase
{

    /**
     *
     * POST /restaurants/foods/create should call create method on the repository
     * and return with a http ok.
     *
     * @test
     */
    public function create_should_call_create_and_return_with_a_http_ok()
    {
        $this->withoutMiddleware();
        Sentinel::setUser(factory(\App\Models\User::class)->make());

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
     * @test
     */
    public function update_should_call_update_and_return_with_a_http_ok()
    {
        $this->withoutMiddleware();
        $user = factory(\App\Models\User::class)->make([
            'id' => 1
        ]);

        Sentinel::setUser($user);

        /**
         * @var $restaurant \App\Models\Restaurant
         */
        factory(\App\Models\Restaurant::class)
            ->create(['id' => 1, 'user_id' => $user->id]);

        factory(\App\Models\Food::class)->create([
            'id' => 1,
            'restaurant_id' => 1,
        ]);

        $data = [
            'price' => 6.00
        ];

        $response = $this->call('PUT', route('restaurants.foods.update', 1), $data);

        $this->assertTrue($response->isOk(),
            'Response was not ok. Got code ' . $response->getStatusCode() . ' instead.' . $response->getContent());
    }
}
