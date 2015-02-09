<?php namespace App\Repositories\Traits;

/**
 * @author pschmidt
 */

trait CallOnUnderlyingModel {

	public function __call($method, $args)
	{
		return call_user_func([$this->model, $method], $args);
	}
}