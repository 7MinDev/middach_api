<?php namespace App\Repositories\Contracts; 
/**
 * @author pschmidt
 */
interface OpeningTimeRepositoryContract {

	/**
	 * @param $data
	 * @return mixed
	 */
	public function create($data);
}