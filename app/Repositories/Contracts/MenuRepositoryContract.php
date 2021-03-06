<?php namespace App\Repositories\Contracts; 
/**
 * @author pschmidt
 */
interface MenuRepositoryContract
{
	/**
	 * @param $data
	 * @return mixed
	 */
	public function create($data);

	/**
	 * @param $id
	 * @param $data
	 * @return mixed
	 */
	public function update($id, $data);

	/**
	 * @param $id
     * @param $queryRelations
	 * @return mixed
	 */
	public function findById($id, $queryRelations = []);

	/**
	 * @param $id
	 * @return mixed
	 */
	public function delete($id);

	/**
	 * @param $id
	 * @return mixed
	 */
	public function copy($id);
}
