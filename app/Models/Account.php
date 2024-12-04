<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $guarded = ["id"];

    public function category()
    {
        return $this->belongsTo(AccountCategory::class);
    }

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope('orderById', function (Builder $builder) {
            $builder->orderBy('id');
        });
    }
}
