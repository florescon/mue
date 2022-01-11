<?php

namespace App\Domains\Auth\Models\Traits\Relationship;

use App\Domains\Auth\Models\PasswordHistory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Logged;

/**
 * Class UserRelationship.
 */
trait UserRelationship
{
    /**
     * @return mixed
     */
    public function passwordHistories()
    {
        return $this->morphMany(PasswordHistory::class, 'model');
    }

    public function loggeds(): HasMany
    {
        return $this->hasMany(Logged::class)->orderBy('created_at', 'desc');
    }
}
