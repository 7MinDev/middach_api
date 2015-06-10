<?php
use App\Models\Menu;

/**
 * @author pschmidt
 */
class MenusRepositoryTest extends TestCase
{
    /**
     * @var \App\Repositories\Contracts\MenuRepositoryContract
     */
    protected $repository;

    /**
     *
     */
    public function setUp()
    {
        parent::setUp();
        $this->repository = App::make('App\Repositories\MenuRepository');
    }

    /**
     *
     * @test
     */
    public function should_create_a_new_menu_and_return_it()
    {
        $factory = factory(Menu::class)->make();

        $menu = $this->repository->create($factory->toArray());

        $this->assertNotEmpty($menu, '$menu is empty.');
        $this->assertTrue($menu instanceof Menu, '$menu is not an instance of Menu Model');
    }

    /**
     *
     * @test
     */
    public function should_edit_a_menu_and_return_it()
    {
        factory(Menu::class)->create([
            'id' => 1,
        ]);

        $data = [
            'name' => 'Neues super duper Menu.',
        ];

        $updated_menu = $this->repository->update(1, $data);

        $this->assertTrue($updated_menu instanceof Menu, 'Not an instance of Menu.');
        $this->assertEquals($data['name'], $updated_menu->name, 'Names are not equal.');

        $menu = $this->repository->findById(1);
        $this->assertEquals($data['name'], $menu->name, 'Names are not equal.');
    }

    /**
     *
     * @test
     */
    public function should_delete_a_menu()
    {
        factory(Menu::class)->create([
            'id' => 1,
        ]);

        $this->repository->delete(1);

        try {
            $this->repository->findById(1);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return;
        }

        $this->fail('Menu is not empty, so it was not deleted.');
    }

    /**
     *
     * @test
     */
    public function should_copy_a_menu_and_return_it()
    {
        factory(Menu::class)->create([
            'id' => 1,
            'user_id' => 1,
            'name' => 'Menu #1'
        ]);

        factory(Menu::class)->create([
            'id' => 2,
        ]);

        $menu = $this->repository->copy(1);

        $this->assertEquals($menu->user_id, 1);
        $this->assertEquals($menu->name, 'Menu #1');
        $this->assertNotEquals($menu->id, 1);
        $this->assertNotEquals($menu->id, 2);
    }
}