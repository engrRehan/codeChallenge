<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    //
    protected $fillable = [
        'name',
        'group_id',
        'created_by'
    ];



    public function group() {
        return $this->hasOne('App\Group','id','group_id');
    }
}
