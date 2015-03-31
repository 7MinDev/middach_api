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
		$data = [
			'user_id' => 1,
			'name' => 'Schitzel Menu für Mittwoch',
		];

		$menu = $this->repository->create($data);

		$this->assertNotEmpty($menu, '$menu is empty.');
		$this->assertTrue($menu instanceof Menu, '$menu is not an instance of Menu Model');
	}

	/**
	 *
	 * @test
	 */
	public function should_edit_a_menu_and_return_it()
	{
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
		$this->repository->delete(1);

		$menu = $this->repository->findById(1);

		$this->assertEmpty($menu, 'Menu is not empty, so it was not deleted.');
	}
}