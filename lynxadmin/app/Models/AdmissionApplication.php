<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdmissionApplication extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'phone',
        'address',
        'child_name',
        'gender',
        'more_about_child',
        'branch',
        'class'
    ];
}
