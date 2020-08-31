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
    protected $table = 'clientes';

     /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
    
    protected $primaryKey = 'idclientes';
    protected $guard = 'cliente';

    protected $fillable = [
        'email', 'password','nombreCompleto', 'ofertasCorreo'
    ];

    protected $hidden = [
        'password', 'remember_token'
    ];

    /** 
     * Obtiene solo los datos del cliente necesarios para el envio
     * 
     * @return $regreso 
     */

    public function getdatosEnvioAttribute(){ //Obtiene solo
        $regreso = array(
            'nombreCom' => $this->nombreCompleto,
            'aPaterno' => $this->aPaterno,
            'aMaterno' => $this->aMaterno,
            'calle' => $this->calle,
            'entreCalle' => $this->entreCalle,
            'numExt' => $this->nExt,
            'numInt' => $this->nInt,
            'cp' => $this->cp,
            'colonia' => $this->colonia,
            'municipio' => $this->municipio,
            'estado' => $this->estado,
            'telefono' => $this->telefono,
            'referencias' => $this->refrencias_domicilio
        );

        return $regreso;
    }

    public function pedidos(){
        return $this->hasMany('App\Venta','idcliente','idclientes');
    }
}
