<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = [
        'description',
    ];


    public function  is_donor()
    {
        return $this->description === 'Doador';
    }
}
