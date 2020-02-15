<?php

namespace App\Http\Controllers;

use App\Models\SIC\ADSICTRX;
use DateTime;
use Illuminate\Support\Facades\DB;

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
            $primerDia = new DateTime();
            $primerDia = $primerDia->modify('first day of this month');
            $hoy = new DateTime();
            $sics = ADSICTRX::where('Mb_Epr_cod', '=', $this->Emp)
                               ->where('SicTip', '=', 2)
                               ->where('SicFecemi','>=', $primerDia)
                               ->where('SicFecemi', '<=', $hoy)
                               ->with(["lineasSIC" => function($q){
                                $q->where('SicCanDesp', '>', 0);
                                }])
                                ->orderBy('SicFecemi')
                                ->get();
                  
            return view('inicio', compact('sics'));
        }else{
           return view('seguridad.index');
        }
    }
}
