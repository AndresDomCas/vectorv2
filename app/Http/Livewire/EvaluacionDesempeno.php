<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Artisan;

class EvaluacionDesempeno extends Component
{
    public $colaborador;
    public $foto,$nombre,$puesto;
    public $fotoRandom;

    public $evaluacionValor,$climaValor,$autoevaluacionValor,$resFinanciero,$resDesempeno,$resDesempeno2,$valor270,$nineBox;
    public $climaForm,$resFinancieroForm,$autoevaluacionForm,$evaluacionForm,$evaluacion_270Form;

    public $box1,$box2,$box3,$box4,$box5,$box6,$box7,$box8,$box9;

    public function mount($no_colaborador)
    {
        $check = 'lUgZ/C2axY8B7bJHHkVwKGmaJJ9JJm3otAosfRhoCeg';

        $this->colaborador =  $this->buscaColaborador($no_colaborador);
        
        $this->foto = $this->colaborador[0][0]->foto;
        $this->nombre = $this->colaborador[0][0]->nombre;
        $this->puesto = $this->colaborador[1][0]->tipo;

        /* Clima Laboral - General */
        $clima = $this->camposNull($this->colaborador[1][0]->climaLaboral);
        $this->climaForm = $clima;

        if ($this->puesto == 'Director'){

            /* Clima */
            $this->climaValor = $this->calcularPorcentaje('clima',$clima,$this->puesto);
            
            /* Resultado Financiero */
            $resFinancieroObtn = $this->camposNull($this->colaborador[1][0]->resultFinanciero);
            $this->resFinancieroForm = $resFinancieroObtn;
            $this->resFinanciero = $this->calcularPorcentaje('resultadoFinanciero',$resFinancieroObtn,$this->puesto);
            
            /* Evaluacion */
            $EvaluacionValor = $this->apiObtn($check,$this->colaborador[1][0]->evaluacion);
            $EvaluacionValor = $this->camposNull($EvaluacionValor);
            $this->evaluacionForm = $EvaluacionValor;
            $this->evaluacionValor = $this->calcularPorcentaje('evaluacion',$EvaluacionValor,$this->puesto);
            
            /* Autoevaluacion */
            $this->autoevaluacionForm = $this->apiObtn($check,$this->colaborador[1][0]->autoEvaluacion); 
            $this->autoevaluacionForm = $this->camposNull($this->autoevaluacionForm);

            /* Evaluacion 270 */
            $EvaluacionValor270_1 = $this->apiObtn($check,$this->colaborador[1][0]->Column_270_1);
            $EvaluacionValor270_1 = $this->camposNull($EvaluacionValor270_1);
    
            $EvaluacionValor270_2 = $this->apiObtn($check,$this->colaborador[1][0]->Column_270_2);
            $EvaluacionValor270_2 = $this->camposNull($EvaluacionValor270_2);
    
            $EvaluacionValor270_3 = $this->apiObtn($check,$this->colaborador[1][0]->Column_270_3);
            $EvaluacionValor270_3 = $this->camposNull($EvaluacionValor270_3);
    
            $EvaluacionValor270_4 = $this->apiObtn($check,$this->colaborador[1][0]->Column_270_4);
            $EvaluacionValor270_4 = $this->camposNull($EvaluacionValor270_4);
    
            $EvaluacionValor270_5 = $this->apiObtn($check,$this->colaborador[1][0]->Column_270_5);
            $EvaluacionValor270_5 = $this->camposNull($EvaluacionValor270_5);
    
            $EvaluacionValor270_6 = $this->apiObtn($check,$this->colaborador[1][0]->Column_270_6);
            $EvaluacionValor270_6 = $this->camposNull($EvaluacionValor270_6);
    
            $EvaluacionValor270_7 = $this->apiObtn($check,$this->colaborador[1][0]->Column_270_7);
            $EvaluacionValor270_7 = $this->camposNull($EvaluacionValor270_7);
    
            $evaluacion_270 = [
                $EvaluacionValor270_1,$EvaluacionValor270_2,
                $EvaluacionValor270_3,$EvaluacionValor270_4,
                $EvaluacionValor270_5,$EvaluacionValor270_6,$EvaluacionValor270_7
            ];

            $this->evaluacion_270Form = (array_sum($evaluacion_270) / 7);
            $this->evaluacion_270Form = $this->formatonumero($this->evaluacion_270Form);

            $this->valor270 = $this->calcularPorcentaje('270',$evaluacion_270,$this->puesto);
    
            /* Suma de las todas las calificaciones y mostrar resultado */
            $total = [$this->climaValor, $this->resFinanciero, $this->evaluacionValor, $this->valor270];
            $this->resDesempeno = $this->calcularPorcentaje('total',$total,$this->puesto);
            $this->resDesempeno2 = $this->nineBox2($this->evaluacionForm,$this->evaluacion_270Form,$this->climaForm);
            /* dd($this->resDesempeno,$this->resDesempeno2); */
            $this->nineBoxUbicar($this->resDesempeno2);
            
        }elseif($this->puesto == 'Director_270'){
            /* Clima */
            $this->climaForm = /* 'No aplica' */0;
            
            /* Resultado Financiero */
            $this->resFinancieroForm = 'No aplica';
            
            /* Evaluacion */
            $this->evaluacionForm = /* 'No aplica' */0;
            
            /* Autoevaluacion */
            $this->autoevaluacionForm = 'No aplica';
            
            /* Evaluacion 270 */
            $EvaluacionValor270_1 = $this->apiObtn($check,$this->colaborador[1][0]->Column_270_1);
            $EvaluacionValor270_1 = $this->camposNull($EvaluacionValor270_1);
    
            $EvaluacionValor270_2 = $this->apiObtn($check,$this->colaborador[1][0]->Column_270_2);
            $EvaluacionValor270_2 = $this->camposNull($EvaluacionValor270_2);
    
            $EvaluacionValor270_3 = $this->apiObtn($check,$this->colaborador[1][0]->Column_270_3);
            $EvaluacionValor270_3 = $this->camposNull($EvaluacionValor270_3);
    
            $EvaluacionValor270_4 = $this->apiObtn($check,$this->colaborador[1][0]->Column_270_4);
            $EvaluacionValor270_4 = $this->camposNull($EvaluacionValor270_4);
    
            $EvaluacionValor270_5 = $this->apiObtn($check,$this->colaborador[1][0]->Column_270_5);
            $EvaluacionValor270_5 = $this->camposNull($EvaluacionValor270_5);
    
            $EvaluacionValor270_6 = $this->apiObtn($check,$this->colaborador[1][0]->Column_270_6);
            $EvaluacionValor270_6 = $this->camposNull($EvaluacionValor270_6);
    
            $EvaluacionValor270_7 = $this->apiObtn($check,$this->colaborador[1][0]->Column_270_7);
            $EvaluacionValor270_7 = $this->camposNull($EvaluacionValor270_7);
    
            $evaluacion_270 = [
                $EvaluacionValor270_1,$EvaluacionValor270_2,
                $EvaluacionValor270_3,$EvaluacionValor270_4,
                $EvaluacionValor270_5,$EvaluacionValor270_6,$EvaluacionValor270_7
            ];

            $this->evaluacion_270Form = (array_sum($evaluacion_270) / 7);
            $this->evaluacion_270Form = $this->formatonumero($this->evaluacion_270Form);
            
            $this->valor270 = $this->calcularPorcentaje('270',$evaluacion_270,$this->puesto);
            
            /* Suma de las todas las calificaciones y mostrar resultado */
            $total = [$this->valor270];
            $this->resDesempeno = $this->calcularPorcentaje('total',$total,$this->puesto);
            $this->resDesempeno2 = $this->nineBox2($this->evaluacionForm,$this->evaluacion_270Form,$this->climaForm);

            $this->nineBoxUbicar($this->resDesempeno2);
    
        }elseif($this->puesto == 'Gerente'){
            
            /* Clima */
            $this->climaValor = $this->calcularPorcentaje('clima',$clima,$this->puesto);

            /* Resultado Financiero */
            $resFinancieroObtn = $this->camposNull($this->colaborador[1][0]->resultFinanciero);
            $this->resFinancieroForm = $resFinancieroObtn;
            $this->resFinanciero = $this->calcularPorcentaje('resultadoFinanciero',$resFinancieroObtn,$this->puesto);
            
            /* Evaluacion */
            $EvaluacionValor = $this->apiObtn($check,$this->colaborador[1][0]->evaluacion);
            $EvaluacionValor = $this->camposNull($EvaluacionValor);
            $this->evaluacionForm = $EvaluacionValor;
            $this->evaluacionValor = $this->calcularPorcentaje('evaluacion',$EvaluacionValor,$this->puesto);

            /* Autoevaluacion */
            $this->autoevaluacionForm = $this->apiObtn($check,$this->colaborador[1][0]->autoEvaluacion); 
            $this->autoevaluacionForm = $this->camposNull($this->autoevaluacionForm);

            /* Evaluacion 270 */
            $EvaluacionValor270_1 = $this->apiObtn($check,$this->colaborador[1][0]->Column_270_1);
            $EvaluacionValor270_1 = $this->camposNull($EvaluacionValor270_1);
    
            $EvaluacionValor270_2 = $this->apiObtn($check,$this->colaborador[1][0]->Column_270_2);
            $EvaluacionValor270_2 = $this->camposNull($EvaluacionValor270_2);
    
            $EvaluacionValor270_3 = $this->apiObtn($check,$this->colaborador[1][0]->Column_270_3);
            $EvaluacionValor270_3 = $this->camposNull($EvaluacionValor270_3);
    
            $evaluacion_270 = [ $EvaluacionValor270_1,$EvaluacionValor270_2,$EvaluacionValor270_3 ];

            $this->evaluacion_270Form = (array_sum($evaluacion_270) / 3);
            $this->evaluacion_270Form = $this->formatonumero($this->evaluacion_270Form);

            $this->valor270 = $this->calcularPorcentaje('270',$evaluacion_270,$this->puesto);
            
            /* Suma de todas las calificaciones y mostrar resultado */
            $total = [$this->climaValor, $this->resFinanciero, $this->evaluacionValor, $this->valor270];
            $this->resDesempeno = $this->calcularPorcentaje('total',$total,$this->puesto);
            $this->resDesempeno2 = $this->nineBox2($this->evaluacionForm,$this->evaluacion_270Form,$this->climaForm);
            /* dd($this->resDesempeno,$this->resDesempeno2); */
            $this->nineBoxUbicar($this->resDesempeno2);

        }elseif($this->puesto == 'Gerente_270'){

            /* Clima */
            $this->climaForm = 'No aplica';
            
            /* Resultado Financiero */
            $this->resFinancieroForm = 'No aplica';
            
            /* Evaluacion */
            $this->evaluacionForm = 0;
            
            /* Autoevaluacion */
            $this->autoevaluacionForm = 'No aplica';

            /* Evaluacion 270 */
            $EvaluacionValor270_1 = $this->apiObtn($check,$this->colaborador[1][0]->Column_270_1);
            $EvaluacionValor270_1 = $this->camposNull($EvaluacionValor270_1);
    
            $EvaluacionValor270_2 = $this->apiObtn($check,$this->colaborador[1][0]->Column_270_2);
            $EvaluacionValor270_2 = $this->camposNull($EvaluacionValor270_2);
    
            $EvaluacionValor270_3 = $this->apiObtn($check,$this->colaborador[1][0]->Column_270_3);
            $EvaluacionValor270_3 = $this->camposNull($EvaluacionValor270_3);
    
            $evaluacion_270 = [ $EvaluacionValor270_1,$EvaluacionValor270_2,$EvaluacionValor270_3 ];

            $this->evaluacion_270Form = (array_sum($evaluacion_270) / 3);
            $this->evaluacion_270Form = $this->formatonumero($this->evaluacion_270Form);

            $this->valor270 = $this->calcularPorcentaje('270',$evaluacion_270,$this->puesto);
            
            /* Suma de todas las calificaciones y mostrar resultado */
            $total = [$this->valor270];
            $this->resDesempeno = $this->calcularPorcentaje('total',$total,$this->puesto);
            $this->resDesempeno2 = $this->nineBox2($this->evaluacionForm,$this->evaluacion_270Form,/* $this->climaForm */0);

            $this->nineBoxUbicar($this->resDesempeno2);
        }else{
            /* Clima */
            $this->climaValor = $this->calcularPorcentaje('clima',$clima,$this->puesto);
            /* Autoevaluación */
            $autoevaluacionObtn = $this->apiObtn($check,$this->colaborador[1][0]->autoEvaluacion);
            $autoevaluacionObtn = $this->camposNull($autoevaluacionObtn);
            $this->autoevaluacionForm = $autoevaluacionObtn;
            $this->autoevaluacionValor = $this->calcularPorcentaje('autoevaluacion',$autoevaluacionObtn,$this->puesto);
            
            /* Evaluación */
            $evaluacionObtn = $this->apiObtn($check,$this->colaborador[1][0]->evaluacion);
            
            $evaluacionObtn = $this->camposNull($evaluacionObtn);
            $this->evaluacionForm = $evaluacionObtn;
            $this->evaluacionValor = $this->calcularPorcentaje('evaluacion',$evaluacionObtn,$this->puesto);
            
            /* Suma de las 3 calificaciones y mostrar resultado */
            $total = [$this->climaValor, $this->autoevaluacionValor, $this->evaluacionValor];
            $this->resDesempeno = $this->calcularPorcentaje('total',$total,$this->puesto);
            $this->nineBoxUbicar($this->resDesempeno);
        }

    }

