<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class ProjectUser extends Model
{
    use HasFactory;
    
    /**
    * The table associated with the model.
    *
    * @var string
    */
   protected $table = 'projects_users';

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
       'user_id',
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

   public function user() {
    return $this->hasOne(User::class, 'id', 'user_id');
    }

}
