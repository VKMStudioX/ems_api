<?php

namespace App\Models;

use App\Models\User;
use App\Models\Technology;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Project extends Model
{
    use HasFactory;

     /**
    * The table associated with the model.
    *
    * @var string
    */
   protected $table = 'projects';

   /**
    * Adding 'created_at' and 'updated_at' fields.
    *
    * @var bool
    */
   public $timestamps = false;

   /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
   protected $fillable = [
       'project_name',
       'project_info',
       'project_start',
       'project_end',
       'client_name',
   ];

   /**
    * The attributes that should be cast to native types.
    *
    * @var array
    */
   protected $casts = [
    'project_start' => 'date',
    'project_end' => 'date',
   ];

    public function technologies()
    {
        return $this->belongsToMany(Technology::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function scopeWithRelations($query)
    {
        return $query->with(['technologies', 'users']);
    }

    public function scopeGetOne($query, int $id)
    {
        return $query->where('id', $id)->first();
    }

    public function scopeGetOneByUser($query, int $projectId, int $userId)
    {
       return $query->with(['users'])->where('id', '=', $projectId)->first();
    }
}