    public function render()
    {
        return view('livewire.evaluacion-desempeno')->layout('layouts.guest');
    }


    /* Obtener datos del MagicForm desde la API de Factor */
    public function apiObtn($check,$valor)
    {
        
        /* Limpia el cache */
        Artisan::call('cache:clear');

        /* Consumir una api */
        $res = Http::get('https://factoraguila.com/restapi/index.php',[
            'check'=>$check,
            'formid'=>$valor
        ]);

        $res = $res->body();
        $res = $this->encrypt_decrypt($res);
        
        return json_decode($res);
    }   

    /* Desencriptar información obtenida de la API */
    public function encrypt_decrypt($string) {
        $output = false;
     
        $encrypt_method = "AES-128-ECB";
        $key = '2=XG&%ac~Nu2H[9';
     
        $output = openssl_decrypt($string, $encrypt_method, $key);
     
        return $output;
    }

    /* Filtra datos por array, subtrae el ultimo array y retorna el valor  
    de la encuenesta en un float*/
    public function filtrarValor($filtrar)
    {
        /* Filtrar los arreglos */
        $filtered = Arr::where($filtrar,function($value){
            return is_array($value);
        });
        /* Obtener el ultimo valor del arreglo */
        $ultimo = last($filtered);
        return $this->formatonumero($ultimo['value']);
    }

