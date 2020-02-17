<?php

namespace App\Http\Controllers;

use App\Models\Agenda\Agenda;
use App\Models\Especialista\Especialista;
use App\Models\Sede\Sede;
use DateInterval;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InicioController extends Controller
{
    private $Emp = 'ALF';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        setlocale(LC_ALL,"es_ES@euro","es_ES","esp");
        // DB::listen(function ($query) {
                
        //     if(strpos($query->sql, "GCAGENDA") !== FALSE)
        //     {
        //         echo "<pre>".print_r($query->sql,1)."</pre>";
        //         echo "<pre>".print_r($query->bindings,1)."</pre>";
        //     }
        // //     $query->bindings
        // //     $query->time
        // });
        if (session()->get('Rol_nombre')) {
            if(!$request->sede){
            $sedes = Sede::get();
            $especialistas = Especialista::where('Ve_ven_depto', '=', 'V1')
                                         ->with('departamento')
                                         ->get();
            }else{
                $sedes = Sede::get();
                $especialistas = Especialista::where('Ve_ven_depto', '=', 'V'.$request->sede)
                                            ->with('departamento')
                                            ->get();
            }


            if (!$request->accion) {
                $fechaActual = new DateTime(date('d-m-Y'));
                $fechaInicio = new DateTime(date('d-m-Y'));
                $fechaTermino = $fechaActual->add(new DateInterval('P6D'));
            }else{
                if($request->accion == 'siguiente'){
                    $fechaTemporal = new DateTime(date('d-m-Y', strtotime($request->fechaTermino)));
                    $fechaInicio = new DateTime(date('d-m-Y', strtotime($request->fechaTermino)));
                    $fechaInicio = $fechaInicio->add(new DateInterval('P1D'));
                    $fechaTermino = $fechaTemporal->add(new DateInterval('P7D'));
                }
                if($request->accion == 'anterior'){
                    $fechaTemporal = new DateTime(date('d-m-Y', strtotime($request->fechaInicio)));
                    $fechaTermino = new DateTime(date('d-m-Y', strtotime($request->fechaInicio)));
                    $fechaTermino = $fechaTermino->sub(new DateInterval('P1D'));
                    $fechaInicio = $fechaTemporal->sub(new DateInterval('P7D'));
                }
            }

            $diaSemana = array("Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab");

            $horaInicio = DateTime::createFromFormat('H:i', '09:00');            
            $horaTermino = DateTime::createFromFormat('H:i', '18:45');

            $semana = array();
            for ($hora = $horaInicio; $hora <= $horaTermino; $hora->add(new DateInterval('PT15M'))) {
                $horaFin = strtotime("+15 minutes", strtotime($hora->format('H:i')));
                $dia = array();
                $dia["Hora"] = $hora->format('H:i') . ' - ' . date('H:i', $horaFin);
                for ($fecha = new DateTime(date('d-m-Y', strtotime($fechaInicio->format('d-m-Y'))));
                     $fecha <= $fechaTermino; 
                     $fecha->add(new DateInterval('P1D')))
                {
                    //armo las horas con la fecha del ciclo $fecha
                    $dateStart = date('d-m-Y H:i:s', strtotime($fecha->format('Y-m-d')." ".$hora->format('H:i:s')));
                    $dateEnd   = date('d-m-Y H:i:s', strtotime($fecha->format('Y-m-d')." ".date('H:i:s', $horaFin)));

                    $agenda = Agenda::where('Age_EmpCod', '=', $this->Emp)
			                        // ->where('Age_SedCod', '=', $request->sede)
			                        // ->where('Age_EspCod', '=', $request->especialista)// or NULL(&Especialista)
                                    // ->whereDate('Age_Fecha', '=', date($fecha->format('Y-m-d')))
                                    //->whereDate('Age_Fecha', '>=', $fecha->format('d-m-Y'))
                                    ->where('Age_Inicio', '<=', $dateStart)
                                    ->where('Age_Fin', '>=', $dateEnd)
                                    ->first();

                    //echo "<pre>".print_r($dateStart,1)."</pre>";
                    //echo "<pre>".print_r($dateEnd,1)."</pre>";                                                         
                                    // dd($agenda);                    
                    // &Estado = Age_Estado
                    // &Servicio = 'Sin Disponibilidad'
                    // &CodigoAgenda = Age_AgeCod
                    if($agenda){
                        $dia[$diaSemana[$fecha->format('w')] . ' ' . $fecha->format('d-m')] = 'Ocupado';
                    } else {
                        $dia[$diaSemana[$fecha->format('w')] . ' ' . $fecha->format('d-m')] = 'Disponible';
                    }
                    if ($fecha == $fechaTermino) {
                        array_push($semana, $dia);
                    }
                }              
            }
            
            //  dd($semana);
            // array_push($semana, ["Hora" => $horas]);
            //  foreach ($semana as $key => $item){
            //     echo $key.'<br>';
            //  }
            return view('inicio', compact('agenda','sedes', 'especialistas','fechaInicio', 'fechaTermino', 'semana', 'request'));
        } else {
            return view('seguridad.index');
        }
    }
    public function agendar($hora, $dia, $especialista, $cliente){

    }
}
