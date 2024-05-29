<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Platform extends BaseModel
{
    use HasFactory;

    protected $connection = 'external';
    protected $table = 'ag_platforms';

    protected $fillable = [
        'platformType_id',
        'platformGroup_id',
        'platformName',
        'level',
        'active',
        'creationDate',
        'retireDate',
    ];
    public $timestamps = false;

    public function platformPositions(): HasMany
    {
        return $this->hasMany(PlatformPosition::class, 'platform_id');
    }
}
