<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    //
    protected $fillable = [
        'name',
        'description',
        'created_by'
    ];

    public function user (){
        return $this->belongsTo('App\User','created_by');
    }


}
