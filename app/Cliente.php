<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Cliente extends Authenticatable
{
    use Notifiable;
    /**
     * The database table used by the model.
     *
     * @var string
     */

     /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
    
    protected $table = 'clientes';
    protected $primaryKey = 'idclientes';
    protected $guard = 'cliente';

    protected $fillable = [
        'email', 'password','nombreCompleto'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];
}