    /* Accede a la key data del jsn obtenido de la API */
    public function obtnData($datos)
    {
        /* Obtener la claificación del formulario */
        $res = json_decode($datos[0]->data, true);
    
        return $this->filtrarValor($res);
    }

    
    /* Calcula el porcentaje de todas las calificaciones obtenidas de los formulario*/
    public function calcularPorcentaje($tipo,$valor,$puesto)
    {

        if($puesto == 'Director' || $puesto == 'Director_270'){

            if ( $tipo == '270' && is_array($valor)) {
            
                $total270 = array_sum($valor);
                return $this->formatonumero($total270 / 7*0.10);
    
            }elseif($tipo == 'total' && is_array($valor)){
                return array_sum($valor);
            }else{
                if ($tipo == 'clima') {
                    return $this->formatonumero($valor * 0.10);
                }elseif($tipo == 'resultadoFinanciero'){
                    return $this->formatonumero($valor * 0.20);
                }elseif($tipo == 'evaluacion'){
                    return $this->formatonumero($valor * 0.60);
                }
            }

        }elseif($puesto == 'Gerente' || $puesto == 'Gerente_270'){

            if ( $tipo == '270' && is_array($valor)) {
            
                $total270 = array_sum($valor);

                return $this->formatonumero($total270 / 3*0.10);
    
            }elseif($tipo == 'total' && is_array($valor)){
                return array_sum($valor);
            }else{
                if ($tipo == 'clima') {
                    return $this->formatonumero($valor * 0.10);
                }elseif($tipo == 'resultadoFinanciero'){
                    return $this->formatonumero($valor * 0.20);
                }elseif($tipo == 'evaluacion'){
                    return $this->formatonumero($valor * 0.60);
                }
            }

        }else{
            /* Administrativo */
            if ($tipo == 'clima') {
                return $this->formatonumero($valor * 0.20);
            }elseif($tipo == 'autoevaluacion'){
                return $this->formatonumero($valor * 0.05);
            }elseif($tipo == 'evaluacion'){
                return $this->formatonumero($valor * 0.75);
            }else{
                /* Total */
                return array_sum($valor);
            }

        }

    }

