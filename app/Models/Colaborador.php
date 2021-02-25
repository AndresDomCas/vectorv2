<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Colaborador extends Model
{
    use HasFactory;

    protected $table = 'colaborador';
    protected $primaryKey = 'no_colaborador';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'no_colaborador',
        'nombre',
        'ap_paterno',
        'ap_materno',
        'fecha_nacimiento',
        'genero_id',
        'estado_civil_id',
        'domicilio',
        'municipio',
        'estado',
        'codigo_postal',
        'paternidad_id',
        'turno_id',
        'ruta_transporte_id',
        'puesto_id',
        'area_id',
        'correo',
        'tel_fijo',
        'tel_movil',
        'tel_recados',
        'extension_id',
        'clave_radio_id',
        'jefe_directo',
        'tipo_colaborador_id',
        'fecha_ingreso',
        'password',
        'matriculacion',
        'tipo_usuario_id',
        'tipo_usuario_id',
        'rango_factor_id',
        'rims',
        'autoeval_gen',
        'autoeval_asig',
        'autoeval_cal',
        'eval_gen',
        'eval_asig',
        'eval_cal',
        'estado_colaborador',
        'foto',
];

    //* Relacion muchos a uno
    public function generos(){
        return $this->belongsTo('App\Models\Genero');
    }

    public function areas(){
        return $this->belongsTo('App\Models\Area');
    }

    public function puestos(){
        return $this->belongsTo('App\Models\Puesto');
    }

    public function claves_radio(){
        return $this->belongsTo('App\Models\Clave_radio');
    }

    public function tipos_colaborador(){
        return $this->belongsTo('App\Models\Tipo_colaborador');
    }

    public function tipos_usuario(){
        return $this->belongsTo('App\Models\Tipo_usuario');
    }

    public function turnos(){
        return $this->belongsTo('App\Models\Turno');
    }

    public function Rutas_transporte(){
        return $this->belongsTo('App\Models\Ruta_Transporte');
    }

    public function Estados_civil(){
        return $this->belongsTo('App\Models\Estado_civil');
    }

    public function Extensiones(){
        return $this->belongsTo('App\Models\Extension');
    }

    public function Rangos_factor(){
        return $this->belongsTo('App\Models\Rango_Factor');
    }

    // * Relacion uno a muchos
    public function colaboradores_evento()
    {
        return $this->hasMany('App\Models\Colaborador_evento');
    }

    public function hijos()
    {
        return $this->hasMany('App\Models\Hijos');
    }

    public function contactos_emergencia()
    {
        return $this->hasMany('App\Models\Contactos_emergencia');
    }
}