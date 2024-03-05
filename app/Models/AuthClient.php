<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Foundation\Auth\AuthClient as Authenticatable;
use Illuminate\Notifications\Notifiable;

class AuthClient extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'name',
        'secret',
    ];
}
