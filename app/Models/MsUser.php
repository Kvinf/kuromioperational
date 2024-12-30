<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
    use Illuminate\Support\Str;
use Illuminate\Foundation\Auth\User as Authenticatable;


class MsUser extends Authenticatable
{
    use HasFactory;

    protected $keyType = 'string';
    public $incrementing = false; 
    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = Str::uuid()->toString();
            }
        });
    }

}
