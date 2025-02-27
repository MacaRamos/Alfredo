<?php

namespace App\Models\Cliente;

use App\Models\Agenda\Agenda;
use Awobaz\Compoships\Compoships;
use Illuminate\Database\Eloquent\Model;
use LaravelTreats\Model\Traits\HasCompositePrimaryKey;

class Cliente extends Model
{
    //Cliente

    protected $dateFormat = 'd-m-Y H:i:s';
    protected $table = "CLIENTES";
    protected $fillable = ['Cli_NomCli', 'Cli_NumCel', 'Cli_NumFij'];
    protected $guarded = ['Cli_CodCli'];
    protected $primaryKey = 'Cli_CodCli';
    public $timestamps = false;

    public function agendas(){
        return $this->hasMany(Agenda::class, 'Age_CliCod', 'Cli_CodCli');
    }
}
