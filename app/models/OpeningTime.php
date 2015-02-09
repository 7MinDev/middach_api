<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @author pschmidt
 */

class OpeningTime extends Model
{
	/**
	 * @var array
	 */
	protected $fillable = [
		'restaurant_id',
		'day_of_week',
		'opening_time',
		'closing_time',
	];
}