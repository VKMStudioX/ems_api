<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Methodology extends Model
{
    use HasFactory;
    
    /**
    * The table associated with the model.
    *
    * @var string
    */
   protected $table = 'methodologies';

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
       'type_id',
       'methodology',
   ];

   /**
    * The attributes that should be cast to native types.
    *
    * @var array
    */
   protected $casts = [];

   public function type() {
       return $this->hasOne(Purpose::class, 'purpose_id', 'id');
   }

   public function methodology() {
    return $this->belongsTo(Methodology::class, 'methodology_id', 'id');
}
}
