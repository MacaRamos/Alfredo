<?php

namespace App\Models\Cliente;

use Awobaz\Compoships\Compoships;
use Illuminate\Database\Eloquent\Model;
use LaravelTreats\Model\Traits\HasCompositePrimaryKey;

class Cliente extends Model
{
    //Cliente
    use HasCompositePrimaryKey;
    use Compoships;
    protected $dateFormat = 'd-m-Y H:i:s';
    protected $table = "CLIENTES";
    protected $guarded = ['Cli_CodCli', 'Cli_NomCli'];
    protected $primaryKey = ['Cli_CodCli'];
    public $timestamps = false;
}
