<?php

namespace App\Http\Controllers\Cliente;

use App\Http\Controllers\Controller;
use App\Http\Requests\ValidacionCliente;
use App\Models\Cliente\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $Cli_NomCli = '')
    {
        $clientes = Cliente::orderBy('Cli_NomCli')
            ->where(function ($q) use($Cli_NomCli){
                if($Cli_NomCli){
                    $q->where('Cli_NomCli', 'like', "%$Cli_NomCli%");
                }
            })
            ->paginate(15);
            if($request->ajax()){
                return view('cliente.table', compact('clientes'));
            }else{
                return view('cliente.index', compact('clientes'));
            }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function crear()
    {
        return view('cliente.crear');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function guardar(ValidacionCliente $request)
    {
        $cliente = new Cliente;
        $cliente->Cli_NomCli = strtoupper($request->Cli_NomCli);
        $cliente->Cli_NumCel = intval($request->Cli_NumCel);
        $cliente->Cli_NumFij = $request->Cli_NumFij;
        $cliente->save();

        $notificacion = array(
            'mensaje' => 'Cliente creado con éxito',
            'tipo' => 'success',
            'titulo' => 'Clientes',
        );
        
        return redirect('cliente')->with($notificacion);
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
    public function editar($Cli_CodCli)
    {
        $cliente = Cliente::where('Cli_CodCli', '=', $Cli_CodCli)
            ->first();
        return view('cliente.editar', compact('cliente'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function actualizar(ValidacionCliente $request, $Cli_CodCli)
    {
        // dd($request->all());
        $cliente = Cliente::where('Cli_CodCli', '=', $Cli_CodCli)
            ->first();

        $cliente->Cli_NomCli = strtoupper($request->Cli_NomCli);
        $cliente->Cli_NumCel = intval($request->Cli_NumCel);
        $cliente->Cli_NumFij = $request->Cli_NumFij;
        $cliente->update();

        $notificacion = array(
            'mensaje' => 'Cliente editado con éxito',
            'tipo' => 'success',
            'titulo' => 'Clientes',
        );
        return redirect('cliente')->with($notificacion);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function eliminar(Request $request, $Cli_CodCli)
    {
        $cliente = Cliente::where('Cli_CodCli', '=', $Cli_CodCli)
            ->with('agendas')
            ->first();
        if ($request->ajax()) {
            if (count($cliente->agendas) > 0) {
                return response()->json(['mensaje' => 'El cliente no puedo ser eliminado, tiene reservas', 'tipo' => 'error']);
            } else {
                if ($cliente->delete()) {
                    return response()->json(['mensaje' => 'El registro fue eliminado correctamente', 'tipo' => 'success']);
                } else {
                    return response()->json(['mensaje' => 'El registro no pudo ser eliminado, hay recursos usandolo', 'tipo' => 'error']);
                }
            }
        } else {
            abort(404);
        }
    }
}
