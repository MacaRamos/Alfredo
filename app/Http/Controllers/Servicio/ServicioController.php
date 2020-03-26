<?php

namespace App\Http\Controllers\Servicio;

use App\Http\Controllers\Controller;
use App\Http\Requests\ValidacionServicio;
use App\Models\Especialista\Especialista;
use App\Models\Servicio\Clase;
use App\Models\Servicio\Duracion;
use App\Models\Servicio\DuracionEspecialista;
use App\Models\Servicio\Familia;
use App\Models\Servicio\Precio;
use App\Models\Servicio\Servicio;
use Facade\FlareClient\Http\Response;
use Illuminate\Http\Request;

class ServicioController extends Controller
{
    private $Emp = 'ALF';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $Art_nom_externo = '', $productosCheckBox = 'false')
    {
        $servicios = Servicio::orderBy('Art_nom_externo')
            ->where(function ($q) use ($Art_nom_externo) {
                if ($Art_nom_externo) {
                    $q->where('Art_nom_externo', 'like', "%$Art_nom_externo%");
                }
            })
            ->where(function ($q) use ($productosCheckBox) {
                if ($productosCheckBox == "false") {
                    $q->where('Gc_fam_cod', '=', 1);
                } else {
                    $q->whereIn('Gc_fam_cod', [1, 2]);
                }
            })
            ->with('tiempoGeneral')
            ->with('tiempoEspecialista')
            ->with('clase')
            ->with('familia')
            ->with('precio')
            ->paginate(15);
        if ($request->ajax()) {
            return view('servicio.table', compact('servicios'));
        } else {
            return view('servicio.index', compact('servicios', 'Art_nom_externo', 'productosCheckBox'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function crear()
    {
        $familias = Familia::orderBy('Gc_fam_cod')->get();
        $clases = Clase::orderBy('Gc_cla_desc')
            ->where('Gc_fam_cod', '=', 1)
            ->get();
        $duracionEspecialistas = Especialista::where('Ve_tipo_ven', '=', 'P')
            ->get();
        //dd($duracionEspecialistas);
        return view('servicio.crear', compact('clases', 'familias', 'duracionEspecialistas'));
    }

    public function selectDinamico($Gc_fam_cod)
    {
        $clases = Clase::orderBy('Gc_cla_desc')
            ->where('Gc_fam_cod', '=', $Gc_fam_cod)
            ->get();
        return response()->json($clases);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function guardar(ValidacionServicio $request)
    {
        $servicio = new Servicio;
        $servicio->Mb_Epr_cod = $this->Emp;
        $servicio->Art_cod = strtoupper($request->Art_cod);
        $servicio = $this->llenarServicio($servicio, $request);
        $servicio->save();

        if ($request->Gc_fam_cod == 1) {
            $duracionGeneral = new Duracion;
            $duracionGeneral->Dur_EmpCod = $this->Emp;
            $duracionGeneral->Dur_SerCod = strtoupper($request->Art_cod);
            $duracionGeneral = $this->llenarDuracionGeneral($duracionGeneral, $request->duracion);
            $duracionGeneral->save();

            $this->llenarDuracionEspecialistas(strtoupper($request->Art_cod), $request->especialistas, $request->duraciones);
        }
        $precio = new Precio;
        $precio->Mb_Epr_cod = $this->Emp;
        $precio->Ve_lista_precio = 1;
        $precio->Art_cod = strtoupper($request->Art_cod);
        $precio->ve_lis_desde = 1;
        $this->llenarPrecio($precio, $request->precio);
        $precio->save();

        $notificacion = array(
            'mensaje' => 'Servicio creado con éxito',
            'tipo' => 'success',
            'titulo' => 'Servicios',
        );
        return redirect('servicio')->with($notificacion);
    }

    private function llenarDuracionGeneral($duracionGeneral,$duracion)
    {
        $strDuracion = explode(':', $duracion);
        $hora = intval($strDuracion[0]);
        $minutos = intval($strDuracion[1]);

        $duracionGeneral->Dur_HorDur = $hora;
        $duracionGeneral->Dur_MinDur = $minutos;
        return $duracionGeneral;
    }

    private function llenarDuracionEspecialistas($Ser_SerCod, $especialistas, $duraciones)
    {

        foreach ($especialistas as $key => $especialista) {
            $strDuracion = explode(':', $duraciones[$key]);
            $hora = intval($strDuracion[0]);
            $minutos = intval($strDuracion[1]);
            if ($hora != 0 || $minutos != 0) {
                $duracionEspecialista = DuracionEspecialista::where('Ser_EmpCod', '=', $this->Emp)
                    ->where('Ser_EspCod', '=', $especialista)
                    ->where('Ser_SerCod', '=', $Ser_SerCod)
                    ->first();
                if (isset($duracionEspecialista)) {
                    $duracionEspecialista->Ser_EspCod = $especialista;
                    $duracionEspecialista->Ser_HorDur = $hora;
                    $duracionEspecialista->Ser_MinDur = $minutos;
                    $duracionEspecialista->update();
                } else {
                    $duracionEspecialista = new DuracionEspecialista;
                    $duracionEspecialista->Ser_EmpCod = $this->Emp;
                    $duracionEspecialista->Ser_SerCod = $Ser_SerCod;
                    $duracionEspecialista->Ser_EspCod = $especialista;
                    $duracionEspecialista->Ser_HorDur = $hora;
                    $duracionEspecialista->Ser_MinDur = $minutos;
                    $duracionEspecialista->save();
                }
            }
        }
    }

    private function llenarPrecio($precio, $Ve_lis_pesos)
    {
        $pesosSinSigno = explode('$ ', $Ve_lis_pesos);
        $pesosSinPunto = explode('.', $pesosSinSigno[1]);
        $precioFinal = floatval(implode($pesosSinPunto));

        $precio->Ve_lis_pesos = $precioFinal;
        $precio->ve_inc_uni = 'UN';
        return $precio;

    }

    private function llenarServicio($servicio, $request)
    {
        $servicio->Art_cod_largo = strtoupper($request->Art_cod);
        $servicio->Art_nom_externo = strtoupper($request->Art_nom_externo);
        $servicio->Art_nom_interno = strtoupper($request->Art_nom_externo);
        $servicio->Gc_fam_cod = $request->Gc_fam_cod;
        $servicio->Gc_cla_cod = $request->Gc_cla_cod;
        $servicio->Gc_mar_cod = 'SM';
        $servicio->Art_ind_stock = 'N';
        $servicio->Art_fec_cre = date('d-m-Y');
        $servicio->art_flag_w = '';
        if ($request->Gc_fam_cod == 1) {
            $servicio->Art_proveedor = 0;
        } else {
            $servicio->Art_proveedor = '';
        }
        $servicio->Art_um_compra = '';
        $servicio->Art_um_venta = '';
        $servicio->Art_um_exi = '';
        $servicio->Art_origen = '';
        $servicio->Art_cant_caja = 0;
        $servicio->Art_niv_costo = 0;
        $servicio->art_pventa = 0;
        $servicio->art_flag_inv = 0;
        $servicio->art_receta = '';
        $servicio->art_pact1 = '';
        $servicio->art_pact2 = '';
        $servicio->art_pact3 = '';
        $servicio->art_hor_cre = '';
        $servicio->art_use_cre = '';
        $servicio->art_flag_cic = '';
        $servicio->Art_abc = '';
        $servicio->Art_cta_contable = '';
        $servicio->Art_valor = 0;
        $servicio->Art_prec_medio = 0;
        $servicio->Art_bod = 0;
        $servicio->Art_ind_insu = '';
        $servicio->Art_ind_repu = '';
        $servicio->Art_ind_acce = '';
        $servicio->Art_ubi = '';
        $servicio->Art_ind_serie = '';
        return $servicio;
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editar($Art_cod)
    {
        $servicio = Servicio::where('Art_cod', '=', $Art_cod)
            ->with('tiempoGeneral')
            ->with('tiempoEspecialista')
            ->with('precio')
            ->first();
        $familias = Familia::orderBy('Gc_fam_cod')->get();
        $clases = Clase::orderBy('Gc_cla_desc')
            ->where('Gc_fam_cod', '=', $servicio->Gc_fam_cod)
            ->get();

        $duracionEspecialistas = Especialista::where('Ve_tipo_ven', '=', 'P')
            ->with(["duracion" => function ($q) use ($Art_cod) {
                $q->where('Ser_SerCod', '=', $Art_cod);
            }])
            ->get();

        return view('servicio.editar', compact('servicio', 'clases', 'familias', 'duracionEspecialistas'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function actualizar(ValidacionServicio $request, $Art_cod)
    {
        // dd($request->all());
        $servicio = Servicio::where('Art_cod', '=', $Art_cod)->first();
        $servicio = $this->llenarServicio($servicio, $request);
        $servicio->update();

        if ($servicio->Gc_fam_cod == 1) {
            $duracionGeneral = Duracion::where('Dur_EmpCod', '=', $this->Emp)
                ->where('Dur_SerCod', '=', $Art_cod)
                ->first();
            $duracionGeneral = $this->llenarDuracionGeneral($duracionGeneral, $request->duracion);
            $duracionGeneral->update();

            $this->llenarDuracionEspecialistas(strtoupper($request->Art_cod), $request->especialistas, $request->duraciones);
        }
        $precio = Precio::where('Mb_Epr_cod', '=', $this->Emp)
            ->where('Ve_lista_precio', '=', 1)
            ->where('Art_cod', '=', $Art_cod)
            ->where('ve_lis_desde', '=', 1)
            ->first();
        $this->llenarPrecio($precio, $request->precio);
        $precio->update();

        $notificacion = array(
            'mensaje' => 'Servicio editado con éxito',
            'tipo' => 'success',
            'titulo' => 'Servicios',
        );
        return redirect('servicio')->with($notificacion);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function eliminar(Request $request, $Art_cod)
    {
        Duracion::where('Dur_EmpCod', '=', $this->Emp)
            ->where('Dur_SerCod', '=', $Art_cod)
            ->delete();
        DuracionEspecialista::where('Ser_EmpCod', '=', $this->Emp)
            ->where('Ser_SerCod', '=', $Art_cod)
            ->delete();
        Precio::where('Mb_Epr_cod', '=', $this->Emp)
            ->where('Ve_lista_precio', '=', 1)
            ->where('Art_cod', '=', $Art_cod)
            ->where('ve_lis_desde', '=', 1)
            ->delete();
        $servicio = Servicio::where('Art_cod', '=', $Art_cod)->first();
        if ($request->ajax()) {
            if ($servicio->delete()) {
                return response()->json(['mensaje' => 'El registro fue eliminado correctamente', 'tipo' => 'success']);
            } else {
                return response()->json(['mensaje' => 'El registro no pudo ser eliminado, hay recursos usandolo', 'tipo' => 'error']);
            }
        } else {
            abort(404);
        }
    }
}
