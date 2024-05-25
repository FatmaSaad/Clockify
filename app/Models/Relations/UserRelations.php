<?php


namespace App\Models\Relations;

use App\Models\ClockIn;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Trait UserRelations
 * @package App\Models\Relations
 */
trait UserRelations
{
    /**
     * @return HasMany
     */
    public function clockins()
    {
        return $this->hasMany(ClockIn::class, 'user_id')->orderBy('timestamp', 'asc');
    }
}
