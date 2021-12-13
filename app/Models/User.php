<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = [
        'username',
        'password',
    ];

    protected $hidden = ['created_at', 'updated_at'];
}
