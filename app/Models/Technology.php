<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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

    public function scopeWithDataKey($query) {
        return $query->selectRaw("*, CONCAT('p', purpose_id, '_t', type_id, '_m', methodology_id, '_', technology) as data_key");
    }

    protected static function booted()
    {
        static::addGlobalScope('withDataKey', function (Builder $builder) {
            $builder->selectRaw("*, CONCAT('p', purpose_id, '_t', type_id, '_m', methodology_id, '_', technology) as data_key");
        });
    }


}
