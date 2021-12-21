<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Absence;
use App\Models\ReminderTemplate;


class EventsDefaultsForBg extends Model
{
    use HasFactory;

     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'events_defaults_for_bg';

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
        'title',
        'backgroundColor',
        'display',
        'className'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [];

    public function absences() {
        return $this->belongsTo(Absence::class, 'type', 'type');
    }

    public function reminders() {
        return $this->belongsTo(ReminderTemplate::class, 'type', 'type');
    }

}
