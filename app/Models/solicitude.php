<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class solicitude extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'solicitudes';

    /**
    * The database primary key value.
    *
    * @var string
    */
    protected $primaryKey = 'id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['tipo_trabajo', 'diametro_Tubo', 'tipo_material', 'espesor', 'tamaño_tubo', 'hay_soldadura', 'numero_soldadura', 'numero_tubos', 'numero_dobleces', 'numero_curvas', 'numero_cortes', 'plantilla', 'ancho', 'altura', 'radio', 'largo', 'incluye_pasamanos_secundarios', 'largo_total', 'largo_parte_recta', 'a', 'b', 'estado','id_cliente','precio_unitario','precio_total','des_solicitud'];

    
}
