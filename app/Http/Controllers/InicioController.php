<?php

namespace App\Http\Controllers;

use App\Models\Agenda\AgeDet;
use App\Models\Agenda\Agenda;
use App\Models\Agenda\Parametro;
use App\Models\Cliente\Cliente;
use App\Models\Especialista\Especialista;
use App\Models\Sede\Sede;
use App\Models\Servicio\Servicio;
use DateInterval;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

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
            switch ($request->accion) {
                case 'siguiente':
                    $fechaTemporal = new DateTime(date('d-m-Y', strtotime($request->fechaTermino)));
                    $fechaInicio = new DateTime(date('d-m-Y', strtotime($request->fechaTermino)));
                    $fechaInicio = $fechaInicio->add(new DateInterval('P1D'));
                    $fechaTermino = $fechaTemporal->add(new DateInterval('P7D'));
                    break;
                case 'anterior':
                    $fechaTemporal = new DateTime(date('d-m-Y', strtotime($request->fechaInicio)));
                    $fechaTermino = new DateTime(date('d-m-Y', strtotime($request->fechaInicio)));
                    $fechaTermino = $fechaTermino->sub(new DateInterval('P1D'));
                    $fechaInicio = $fechaTemporal->sub(new DateInterval('P7D'));
                    break;
                case 'agendar':
                    $notificacion = $this->agendar($request);                    
                    $fechaInicio = new DateTime(date('d-m-Y', strtotime($request->fechaInicio)));
                    $fechaTermino = new DateTime(date('d-m-Y', strtotime($request->fechaTermino)));
                    break;
                case 'confirmar':
                    $notificacion = $this->confirmarAgenda($request);                    
                    $fechaInicio = new DateTime(date('d-m-Y', strtotime($request->fechaInicio)));
                    $fechaTermino = new DateTime(date('d-m-Y', strtotime($request->fechaTermino)));
                    break;
                default:
                    $fechaActual = new DateTime(date('d-m-Y'));
                    $fechaInicio = new DateTime(date('d-m-Y'));
                    $fechaTermino = $fechaActual->add(new DateInterval('P6D'));
                    break;
            }

            if (!$request->sede) {
                $sedes = Sede::get();
                $especialistas = Especialista::where('Ve_ven_depto', '=', 'V1')
                    ->with('departamento')
                    ->get();
            } else {
                $sedes = Sede::get();
                $especialistas = Especialista::where('Ve_ven_depto', '=', 'V' . $request->sede)
                    ->with('departamento')
                    ->get();
            }

        

            $semana = $this->llenarSemana($fechaInicio, $fechaTermino, $request->sede, $request->especialista);

            return view('inicio', compact('sedes', 'especialistas', 'fechaInicio', 'fechaTermino', 'semana', 'request'))->with($notificacion);
        } else {
            return view('seguridad.index');
        }
    }

    private function llenarSemana($fechaInicio, $fechaTermino, $sede = '', $especialista = '')
    {

        $horaInicio = DateTime::createFromFormat('H:i', '09:00');
        $horaTermino = DateTime::createFromFormat('H:i', '18:45');

        $semana = array();
        for ($hora = $horaInicio; $hora <= $horaTermino; $hora->add(new DateInterval('PT15M'))) {
            $horaFin = strtotime("+15 minutes", strtotime($hora->format('H:i')));
            $dia = array();
            $dia["Hora"] = $hora->format('H:i') . ' - ' . date('H:i', $horaFin);

            for ($fecha = new DateTime(date('d-m-Y', strtotime($fechaInicio->format('d-m-Y'))));
                $fecha <= $fechaTermino;
                $fecha->add(new DateInterval('P1D'))) {
                //armo las horas con la fecha del ciclo $fecha
                $dateStart = date('d-m-Y H:i:s', strtotime($fecha->format('Y-m-d') . " " . $hora->format('H:i:s')));
                $dateEnd = date('d-m-Y H:i:s', strtotime($fecha->format('Y-m-d') . " " . date('H:i:s', $horaFin)));
                $dia["HoraInicio"] = $dateStart;
                $dia["HoraFin"] = $dateEnd;

                $agenda = Agenda::where('Age_EmpCod', '=', $this->Emp)
                    ->where('Age_SedCod', '=', $sede)
                    ->where(function ($q) use ($especialista) {
                        if ($especialista) {
                            $q->where('Age_EspCod', $especialista);
                        }
                    })
                    ->where('Age_Inicio', '<=', $dateStart)
                    ->where('Age_Fin', '>=', $dateEnd)
                    ->first();
                if ($agenda) {
                    // $dia[$diaSemana[$fecha->format('w')] . ' ' . $fecha->format('d-m')] = 'Ocupado';
                    $dia[$fecha->format('d-m-Y H:i:s')] = $agenda->Age_Estado;
                    $dia["Age_AgeCod"] = $agenda->Age_AgeCod;
                } else {
                    // $dia[$diaSemana[$fecha->format('w')] . ' ' . $fecha->format('d-m')] = 'Disponible';
                    $dia[$fecha->format('d-m-Y H:i:s')] = 'A';
                }
                if ($fecha == $fechaTermino) {
                    array_push($semana, $dia);
                }
            }
        }
        return $semana;
    }

    public function agendar(Request $request)
    {
        $codigoCliente = null;
        if ($request->cliente && $request->celular) {
            $cliente = new Cliente;
            $cliente->Cli_NomCli = $request->cliente;
            $cliente->Cli_NumCel = $request->celular;
            $cliente->Cli_NumFij = $request->fijo;
            $cliente->save();
            $codigoCliente = $cliente->Cli_CodCli;
        }else{
            $codigoCliente = $request->Age_CliCod;
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
        $agenda->Age_Inicio = date('d-m-Y H:i', strtotime($agenda->Age_Fecha . " " . $request->mHoraInicio));
        $agenda->Age_Fin = date('d-m-Y H:i', strtotime($agenda->Age_Fecha . " " . $request->mHoraFin));
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
            ->with(["tiempoEspecialista" => function ($q) use ($especialista) {
                $q->where('Ser_EspCod', 'like', '%' . $especialista . '%');
            }])
            ->with('tiempoGeneral')
        //  ->whereHas('tiempoEspecialista', function($q) use ($especialista){
        //     $q->where('Ser_EspCod', '=', $especialista);
        //  })
            ->take(5)
            ->get();

        $respuesta = array_map(function ($item) {
            return array("label" => trim($item["Art_nom_externo"]),
                "id" => trim($item["Art_cod"]),
                "horDur" => $item["tiempoEspecialista"]["Ser_HorDur"] ?? $item["tiempoGeneral"]["Dur_HorDur"],
                "minDur" => $item["tiempoEspecialista"]['Ser_MinDur'] ?? $item["tiempoGeneral"]['Dur_MinDur']);
        }, $query->toArray());

        return response()->json($respuesta);
    }
}
