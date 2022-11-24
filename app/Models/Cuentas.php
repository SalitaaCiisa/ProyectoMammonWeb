<?php

namespace App\Models;

use Carbon\Traits\Timestamp;
use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cuentas extends Model
{
    use HasFactory, SoftDeletes, HasTimestamps;

    protected $fillable = [
        'idUsuario',
        'nombreCuenta',
        'link_token',
        'api_key',
    ];
}
