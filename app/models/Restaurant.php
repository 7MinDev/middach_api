<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @author pschmidt
 */
class Restaurant extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'user_id',
        'name',
        'street',
        'town',
        'postal_code',
        'description',
        'feedback_email',
        'website'
    ];

    /**
     * opening time relationship
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function openingTimes()
    {
        return $this->hasMany(OpeningTime::class);
    }

    /**
     * owner relationship
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * a restaurant has many menus
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function menus()
    {
        return $this->hasMany(Menu::class);
    }
}
