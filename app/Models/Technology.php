<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Technology extends Model
{
    use HasFactory;
    /**
    * The table associated with the model.
    *
    * @var string
    */
   protected $table = 'technologies';

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
       'purpose_id',
       'type_id',
       'methodology_id',
       'technology',
       'language',
   ];

   /**
    * The attributes that should be cast to native types.
    *
    * @var array
    */
   protected $casts = [];

   public function purpose() {
    return $this->hasOne(Type::class, 'id', 'purpose_id');
    }

   public function type() {
       return $this->hasOne(Type::class, 'id', 'type_id');
   }

   public function methodology() {
    return $this->hasOne(Methodology::class, 'id', 'methodology_id');
}
}
