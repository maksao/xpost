<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    const OBJ_CODE = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'type',
        'is_admin',
        'is_active',
        'comment'
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

    protected $type_names = [
        'E' => 'Сотрудник',
        'C' => 'Контрагент'
    ];

    /*
     *
     *  Связи
     *
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
    /* Связи (х) */


    /*
     *
     *  Прочее
     *
     */

    public function isAdmin()
    {
        return !! $this->is_admin;
    }
    public function isEmployee()
    {
        return $this->type === 'E';
    }
    public function isContractor()
    {
        return $this->type === 'C';
    }

    public function getTypeNameAttribute()
    {
        return $this->type_names[$this->type];
    }
}
