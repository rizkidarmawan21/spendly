<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class AccountCategory extends Model
{
    protected $guarded = ["id"];
    public $incrementing = true;

    public function account()
    {
        return $this->hasMany(Account::class, 'category_id');
    }

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope('orderById', function (Builder $builder) {
            $builder->orderBy('id');
        });
    }
}
