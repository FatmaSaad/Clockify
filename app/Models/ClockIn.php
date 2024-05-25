<?php

namespace App\Models;

use App\Models\Relations\ClockInRelations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClockIn extends Model
{
    use HasFactory, ClockInRelations;
    /**
     * @var string[]
     */
    protected $fillable = [

        'user_id',
        'lat',
        'lon',
        'timestamp',
        
    ];
    /** @var array */


}
