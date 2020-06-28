<?php

namespace App\Models;

use App\Empresa\Traits\EmpresaTrait;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use EmpresaTrait;

    protected $fillable = ['nome', 'url', 'descricao'];

    public function produtos()
    {
        return $this->belongsToMany(Produto::class); //uma categoria possui varios produtos
    }

   /*
     //sobrepondo metodo
   /// depois foi retirado e criado uma traint
    protected static function  boot()
    {
        parent::boot(); // TODO: Change the autogenerated stub
        static::observe(EmpresaObserver::class);
    }

*/
}