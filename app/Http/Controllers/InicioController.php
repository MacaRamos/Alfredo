<?php

namespace App\Http\Controllers;

use App\Models\Agenda\AgeDet;
use App\Models\Agenda\Agenda;
use App\Models\Agenda\Parametro;
use App\Models\Cliente\Cliente;
use App\Models\Especialista\Especialista;
use App\Models\Sede\Sede;
use App\Models\Servicio\Servicio;
use App\Rules\ValidarDuracionHora;
use App\Rules\ValidarHoraCliente;
use App\Rules\ValidarHoraFinal;
use DateInterval;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use stdClass;

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
        setlocale(LC_ALL, "es_ES@euro", "es_ES", "esp");

        $ficha = session()->get("ficha");
        if (isset($ficha)) {
            if ($request->ficha) {
                if ($request->ficha <= $ficha) {
                    $request->accion = "";
                }
                session()->put("ficha", $request->ficha);
            }
        } else {
            session()->put("ficha", 0);
        }
        // DB::listen(function ($query) {

        //     if(strpos($query->sql, "GCAGENDA") !== FALSE)
        //     {
        //         echo "<pre>".print_r($query->sql,1)."</pre>";
        //         echo "<pre>".print_r($query->bindings,1)."</pre>";
        //     }
        // //     $query->bindings
        // //     $query->time
        // });
        $notificacion = null;
        if (session()->get('Rol_nombre')) {
            // dd($request->all());
            switch ($request->accion) {
                case 'siguiente':
                    if ($request->pestana == '#semana') {
                        $fechaTemporal = new DateTime(date('d-m-Y', strtotime($request->fechaTermino)));
                        $fechaInicio = new DateTime(date('d-m-Y', strtotime($request->fechaTermino)));
                        $fechaInicio = $fechaInicio->add(new DateInterval('P1D'));
                        $fechaTermino = $fechaTemporal->add(new DateInterval('P7D'));
                        $fechaDia = $fechaInicio;
                    } else if ($request->pestana == '#dia') {
                        $fechaTemporal = new DateTime(date('d-m-Y', strtotime($request->fechaDia)));
                        $fechaDia = $fechaTemporal->add(new DateInterval('P1D'));

                        $fechaInicio = new DateTime(date('d-m-Y', strtotime($request->fechaInicio)));
                        $fechaTermino = new DateTime(date('d-m-Y', strtotime($request->fechaTermino)));

                        if ($fechaDia > $fechaTermino) {
                            $fechaTemporal = new DateTime(date('d-m-Y', strtotime($request->fechaTermino)));
                            $fechaInicio = new DateTime(date('d-m-Y', strtotime($request->fechaTermino)));
                            $fechaInicio = $fechaInicio->add(new DateInterval('P1D'));
                            $fechaTermino = $fechaTemporal->add(new DateInterval('P7D'));
                        }
                    }
                    break;
                case 'anterior':
                    if ($request->pestana == '#semana') {
                        $fechaTemporal = new DateTime(date('d-m-Y', strtotime($request->fechaInicio)));
                        $fechaTermino = new DateTime(date('d-m-Y', strtotime($request->fechaInicio)));
                        $fechaTermino = $fechaTermino->sub(new DateInterval('P1D'));
                        $fechaInicio = $fechaTemporal->sub(new DateInterval('P7D'));
                    } else if ($request->pestana == '#dia') {
                        $fechaTemporal = new DateTime(date('d-m-Y', strtotime($request->fechaDia)));
                        $fechaDia = $fechaTemporal->sub(new DateInterval('P1D'));

                        $fechaInicio = new DateTime(date('d-m-Y', strtotime($request->fechaInicio)));
                        $fechaTermino = new DateTime(date('d-m-Y', strtotime($request->fechaTermino)));

                        if ($fechaDia < $fechaInicio) {
                            $fechaTemporal = new DateTime(date('d-m-Y', strtotime($request->fechaInicio)));
                            $fechaTermino = new DateTime(date('d-m-Y', strtotime($request->fechaInicio)));
                            $fechaTermino = $fechaTermino->sub(new DateInterval('P1D'));
                            $fechaInicio = $fechaTemporal->sub(new DateInterval('P7D'));
                        }
                    }
                    break;
                case 'agendar':
                    $agenda = Agenda::get();
                    if (isset($agenda)) {
                        $agenda = Agenda::where('Age_EmpCod', '=', $this->Emp)
                            ->where('Age_SedCod', '=', $request->mSede)
                            ->where('Age_EspCod', '=', $request->mOpcionEspecialista)
                            ->where('Age_Fecha', '=', date('d-m-Y', strtotime($request->mfechaAgenda)))
                            ->where('Age_Inicio', '=', date('d-m-Y H:i', strtotime(date('d-m-Y', strtotime($request->mfechaAgenda)) . " " . $request->mHoraInicio)))
                            ->where('Age_Fin', '=', date('d-m-Y H:i', strtotime(date('d-m-Y', strtotime($request->mfechaAgenda)) . " " . $request->mHoraFin)))
                            ->first();
                        if (!$agenda) {
                            $notificacion = $this->agendar($request);
                        }
                    }

                    $fechaInicio = new DateTime(date('d-m-Y', strtotime($request->fechaInicio)));
                    $fechaTermino = new DateTime(date('d-m-Y', strtotime($request->fechaTermino)));
                    $fechaDia = new DateTime(date('d-m-Y', strtotime($request->fechaDia)));
                    break;
                case 'editar':
                    $notificacion = $this->editar($request);
                    $fechaInicio = new DateTime(date('d-m-Y', strtotime($request->fechaInicio)));
                    $fechaTermino = new DateTime(date('d-m-Y', strtotime($request->fechaTermino)));
                    $fechaDia = new DateTime(date('d-m-Y', strtotime($request->fechaDia)));
                    break;
                case 'confirmar':
                    $agenda = Agenda::where('Age_AgeCod', '=', $request->Age_AgeCod)
                        ->where('Age_Estado', '=', 'C')->first();
                    if (!isset($agenda)) {
                        $notificacion = $this->confirmarAgenda($request);
                    }
                    $fechaInicio = new DateTime(date('d-m-Y', strtotime($request->fechaInicio)));
                    $fechaTermino = new DateTime(date('d-m-Y', strtotime($request->fechaTermino)));
                    $fechaDia = new DateTime(date('d-m-Y', strtotime($request->fechaDia)));
                    break;
                case 'noAsiste':
                    $agenda = Agenda::where('Age_AgeCod', '=', $request->Age_AgeCod)
                        ->where('Age_Estado', '=', 'F')->first();
                    if (!isset($agenda)) {
                        $notificacion = $this->noAsiste($request);
                    }
                    $fechaInicio = new DateTime(date('d-m-Y', strtotime($request->fechaInicio)));
                    $fechaTermino = new DateTime(date('d-m-Y', strtotime($request->fechaTermino)));
                    $fechaDia = new DateTime(date('d-m-Y', strtotime($request->fechaDia)));
                    break;
                case 'sinRespuesta':
                    // dd($request->all());
                    $agenda = Agenda::where('Age_AgeCod', '=', $request->Age_AgeCod)
                        ->where('Age_Estado', '=', 'D')->first();
                    if (!isset($agenda)) {
                        $notificacion = $this->sinRespuesta($request);
                    }
                    $fechaInicio = new DateTime(date('d-m-Y', strtotime($request->fechaInicio)));
                    $fechaTermino = new DateTime(date('d-m-Y', strtotime($request->fechaTermino)));
                    $fechaDia = new DateTime(date('d-m-Y', strtotime($request->fechaDia)));
                    break;
                case 'eliminar':
                    $agenda = Agenda::where('Age_AgeCod', '=', $request->Age_AgeCod)->first();
                    if (isset($agenda)) {
                        $notificacion = $this->eliminarAgenda($request);
                    }
                    $fechaInicio = new DateTime(date('d-m-Y', strtotime($request->fechaInicio)));
                    $fechaTermino = new DateTime(date('d-m-Y', strtotime($request->fechaTermino)));
                    $fechaDia = new DateTime(date('d-m-Y', strtotime($request->fechaDia)));
                    break;
                default:
                    $fechaActual = new DateTime(date('d-m-Y'));
                    $fechaInicio = new DateTime(date('d-m-Y'));
                    $fechaDia = new DateTime(date('d-m-Y'));
                    $fechaTermino = $fechaActual->add(new DateInterval('P6D'));
                    break;
            }

            if (!isset($request->sede)) {
                $sedes = Sede::get();
                $especialistas = Especialista::where('Ve_ven_depto', '=', 'V1')
                    ->where('Ve_tipo_ven', '=', 'P')
                    ->with('departamento')
                    ->get();
            } else {
                $sedes = Sede::get();
                $especialistas = Especialista::where('Ve_ven_depto', '=', 'V' . $request->sede)
                    ->with('departamento')
                    ->get();
            }

            $semana = $this->llenarSemana($fechaInicio, $fechaTermino, $request->sede ?? null, $request->especialista ?? null);
            $dia = $this->llenarDia($fechaDia, $request->sede ?? null);
            //$mes = $this->llenarMes($fechaDia, $request->sede ?? null);
            return view('inicio', compact('sedes', 'especialistas', 'fechaDia', 'fechaInicio', 'fechaTermino', 'semana', 'dia', 'request', 'notificacion'));
        } else {
            return view('seguridad.index');
        }
    }

    private function llenarSemana($fechaInicio, $fechaTermino, $sede = null, $especialista = null)
    {

        $horaInicio = DateTime::createFromFormat('H:i', '09:00');
        $horaTermino = DateTime::createFromFormat('H:i', '18:45');
        if ($sede) {
            $especialistas = Especialista::where('Ve_ven_depto', '=', 'V' . $sede)
                ->with('departamento')
                ->get();
        } else {
            $especialistas = Especialista::where('Ve_ven_depto', '=', 'V1')
                ->where('Ve_tipo_ven', '=', 'P')
                ->with('departamento')
                ->get();
        }

        $semana = array();
        for ($hora = $horaInicio; $hora <= $horaTermino; $hora->add(new DateInterval('PT15M'))) {
            $horaFin = strtotime("+15 minutes", strtotime($hora->format('H:i')));
            $datos = new stdClass;
            $datos->Hora = $hora->format('H:i') . ' - ' . date('H:i', $horaFin);
            $dias = array();
            for ($fecha = new DateTime(date('d-m-Y', strtotime($fechaInicio->format('d-m-Y'))));
                $fecha <= $fechaTermino;
                $fecha->add(new DateInterval('P1D'))) {
                //armo las horas con la fecha del ciclo $fecha
                $dateStart = date('d-m-Y H:i:s', strtotime($fecha->format('Y-m-d') . " " . $hora->format('H:i:s')));
                $dateEnd = date('d-m-Y H:i:s', strtotime($fecha->format('Y-m-d') . " " . date('H:i:s', $horaFin)));

                $agenda = Agenda::where('Age_EmpCod', '=', $this->Emp)
                    ->where(function ($q) use ($sede) {
                        if ($sede) {
                            $q->where('Age_SedCod', $sede);
                        }
                    })
                    ->whereHas('especialista', function ($q) use ($especialista) {
                        if ($especialista) {
                            $q->where('Age_EspCod', '=', $especialista);
                        }
                    })
                    ->with('especialista')
                // ->where(function ($q) use ($especialista) {
                //     if ($especialista) {
                //         $q->where('Age_EspCod', $especialista);
                //     }
                // })
                    ->where('Age_Inicio', '<=', $dateStart)
                    ->where('Age_Fin', '>=', $dateEnd)
                    ->with('estado')
                    ->with('cliente')
                    ->with('lineasDetalle', 'lineasDetalle.articulo')
                    ->with(["lineasDetalle.articulo.tiempoEspecialista" => function ($q) use ($especialista) {
                        $q->where('Ser_EspCod', 'like', '%' . $especialista . '%');
                    }])
                    ->with('lineasDetalle.articulo.tiempoGeneral')
                    ->get();

                if (count($agenda) > 0) {

                    if ($especialista == null) {
                        if (count($especialistas) > 0) {
                            $completado = (count($agenda) * 100) / count($especialistas);
                        } else {
                            $completado = 0;
                        }
                        $array1 = array();
                        foreach ($agenda as $a) {
                            array_push($array1, $a->especialista["Ve_nombre_ven"]);
                        }
                        $array2 = array();
                        foreach ($especialistas as $esp) {
                            array_push($array2, $esp['Ve_nombre_ven']);
                        }
                        // if($dateStart == '06-03-2020 09:45:00'){
                        $disponibles = array_diff($array2, $array1);
                        // dd($disponibles);
                        // }

                        if ($completado == 0) {
                            $estado = array("Color" => 'fff', "Nombre" => 'DISPONIBLE', "Clase" => 'bg-white');
                            $dias[$fecha->format('d-m-Y')] = (object) array("Age_Inicio" => $dateStart, "Age_Fin" => $dateEnd, "Age_Estado" => 'A', "estado" => $estado, "disponibles" => $disponibles);
                        } else if ($completado < 75) {
                            $estado = array("Color" => 'ffc107', "Nombre" => 'MEDIANAMENTE OCUPADO', "Clase" => 'bg-warning');
                            $dias[$fecha->format('d-m-Y')] = (object) array("Age_Inicio" => $dateStart, "Age_Fin" => $dateEnd, "Age_Estado" => 'Z', "estado" => $estado, "disponibles" => $disponibles);
                        } else if ($completado >= 75 && $completado < 100) {
                            $estado = array("Color" => 'ff851b', "Nombre" => 'CASI OCUPADO', "Clase" => 'bg-orange');
                            $dias[$fecha->format('d-m-Y')] = (object) array("Age_Inicio" => $dateStart, "Age_Fin" => $dateEnd, "Age_Estado" => 'Z', "estado" => $estado, "disponibles" => $disponibles);
                        } else if ($completado == 100) {
                            $estado = array("Color" => 'dc3545', "Nombre" => 'FULL OCUPADO', "Clase" => 'bg-danger');
                            $dias[$fecha->format('d-m-Y')] = (object) array("Age_Inicio" => $dateStart, "Age_Fin" => $dateEnd, "Age_Estado" => 'Z', "estado" => $estado, "disponibles" => $disponibles);
                        }
                    } else {
                        if (new DateTime(date('d-m-Y H:i')) >= new DateTime(date('d-m-Y H:i', strtotime($agenda[0]->Age_Inicio)))
                            && new DateTime(date('d-m-Y H:i')) <= new DateTime(date('d-m-Y H:i', strtotime($agenda[0]->Age_Fin)))) {
                            $agenda[0]->Age_Estado = 'E'; //EN CURSO
                            $agenda[0]->update();
                        }
                        $dias[$fecha->format('d-m-Y')] = (object) $agenda[0];
                    }

                } else {
                    // $dia[$diaSemana[$fecha->format('w')] . ' ' . $fecha->format('d-m')] = 'Disponible';
                    $dias[$fecha->format('d-m-Y')] = (object) array("Age_Inicio" => $dateStart, "Age_Fin" => $dateEnd, "Age_Estado" => 'A');
                }
                if ($fecha == $fechaTermino) {
                    $datos->dias = $dias;
                    array_push($semana, $datos);
                }
            }
        }
        // dd($semana);
        // foreach ($semana as $key => $horas){
        //     foreach ($semana[$key] as $index => $datos){
        //         echo $datos.'<br>';
        //     }
        // }
        return $semana;
    }

    private function llenarDia($fechaDia, $sede = null)
    {
        $horaInicio = DateTime::createFromFormat('H:i', '09:00');
        $horaTermino = DateTime::createFromFormat('H:i', '18:45');
        if ($sede) {
            $especialistas = Especialista::where('Ve_ven_depto', '=', 'V' . $sede)
                ->with('departamento')
                ->get();
        } else {
            $especialistas = Especialista::where('Ve_ven_depto', '=', 'V1')
                ->where('Ve_tipo_ven', '=', 'P')
                ->with('departamento')
                ->get();
        }

        $dia = array();
        for ($hora = $horaInicio; $hora <= $horaTermino; $hora->add(new DateInterval('PT15M'))) {
            $horaFin = strtotime("+15 minutes", strtotime($hora->format('H:i')));
            $datos = new stdClass;
            $datos->Hora = $hora->format('H:i') . ' - ' . date('H:i', $horaFin);
            $espe = array();
            foreach ($especialistas as $key => $especialista) {
                $dateStart = date('d-m-Y H:i:s', strtotime($fechaDia->format('Y-m-d') . " " . $hora->format('H:i:s')));
                $dateEnd = date('d-m-Y H:i:s', strtotime($fechaDia->format('Y-m-d') . " " . date('H:i:s', $horaFin)));

                $agenda = Agenda::where('Age_EmpCod', '=', $this->Emp)
                    ->where(function ($q) use ($sede) {
                        if ($sede) {
                            $q->where('Age_SedCod', $sede);
                        }
                    })
                    ->whereHas('especialista', function ($q) use ($especialista) {
                        $q->where('Age_EspCod', '=', $especialista["Ve_cod_ven"]);
                    })
                // ->with('especialista')
                    ->where('Age_Inicio', '<=', $dateStart)
                    ->where('Age_Fin', '>=', $dateEnd)
                    ->with('estado')
                    ->with('cliente')
                    ->with('lineasDetalle', 'lineasDetalle.articulo')
                    ->with(["lineasDetalle.articulo.tiempoEspecialista" => function ($q) use ($especialista) {
                        $q->where('Ser_EspCod', 'like', '%' . $especialista . '%');
                    }])
                    ->with('lineasDetalle.articulo.tiempoGeneral')
                    ->get();

                if (count($agenda) > 0) {
                    // dd("hola");
                    if (new DateTime(date('d-m-Y H:i')) >= new DateTime(date('d-m-Y H:i', strtotime($agenda[0]->Age_Inicio)))
                        && new DateTime(date('d-m-Y H:i')) <= new DateTime(date('d-m-Y H:i', strtotime($agenda[0]->Age_Fin)))) {
                        $agenda[0]->Age_Estado = 'E'; //EN CURSO
                        $agenda[0]->update();
                    }
                    $espe[$especialista["Ve_nombre_ven"]] = (object) $agenda[0];

                } else {
                    // $dia[$diaSemana[$fecha->format('w')] . ' ' . $fecha->format('d-m')] = 'Disponible';
                    $espe[$especialista["Ve_nombre_ven"]] = (object) array("Age_Inicio" => $dateStart, "Age_Fin" => $dateEnd, "Age_Estado" => 'A');
                }
                if ($key == count($especialistas) - 1) {
                    $datos->espe = $espe;
                    array_push($dia, $datos);
                }
            }
        }
        // dd($dia);
        // foreach ($semana as $key => $horas){
        //     foreach ($semana[$key] as $index => $datos){
        //         echo $datos.'<br>';
        //     }
        // }
        return $dia;
    }

    private function llenarMes($fechaDia, $sede = null)
    {

        $fechaInicio = DateTime::createFromFormat('d-m-Y', $fechaDia->modify('first day of this month')->format('d-m-Y'));

        $fechaTermino = DateTime::createFromFormat('d-m-Y', $fechaDia->modify('last day of this month')->format('d-m-Y'));

        if ($sede) {
            $especialistas = Especialista::where('Ve_ven_depto', '=', 'V' . $sede)
                ->with('departamento')
                ->get();
        } else {
            $especialistas = Especialista::where('Ve_ven_depto', '=', 'V1')
                ->where('Ve_tipo_ven', '=', 'P')
                ->with('departamento')
                ->get();
        }

        $mes = array();

        $semana = new stdClass;
        $dias = array();
        for ($fecha = DateTime::createFromFormat('d-m-Y', $fechaInicio->format('d-m-Y')); $fecha <= $fechaTermino; $fecha->add(new DateInterval('P1D'))) {
            $agenda = Agenda::where('Age_EmpCod', '=', $this->Emp)
                ->where(function ($q) use ($sede) {
                    if ($sede) {
                        $q->where('Age_SedCod', $sede);
                    }
                })
            // ->with('especialista')
                ->where('Age_Fecha', '=', $fecha->format('d-m-Y'))
                ->with('estado')
                ->with('cliente')
                ->with('lineasDetalle', 'lineasDetalle.articulo')
                ->get();

            $i = $fecha->format('N');
            switch ($i) {
                case 1:
                    $dias[$i] = (object) array("Dia" => "Lunes", "Fecha" => $fecha->format('j'));
                    break;
                case 2:
                    $dias[$i] = (object) array("Dia" => "Martes", "Fecha" => $fecha->format('j'));
                    break;
                case 3:
                    $dias[$i] = (object) array("Dia" => "Miércoles", "Fecha" => $fecha->format('j'));
                    break;
                case 4:
                    $dias[$i] = (object) array("Dia" => "Jueves", "Fecha" => $fecha->format('j'));
                    break;
                case 5:
                    $dias[$i] = (object) array("Dia" => "Viernes", "Fecha" => $fecha->format('j'));
                    break;
                case 6:
                    $dias[$i] = (object) array("Dia" => "Sábado", "Fecha" => $fecha->format('j'));
                    break;
                case 7;
                    $dias[$i] = (object) array("Dia" => "Domingo", "Fecha" => $fecha->format('j'));
                    $semana->semana = $dias;
                    array_push($mes, $semana);
                    $semana = new stdClass;
                    $dias = array();
                    break;
            }
        }
        // dd($mes);
        return $mes;
    }

    public function agendar(Request $request)
    {
        $codigoCliente = null;
        if ($request->cliente && $request->celular) {
            $cliente = new Cliente;
            $cliente->Cli_NomCli = strtoupper($request->cliente);
            $cliente->Cli_NumCel = intval($request->celular);
            $cliente->Cli_NumFij = intval($request->fijo);
            $cliente->save();
            $codigoCliente = $cliente->Cli_CodCli;
        } else {
            $codigoCliente = $request->Cli_CodCli;
        }

        $validator = Validator::make($request->all(), [
            'mHoraInicio' => [new ValidarDuracionHora($request->mHoraFin)],
            'mHoraFin' => [new ValidarHoraFinal($request->mHoraInicio, $request->mOpcionEspecialista)],
            'Cli_CodCli' => [new ValidarHoraCliente($request->mHoraInicio, $request->mHoraFin)],
        ]);

        if ($validator->fails()) {
            $notificacion = array(
                'mensaje' => implode(';', $validator->errors()->all()),
                'tipo' => 'error',
                'titulo' => 'Agenda',
            );

            return $notificacion;
        }

        $parametroAgenda = Parametro::where('Nombre', '=', 'Agenda')->first();

        $nuevaAgenda = $parametroAgenda->Valor;
        $parametroAgenda->Valor = $parametroAgenda->Valor + 1;
        $parametroAgenda->update();

        $agenda = new Agenda;
        $agenda->Age_EmpCod = $this->Emp;
        $agenda->Age_AgeCod = $nuevaAgenda;
        $agenda->Age_SedCod = $request->mSede;
        $agenda->Age_EspCod = $request->mOpcionEspecialista;
        $agenda->Age_Fecha = date('d-m-Y', strtotime($request->mfechaAgenda));
        $agenda->Age_Inicio = date('d-m-Y H:i:s', strtotime($request->mHoraInicio));
        $agenda->Age_Fin = date('d-m-Y H:i:s', strtotime($request->mHoraFin));
        $agenda->Age_CliCod = $codigoCliente;
        $agenda->Age_Estado = 'B';
        $agenda->save();

        foreach ($request->servicios as $key => $servicio) {
            $duracion = explode(':', $request->mDuracion[$key]);
            $ageDet = new AgeDet;
            $ageDet->Age_EmpCod = $this->Emp;
            $ageDet->Age_AgeCod = $nuevaAgenda;
            $ageDet->Age_SedCod = $request->mSede;
            $ageDet->Age_EspCod = $request->mOpcionEspecialista;
            $ageDet->Age_SerCod = $servicio;
            $ageDet->Age_DurHor = $duracion[0];
            $ageDet->Age_DurMin = $duracion[1];
            $ageDet->save();
        }
        // dd($request->all());

        $notificacion = array(
            'mensaje' => 'Hora agendada con éxito',
            'tipo' => 'success',
            'titulo' => 'Agenda',
        );
        return $notificacion;
    }

    public function editar(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mHoraFin' => [new ValidarHoraFinal($request->mHoraInicio)],
        ]);

        if ($validator->fails()) {
            $notificacion = array(
                'mensaje' => implode(';', $validator->errors()->all()),
                'tipo' => 'error',
                'titulo' => 'Agenda',
            );

            return $notificacion;
        }
        $codigoCliente = null;
        if ($request->cliente && $request->celular) {
            $cliente = new Cliente;
            $cliente->Cli_NomCli = strtoupper($request->cliente);
            $cliente->Cli_NumCel = $request->celular;
            $cliente->Cli_NumFij = $request->fijo;
            $cliente->save();
            $codigoCliente = $cliente->Cli_CodCli;
        } else {
            $codigoCliente = $request->Cli_CodCli;
        }

        $agenda = Agenda::where('Age_EmpCod', '=', $this->Emp)
            ->where('Age_AgeCod', '=', $request->Age_AgeCod)
            ->first();

        $agenda->Age_Fecha = date('d-m-Y', strtotime($request->mfechaAgenda));
        $agenda->Age_Inicio = date('d-m-Y H:i:s', strtotime($request->mHoraInicio));
        $agenda->Age_Fin = date('d-m-Y H:i:s', strtotime($request->mHoraFin));
        $agenda->Age_CliCod = $codigoCliente;
        $agenda->Age_Estado = $request->Age_Estado;
        $agenda->update();

        $ageDet = AgeDet::where('Age_EmpCod', '=', $this->Emp)
            ->where('Age_AgeCod', '=', $request->Age_AgeCod)
            ->where('Age_AgeCod', '=', $request->Age_SerCod)
            ->delete();
        foreach ($request->servicios as $key => $servicio) {
            $duracion = explode(':', $request->mDuracion[$key]);

            $ageDet = new AgeDet;
            $ageDet->Age_EmpCod = $this->Emp;
            $ageDet->Age_AgeCod = $request->Age_AgeCod;
            $ageDet->Age_SedCod = $request->mSede;
            $ageDet->Age_EspCod = $request->mOpcionEspecialista;
            $ageDet->Age_SerCod = $servicio;
            $ageDet->Age_DurHor = $duracion[0];
            $ageDet->Age_DurMin = $duracion[1];
            $ageDet->update();
        }
        // dd($request->all());
        $notificacion = array(
            'mensaje' => 'Hora modificada con éxito',
            'tipo' => 'success',
            'titulo' => 'Agenda',
        );
        //return view('inicio', compact('request'))->with($notificacion);
        return $notificacion;
    }

    public function confirmarAgenda(Request $request)
    {
        $agenda = Agenda::where('Age_EmpCod', '=', $this->Emp)
            ->where('Age_AgeCod', '=', $request->Age_AgeCod)
            ->first();
        $agenda->Age_Estado = 'C'; //confirmado
        $agenda->update();
        $notificacion = array(
            'mensaje' => 'Hora confirmada con éxito',
            'tipo' => 'success',
            'titulo' => 'Agenda',
        );
        return $notificacion;
    }

    public function eliminarAgenda(Request $request)
    {
        AgeDet::where('Age_EmpCod', '=', $this->Emp)
            ->where('Age_AgeCod', '=', $request->Age_AgeCod)
            ->delete();

        Agenda::where('Age_EmpCod', '=', $this->Emp)
            ->where('Age_AgeCod', '=', $request->Age_AgeCod)
            ->delete();

        $notificacion = array(
            'mensaje' => 'Hora eliminada con éxito',
            'tipo' => 'success',
            'titulo' => 'Agenda',
        );
        return $notificacion;
    }

    public function noAsiste(Request $request)
    {
        $agenda = Agenda::where('Age_EmpCod', '=', $this->Emp)
            ->where('Age_AgeCod', '=', $request->Age_AgeCod)
            ->first();

        $agenda->Age_Estado = 'F'; //confirmado
        $agenda->Age_Observacion = $request->Age_Observacion;
        $agenda->update();

        $notificacion = array(
            'mensaje' => 'Cliente no asiste, guardado con éxito',
            'tipo' => 'success',
            'titulo' => 'Agenda',
        );
        return $notificacion;
    }

    public function sinRespuesta(Request $request)
    {
        $agenda = Agenda::where('Age_EmpCod', '=', $this->Emp)
            ->where('Age_AgeCod', '=', $request->Age_AgeCod)
            ->first();

        $agenda->Age_Estado = 'D'; //sin respuesta
        $agenda->Age_Observacion = $request->Age_Observacion;
        $agenda->update();

        $notificacion = array(
            'mensaje' => 'Cliente sin respuesta, guardado con éxito',
            'tipo' => 'success',
            'titulo' => 'Agenda',
        );
        return $notificacion;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function buscarCliente(Request $request)
    {
        $term = $request->term;

        $query = Cliente::where('Cli_NomCli', 'like', '%' . $term . '%')
            ->take(5)
            ->get();

        return response()->json($query);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function buscarServicio(Request $request)
    {
        // DB::listen(function ($query) {

        //     if(strpos($query->sql, "GCSERVICIO") !== FALSE)
        //     {
        //         echo "<pre>".print_r($query->sql,1)."</pre>";
        //         echo "<pre>".print_r($query->bindings,1)."</pre>";
        //     }
        // //     $query->bindings
        // //     $query->time
        // });
        $term = $request->term;
        $especialista = $request->especialista;
        $respuesta = null;
        $query = Servicio::where('Art_nom_externo', 'like', '%' . $term . '%')
            ->where('Gc_fam_cod', '=', 1)
            ->with(["tiempoEspecialista" => function ($q) use ($especialista) {
                $q->where('Ser_EspCod', 'like', '%' . $especialista . '%');
            }])
            ->with('tiempoGeneral')
            ->take(5)
            ->get();
        
        foreach ($query as $key => $servicio) {
            $horDur = $servicio->tiempoEspecialista->Ser_HorDur ?? $servicio->tiempoGeneral->Dur_HorDur;
            $minDur = $servicio->tiempoEspecialista->Ser_MinDur ?? $servicio->tiempoGeneral->Dur_MinDur;
            if($horDur == 0 && $minDur == 0){
                
                unset($query[$key]);
            }
        }
        

        $respuesta = array_map(function ($item) {
            return array("label" => trim($item["Art_nom_externo"]),
                "id" => trim($item["Art_cod"]),
                "horDur" => $item["tiempoEspecialista"]["Ser_HorDur"] ?? $item["tiempoGeneral"]["Dur_HorDur"],
                "minDur" => $item["tiempoEspecialista"]['Ser_MinDur'] ?? $item["tiempoGeneral"]['Dur_MinDur']);
        }, $query->toArray());

        

        return response()->json($respuesta);
    }
}

