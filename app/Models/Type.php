<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Purpose;
use App\Models\Methodology;

class Type extends Model
{
    use HasFactory;

    /**
    * The table associated with the model.
    *
    * @var string
    */
   protected $table = 'types';

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
       'type',
   ];

   /**
    * The attributes that should be cast to native types.
    *
    * @var array
    */
   protected $casts = [];

//    public function purpose() {
//        return $this->hasOne(Purpose::class, 'purpose_id', 'id');
//    }

   public function methodologies() {
    return $this->hasMany(Methodology::class);
    }

}
