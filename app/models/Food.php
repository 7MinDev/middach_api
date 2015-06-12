<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @author pschmidt
 */
class Food extends Model
{
    protected $fillable = [
        'restaurant_id',
        'title',
        'sub_title',
        'price',
        'additional_info',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }
}