    /* Pasa el valor obtenido a un float de con dos digitos(12.00) */
    public function formatonumero($cantidad){
        return (float)number_format($cantidad,1);
        
    }

    /* NINEBOX generar ubucación */
    public function nineBoxUbicar($resultado){
        
        $this->reset([ 'box1','box2','box3','box4','box5','box6','box7','box8','box9' ]);

        $iconoExcelente = '<img alt="profil" src="'.asset('images/nineBox/Excelente_Emoticon.png').'" class="mx-auto object-cover" style="width:76%;height:auto;" loading="lazy" />';

        $iconoBien = '<img alt="profil" src="'.asset('images/nineBox/Bien_Emoticon.png').'" class="mx-auto object-cover" style="width:76%;height:auto;" loading="lazy" />';

        $iconoRegular = '<img alt="profil" src="'.asset('images/nineBox/Regular_Emoticon.png').'" class="mx-auto object-cover overflow-hidden" style="width:76%;height:auto;" loading="lazy" />';

        $iconoMal = '<img alt="profil" src="'.asset('images/nineBox/Mal_Emoticon.png').'" class="mx-auto object-cover" style="width:76%;height:auto;" loading="lazy" />';

        /* Info del resultado */

        if ( ($resultado >= 80 || $resultado >= 80.0) && ($resultado<= 82.5) ) {
            return $this->box1 = $iconoBien; 
        }elseif( ($resultado >= 92.6) && ($resultado<= 94.5) ){
            return $this->box2 = $iconoExcelente; 
        }elseif( ($resultado >= 95 || $resultado >= 95.0) && ($resultado<= 100) ){
            return $this->box3 = $iconoExcelente; 
        }elseif( ($resultado >= 70 || $resultado >= 70.0) && ($resultado<= 74.9) ){
            return $this->box4 = $iconoRegular; 
        }elseif( ($resultado >= 82.6) && ($resultado<= 84.9) ){
            return $this->box5 = $iconoBien; 
        }elseif( ($resultado >= 90 || $resultado >= 90.0) && ($resultado<= 92.5) ){
            return $this->box6 = $iconoExcelente; 
        }elseif( $resultado < 69 ) {
            return $this->box7 = $iconoMal; 
        }elseif( ($resultado >= 75 || $resultado >= 75.0) && ($resultado<= 79 || $resultado <=79.9) ){
            return $this->box8 = $iconoRegular; 
        }elseif( ($resultado >= 85 || $resultado >= 85.0) && ($resultado<= 89.9) ){
            return $this->box9 = $iconoBien; 
        }

    }

