<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

trait HasUuid
{
    /**
     * Get the value indicating whether the IDs are incrementing.
     *
     * @return bool
     */
    public function getIncrementing()
    {
        return false;
    }

    /**
     * Get the auto-incrementing key type.
     *
     * @return string
     */
    public function getKeyType()
    {
        return 'string';
    }

    public static function booted()
    {
        static::creating(function (Model $model) {
            // Set attribute for new model's primary key (ID) to an uuid.
            $model->setAttribute($model->getKeyName(), Str::uuid());
        });
    }
}

