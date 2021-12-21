<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Project;
use App\Models\Methodology;
use App\Models\Technology;
use App\Models\Type;


class ProjectTechnology extends Model
{
    use HasFactory;
    
    /**
    * The table associated with the model.
    *
    * @var string
    */
   protected $table = 'projects_technologies';

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
       'project_id',
       'type_id',
       'methodology_id',
       'technology_id'
   ];

   /**
    * The attributes that should be cast to native types.
    *
    * @var array
    */
   protected $casts = [];

   public function project() {
       return $this->hasOne(Project::class, 'id', 'project_id');
   }

   public function purpose() {
    return $this->hasOne(Type::class, 'id', 'purpose_id');
    }

   public function type() {
    return $this->hasOne(Type::class, 'id', 'type_id');
    }

    public function methodology() {
        return $this->hasOne(Methodology::class, 'id', 'methodology_id');
    }

   public function technology() {
    return $this->hasOne(Technology::class, 'id', 'technology_id');
    }

}
