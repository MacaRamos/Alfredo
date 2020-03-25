<?php

namespace App\Http\Controllers\Especialista;

use App\Http\Controllers\Controller;
use App\Http\Requests\ValidacionEspecialista;
use App\Models\Especialista\Especialista;
use App\Models\Sede\Sede;
use Illuminate\Http\Request;

class EspecialistaController extends Controller
{
    private $Emp = 'ALF';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $Ve_nombre_ven = '')
    {
        $especialistas = Especialista::orderBy('Ve_nombre_ven')
            ->where(function ($q) use ($Ve_nombre_ven) {
                if($Ve_nombre_ven){
                    $q->where('Ve_nombre_ven', 'like', "%$Ve_nombre_ven%");
                }
            })
            ->paginate(15);
        if($request->ajax()){
            return view('especialista.table', compact('especialistas'));
        }else{
            return view('especialista.index', compact('especialistas'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function crear()
    {
        $sedes = Sede::get();
        return view('especialista.crear', compact('sedes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function guardar(ValidacionEspecialista $request)
    {
        $departamento = substr($request->Ve_ven_depto, 1, 1);
        $sede = Sede::where('Mb_Sedecod', '=', $departamento)->first();
        $especialista = new Especialista;
        $especialista->Mb_Epr_cod = $this->Emp;
        $especialista->Ve_cod_ven = strtoupper(explode(" ", $request->nombre)[0] . '.' . explode(" ", $request->apellido)[0]);
        $especialista->Ve_nombre_ven = strtoupper($request->Ve_nombre_ven);
        $especialista->Ve_rut_ven = $request->Ve_rut_ven;
        $especialista->Ve_ven_dv = $request->Ve_ven_dv;
        $especialista->Ve_ven_depto = $request->Ve_ven_depto;
        $especialista->Ve_ven_dir = $sede->Mb_Sededir;
        $especialista->Ve_tipo_ven = $request->Ve_tipo_ven;
        $especialista->save();

        $notificacion = array(
            'mensaje' => 'Especialista creado con éxito',
            'tipo' => 'success',
            'titulo' => 'Especialistas',
        );
        return redirect('especialista')->with($notificacion);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function mostrar($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editar($Ve_cod_ven)
    {
        $especialista = Especialista::where('Mb_Epr_cod', '=', $this->Emp)
            ->where('Ve_cod_ven', '=', $Ve_cod_ven)
            ->first();
        $sedes = Sede::get();
        return view('especialista.editar', compact('especialista', 'sedes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function actualizar(ValidacionEspecialista $request, $Ve_cod_ven)
    {
        $departamento = substr($request->Ve_ven_depto, 1, 1);
        $sede = Sede::where('Mb_Sedecod', '=', $departamento)->first();
        $especialista = Especialista::where('Mb_Epr_cod', '=', $this->Emp)
            ->where('Ve_cod_ven', '=', $Ve_cod_ven)
            ->first();
        $especialista->Ve_nombre_ven = strtoupper($request->Ve_nombre_ven);
        $especialista->Ve_rut_ven = $request->Ve_rut_ven;
        $especialista->Ve_ven_dv = $request->Ve_ven_dv;
        $especialista->Ve_ven_depto = $request->Ve_ven_depto;
        $especialista->Ve_ven_dir = $sede->Mb_Sededir;
        $especialista->Ve_tipo_ven = $request->Ve_tipo_ven;
        $especialista->update();

        $notificacion = array(
            'mensaje' => 'Especialista editado con éxito',
            'tipo' => 'success',
            'titulo' => 'Especialistas',
        );
        return redirect('especialista')->with($notificacion);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function eliminar(Request $request, $Ve_cod_ven)
    {
        $especialista = Especialista::where('Mb_Epr_cod', '=', $this->Emp)
            ->where('Ve_cod_ven', '=', $Ve_cod_ven)
            ->first();
        if ($request->ajax()) {
            if ($especialista->delete()) {
                return response()->json(['mensaje' => 'ok']);
            } else {
                return response()->json(['mensaje' => 'ng']);
            }
        } else {
            abort(404);
        }
    }
}
