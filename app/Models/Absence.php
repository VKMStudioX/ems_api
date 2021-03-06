<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\EventsDefaultsForBg;
use App\Models\User;

class Absence extends Model
{
    use HasFactory;

     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'absences';

    /**
     * Adding 'created_at' and 'updated_at' fields.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'start',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'start' => 'datetime'
        
    ];

    public function defaults() {
        return $this->hasOne(EventsDefaultsForBg::class, 'type', 'type');
    }

    public function users() {
        return $this->hasMany(User::class, 'id', 'user_id');
    }

}