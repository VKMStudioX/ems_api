<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ProjectTechnology;

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
       'project_technology_id',
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
   protected $casts = [];

//    public function project() {
//        return $this->hasMany(Project::class, 'id', 'project_id');
//    }

//    public function type() {
//     return $this->hasMany(Type::class, 'id', 'type_id');
//     }

//     public function methodology() {
//         return $this->hasMany(Methodology::class, 'id', 'methodology_id');
//     }

   public function project_technology() {
    return $this->hasMany(ProjectTechnology::class, 'project_id', 'id');
    }
}