    /* Buscar colaborador */
    public function buscaColaborador($no_colaborador)
    {
        /* colaborador aguila ammunation */
        $buscar = DB::table('infocolaborador')->where('no_colaborador',$no_colaborador)->get();
        if ( count($buscar) > 0) {
            /* Limpia el cache */
            Artisan::call('cache:clear');

            $formResultados = $this->buscarFormulario($buscar[0]->no_colaborador);

            return [$buscar,$formResultados];
        }else{
            /* Colaborador txat,sapi,spv3 */
            $buscar = DB::table('colaborador_sapi_spv3')->where('no_colaborador',$no_colaborador)->get();
            if (count($buscar) > 0) {

                if(count($buscar) == 2){
                    /* Limpia el cache */
                    Artisan::call('cache:clear');

                    $formResultados = $this->buscarFormulario($buscar[1]->no_colaborador);
                    $buscar = collect([0=>$buscar[1]]);
                    return [$buscar,$formResultados];
                }else{
                    /* Limpia el cache */
                    Artisan::call('cache:clear');

                    $formResultados = $this->buscarFormulario($buscar[0]->no_colaborador);

                    return [$buscar,$formResultados];
                }
                
            }else{
                return abort(403, 'No existe el número de colaborador');
            }

        }
    }

    public function buscarFormulario($no_colaborador)
    {
        return DB::table('evaluacion_desempeno')->where('numColab',$no_colaborador)->get();
        
    }

