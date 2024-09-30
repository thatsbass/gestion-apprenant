<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Facade\RoleFacade as checkRole;
use App\Models\Role;



class User extends Authenticatable
{
    use  HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'nom',
        'prenom',
        'telephone',
        'adresse',
        'fonction',
        'email',
        'password',
        'role_id',
        'statut',
        'photo',

    ];
    protected $hidden = [
        'password',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'password' => 'hashed',
    ];


    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function isAdmin(): bool
    {
        return $this->role_id === checkRole::getId('Admin');
    }
    public function isManager(): bool
    {
        return $this->role_id === checkRole::getId('Manager');
    }   
    public function isCME(): bool{
        return $this->role_id === checkRole::getId('CME');
    }
    public function isCoach(): bool{
        return $this->role_id === checkRole::getId('Coach');
    }

    public function isApprenant(string $role): bool{
        return $this->role_id === checkRole::getId('Apprenant');
    }
}