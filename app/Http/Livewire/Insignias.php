<?php

namespace App\Http\Livewire;

use Exception;
use App\Models\Area;
use App\Models\Puesto;
use Livewire\Component;
use App\Models\Colaborador;
use Livewire\WithPagination;
use App\Models\Tipo_colaborador;
use Illuminate\Support\Facades\DB;

class Insignias extends Component
{
    use WithPagination;

    protected $queryString = [
        'search' => ['except' => ''],
        'perPage'
    ];

    public $search, $perPage = '50';
    public $no_colaborador, $colaborador;

    public $sortBy = 'no_colaborador';
    public $sortAsc = true;

    public $col_premiado, $foto_premiado;
    public $area, $puesto;

    public $tipo_insignia, $mensaje;


    public function mount($no_colaborador)
    {

        $this->colaborador = Colaborador::find($no_colaborador);
        $this->col_premiado = $no_colaborador;
        /* dd($this->foto_premiado); */
    }

    public function render()
    {

        $areas = Area::select('*')->orderBy('nombre_area', 'ASC')->get();
        $puestos = Puesto::join('nivel', 'nivel.id', 'puesto.nivel_id')
            ->select('puesto.id', 'puesto.especialidad_puesto', 'nivel.nombre_nivel')
            ->get();
        $tiposColaborador = Tipo_colaborador::all();

        $premiados = Colaborador::select('no_colaborador', 'nombre_1', 'nombre_2', 'ap_paterno', 'ap_materno')
            ->orderBy('ap_paterno', 'ASC')
            ->get();


        return view('livewire.insignias', [
            'colaboradores' => DB::table('infocolaborador')->where('no_colaborador', 'LIKE', "%{$this->search}%")
                ->orWhere('nombre_completo', 'LIKE', "%{$this->search}%")
                ->orWhere('puesto', 'LIKE', "%{$this->search}%")
                ->orWhere('area', 'LIKE', "%{$this->search}%")
                ->orderBy($this->sortBy, $this->sortAsc ? 'ASC' : 'DESC')
                ->paginate($this->perPage)
        ], compact(
            'premiados',
            'areas',
            'puestos',
            'tiposColaborador'
        ));
    }

    public function asignacion()
    {
        try {

            

            $this->flash('success', 'Se asignó correctamente la insignia', [
                'position' =>  'top-end',
                'timer' =>  3000,
                'toast' =>  true,
                'text' =>  '',
                'confirmButtonText' =>  'Ok',
                'cancelButtonText' =>  'Cancel',
                'showCancelButton' =>  false,
                'showConfirmButton' =>  false,
            ]);
            return redirect()->to('/insignias/' . $this->colaborador->no_colaborador);
        } catch (Exception $ex) {

            $this->alert('error', 'Error al asignar', [
                'position' =>  'top-end',
                'timer' =>  3000,
                'toast' =>  true,
                'text' =>  '',
                'confirmButtonText' =>  'Ok',
                'cancelButtonText' =>  'Cancel',
                'showCancelButton' =>  false,
                'showConfirmButton' =>  false,
            ]);
        }
    }
}