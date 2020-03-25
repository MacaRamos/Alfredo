<?php

namespace App\Http\Controllers\Servicio;

use App\Http\Controllers\Controller;
use App\Http\Requests\ValidacionServicio;
use App\Models\Especialista\Especialista;
use App\Models\Servicio\Clase;
use App\Models\Servicio\DuracionEspecialista;
use App\Models\Servicio\Familia;
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
        ->with('duracion')
        ->get();
        // with('servicio')
            // ->with('especialista')
        // ->with(['especialista' => function($q){
        //     $q->orderBy('Ve_nombre_ven');
        // }])
            
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
        dd($request->all());
        $servicio = new Servicio;
        $servicio->Mb_Epr_cod = $this->Emp;
        $servicio->Art_cod = $request->Art_cod;
        $servicio->Art_cod_largo = strtoupper($request->Art_cod);
        $servicio->Art_nom_externo = strtoupper($request->Art_nom_externo);
        $servicio->Art_nom_interno = strtoupper($request->Art_nom_externo);
        $servicio->Gc_fam_cod = $request->Gc_fam_cod;
        $servicio->Gc_cla_cod = $request->Gc_cla_cod;
        $servicio->Gc_mar_cod = 'SM';
        $servicio->Art_ind_stock = 'N';
        $servicio->Art_fec_cre = date('d-m-Y');
        $servicio->art_flag_w = '';
        $servicio->Art_proveedor = '';
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
        $servicio->save();

        $notificacion = array(
            'mensaje' => 'servicio creado con éxito',
            'tipo' => 'success',
            'titulo' => 'servicios',
        );
        return redirect('servicio')->with($notificacion);
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
    public function editar($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function actualizar(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function eliminar($id)
    {
        //
    }
}
