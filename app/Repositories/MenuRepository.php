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
     * @param $queryRelations
	 * @return mixed
	 */
	public function findById($id, $queryRelations = [])
	{
        if (empty($queryRelations))
        {
            return $this->model->findOrFail($id);
        }

        return $this->model->with($queryRelations)->findOrFail($id);
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

	/**
	 * @param $id
	 * @return mixed
	 */
	public function copy($id)
	{
		/**
		 * @var $menu Menu
		 */
		$menu = $this->findById($id);

		/**
		 * @var $copy Menu
		 */
		$copy = new Menu();
		$copy->name = $menu->name;
		$copy->user_id = $menu->user_id;
		$copy->save();

		return $copy;
	}


}
