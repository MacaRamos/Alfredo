<?php

namespace App\Http\Controllers;

use DateInterval;
use DateTime;

class InicioController extends Controller
{
    private $Emp = 'INS';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        if (session()->get('Rol_nombre')) {
            $fechaInicio = new DateTime(date('d-m-Y'));
            $fechaTermino = $fechaInicio->add(new DateInterval('P6D'));

            $diaSemana = array("Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab");

            $horaInicio = DateTime::createFromFormat('H:i', '09:00');
            $horaTermino = DateTime::createFromFormat('H:i', '18:45');

            $semana = array();
            for ($hora = $horaInicio; $hora <= $horaTermino; $hora->add(new DateInterval('PT15M'))) {
                $horaFin = strtotime("+15 minutes", strtotime($hora->format('H:i')));
                $dia = array();
                $dia["Hora"] = $hora->format('H:i').' - '.date('H:i', $horaFin);
                for ($fecha = new DateTime(date('d-m-Y')); $fecha <= $fechaTermino; $fecha->add(new DateInterval('P1D'))) {
                    if($fecha->format('d-m-Y') == '18-02-2020' && $hora->format('H:i')== '17:00'){
                        $dia[$diaSemana[$fecha->format('w')].' '.$fecha->format('d-m')] = 'Ocupado';
                    }else{
                    $dia[$diaSemana[$fecha->format('w')].' '.$fecha->format('d-m')] = 'Disponible';
                    }
                    if($fecha == $fechaTermino){
                        array_push($semana,$dia);
                    }
                }
            }
            // array_push($semana, ["Hora" => $horas]);
            //  foreach ($semana as $key => $item){
            //     echo $key.'<br>';
            //  }
            return view('inicio', compact('horaInicio', 'horaTermino', 'semana'));
        } else {
            return view('seguridad.index');
        }
    }
}
