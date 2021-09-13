<?php

namespace App\Console\Commands;

use App\Exports\ReporteIUNExport;
use App\Mail\NotificaReporteUN;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;

class CorreoRUNS extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'enviar:correoruns';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Este cron Job envia el reporte semanal de las insignias de unidad de negocio';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->fecha_actual = Carbon::now()->format('Y-m-d');
        $this->reporte = DB::table('v_insignias_un')->select('id', 'no_colaborador_premiado', 'nombre_completo_premiado', 'nombre_insignia', 'fecha_asignacion', 'colaborador_asignador', 'nombre_completo_asignador', 'mensaje')->get();
        Excel::store(new ReporteIUNExport($this->reporte), 'public/reportes/insignias_un/reporte_insignias_UN(' . $this->fecha_actual . ').xlsx','public', \Maatwebsite\Excel\Excel::XLSX);

        Mail::to([
            'jpeacockl@itecnos.com.mx',
            'fvegac@itecnos.com.mx'
        ])
        ->CC([
            'comunicacion@itecnos.com.mx',
            'jnava@itecnos.com.mx',
            'mazacariasr@itecnos.com.mx',
            'cmazons@itecnos.com.mx',
            'jlarellano@itecnos.com.mx',
            'mjuarezq@itecnos.com.mx',
            'acastillod@itecnos.com.mx'
        ])
        ->send(new NotificaReporteUN());
    }
}
