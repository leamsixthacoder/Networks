<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];



    protected $hidden = [
         'id',
        'created_at',
        'updated_at',
    ];

    public function jobs()
    {
        $this->hasMany('App\Jobs');
    }
}
