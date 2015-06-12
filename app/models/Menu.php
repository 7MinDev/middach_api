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
    protected $fillable = ['user_id', 'name'];

    /**
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
