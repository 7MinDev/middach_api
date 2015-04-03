<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @author pschmidt
 */
class Menu extends Model
{
	/**
	 * @var array
	 */
	protected $fillable = ['name'];

	/**
	 * @var array
	 */
	protected $guarded = ['id'];

	/**
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function user()
	{
		return $this->belongsTo(User::class);
	}
}