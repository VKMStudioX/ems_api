<?php

namespace App\Models;

use App\Models\Project;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Class User for emc users.
 * @package App\Models
 */
class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     * 'name' attribute only needed for mailer class
     *
     * @var array
     */
    protected $fillable = [
        'email',
        'first_name',
        'last_name',
        'password',
        'is_admin',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'pivot'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'is_admin' => 'boolean',
        'updated_at' => 'timestamp',
        'created_at' => 'timestamp',
    ];

    public function isAdmin(): bool
    {
        return $this->is_admin;
    }

    public function scopeAdmin($query)
    {
        return $query->where('is_admin', '1');
    }

    public function scopeNotAdmin($query)
    {
        return $query->where('is_admin', '0');
    }
    
    public function projects()
    {
        return $this->belongsToMany(Project::class);
    }
}
