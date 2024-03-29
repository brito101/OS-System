<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Shetabit\Visitor\Traits\Visitor;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, Visitor, SoftDeletes;

    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'photo',
        'telephone',
        'cell',
        'type',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /** Relationships */
    public function collaborators()
    {
        return $this->hasMany(Collaborator::class);
    }

    public function managers()
    {
        return $this->hasMany(Manager::class);
    }

    public function financiers()
    {
        return $this->hasMany(Financier::class);
    }

    public function routeNotificationForWhatsApp()
    {
        $number = '+55' . preg_replace('/\D/', '', $this->cell);
        return $number;
    }
}