    /* Si un campo es null mandar 0 sino retorna el resultado */
    public function camposNull($valor){
        if (is_array($valor)) {
            return (count($valor) > 0) ? $this->obtnData($valor) : 0 ;
        }else{
            return ($valor != null) ? $valor : 0 ;
        }
    }

    /* calcular el nineBox 2 =Directores,Gerentes= */
    public function nineBox2($jefeDirecto,$eval270,$clima)
    {
        $jDRes = $jefeDirecto*.70;
        $eval270Res = $eval270*0.20;
        $climaRes = $clima*0.10;

        $jDRes = $this->formatonumero($jDRes);
        $eval270Res = $this->formatonumero($eval270Res);
        $climaRes = $this->formatonumero($climaRes);

        return $jDRes+$eval270Res+$climaRes;

    }

    /* Exportar pdf */
    public function pdfExportar()
    {
        $viewData = [];

        if($this->puesto == 'Administrativo')
        {

            $viewData = [
                'foto' =>$this->foto,
                'nombre'=>$this->nombre,
                'puesto'=>$this->puesto,
                'climaForm'=>$this->climaForm,
                'autoevaluacionForm'=>$this->autoevaluacionForm,
                'evaluacionForm'=>$this->evaluacionForm ,
                'resDesempeno'=>$this->resDesempeno,
                'box1'=>$this->box1,
                'box2'=>$this->box2,
                'box3'=>$this->box3,
                'box4'=>$this->box4,
                'box5'=>$this->box5,
                'box6'=>$this->box6,
                'box7'=>$this->box7,
                'box8'=>$this->box8,
                'box9'=>$this->box9,
            ];
            
            
            
        }

        $pdf = PDF::loadView('pdf.evaluacion_desempeno_pdf',$viewData)->output();

        
        return response()->streamDownload(
            fn () => print($pdf),
            'test'. ".pdf"
        );
    }

}