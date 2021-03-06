<?php

namespace App\Models;

use App\Models\Traits\UserACLTrait;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Builder;

class User extends Authenticatable
{
    use Notifiable,UserACLTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','empresa_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function empresa()
    {
        return $this->belongsTo(Empresa::class); // Usuario pertence a uma empresa
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class); //Usuario possui muitos cargos
    }

    //criando um filtro via escopo local
    public function scopeEmpresaUsuario(Builder $query)
    {
        return $query->where('empresa_id', auth()->user()->empresa_id);
    }

     public function rolesDisponiveis($filter = null)
    {
        $roles = Role::whereNotIn('roles.id', function($query) {
                     $query->select('role_user.role_id');
                     $query->from('role_user');
                     $query->whereRaw("role_user.user_id={$this->id}");
        })
            ->where(function ($queryFilter) use ($filter) {
                if ($filter)
                    $queryFilter->where('roles.nome', 'LIKE', "%{$filter}%");
            })
            ->paginate();

        return $roles;
    }



}
