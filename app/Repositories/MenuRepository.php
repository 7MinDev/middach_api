<?php namespace App\Repositories;

use App\Models\Menu;
use App\Repositories\Contracts\MenuRepositoryContract;
use App\Repositories\Traits\CallOnUnderlyingModel;

/**
 * @author pschmidt
 */
class MenuRepository implements MenuRepositoryContract
{
	use CallOnUnderlyingModel;

	protected $model;

	/**
	 * @param Menu $menu
	 */
	function __construct(Menu $menu)
	{
		$this->model = $menu;
	}


	/**
	 * @param $data
	 * @return mixed
	 */
	public function create($data)
	{
		$menu = $this->model->create($data);

		return $menu;
	}

	/**
	 * @param $id
	 * @param $data
	 * @return mixed
	 */
	public function update($id, $data)
	{
		$menu = $this->findById($id);

		$menu->fill($data);
		$menu->save();

		return $menu;
	}

	/**
	 * @param $id
	 * @return mixed
	 */
	public function findById($id)
	{
		return $this->model->find($id);
	}

	/**
	 * @param $id
	 * @return mixed
	 */
	public function delete($id)
	{
		$menu = $this->findById($id);

		if ($menu->delete())
		{
			return true;
		}

		return false;
	}
}
