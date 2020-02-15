<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $dateFormat = 'Y-d-m H:i:s.v';
    protected $table = "Menu";
    protected $fillable = ['Men_nombre', 'Men_url', 'Men_icono'];
    protected $guarded = ['Men_id'];
    protected $primaryKey = 'Men_id';

    public function roles()
    {
        return $this->belongsToMany(Rol::class, 'MenuRol', 'Men_id', 'Rol_codigo');
    }
    public function getHijos($padres, $line)
    {
        $children = [];
        foreach ($padres as $line1) {
            if ($line['Men_id'] == $line1['Men_codigo']) {
                $children = array_merge($children, [array_merge($line1, ['submenu' => $this->getHijos($padres, $line1)])]);
            }
        }
        return $children;
    }
    public function getPadres($front)
    {
        if ($front) {
            return $this->whereHas('roles', function ($query) {
                $query->where('Rol.Rol_codigo', session()->get('Rol_codigo'));
            })->orderby('Men_codigo')
                ->orderby('Men_orden')
                ->get()
                ->toArray();
        } else {
            return $this->orderby('Men_codigo')
                ->orderby('Men_orden')
                ->get()
                ->toArray();
        }
    }
    public static function getMenu($front = false)
    {
        $menus = new Menu();
        $padres = $menus->getPadres($front);
        $menuAll = [];
        foreach ($padres as $line) {
            if ($line['Men_codigo'] != 0)
                break;
            $item = [array_merge($line, ['submenu' => $menus->getHijos($padres, $line)])];
            $menuAll = array_merge($menuAll, $item);
        }
        return $menuAll;
    }
    public function guardarOrden($menu)
    {
        $menus = json_decode($menu);

        foreach ($menus as $var => $value) {
            $this->where('Men_id', $value->id)->update(['Men_codigo' => 0, 'Men_orden' => $var + 1]);
            if (!empty($value->children)) {
                foreach ($value->children as $key => $vchild) {
                    
                    $update_id = $vchild->id;
                    $parent_id = $value->id;
                    $this->where('Men_id', $update_id)->update(['Men_codigo' => $parent_id, 'Men_orden' => $key + 1]);
                    if (!empty($vchild->children)) {
                        foreach ($vchild->children as $key => $vchild1) {
                            $update_id = $vchild1->id;
                            $parent_id = $vchild->id;
                            $this->where('Men_id', $update_id)->update(['Men_codigo' => $parent_id, 'Men_orden' => $key + 1]);
                            if (!empty($vchild1->children)) {
                                foreach ($vchild1->children as $key => $vchild2) {
                                    $update_id = $vchild2->id;
                                    $parent_id = $vchild1->id;
                                    $this->where('Men_id', $update_id)->update(['Men_codigo' => $parent_id, 'Men_orden' => $key + 1]);
                                    if (!empty($vchild2->children)) {
                                        foreach ($vchild2->children as $key => $vchild3) {
                                            $update_id = $vchild3->id;
                                            $parent_id = $vchild2->id;
                                            $this->where('Men_id', $update_id)->update(['Men_codigo' => $parent_id, 'Men_orden' => $key + 1]);
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
}