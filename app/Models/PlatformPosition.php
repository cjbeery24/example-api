<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlatformPosition extends BaseModel
{
    use HasFactory;

    protected $connection = 'external';
    protected $table = 'ag_platformPositions';
    protected $fillable = [
        'platform_id',
        'pgp_id',
        'row',
        'col',
        'plantContainer_id',
    ];
    public $timestamps = false;
}
