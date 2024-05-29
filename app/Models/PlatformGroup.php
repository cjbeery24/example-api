<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PlatformGroup extends BaseModel
{
    use HasFactory;

    protected $connection = 'external';
    protected $table = 'ag_platformGroups';
    protected $fillable = [
        'controller_id',
        'platformGroupType_id',
        'platformGroupName',
        'area_id',
        'active',
        'creationDate',
        'retireDate',
        'growZone_id',
        'emergencyShutoffTempC',
        'hardware_item_id',
        'motherUnit',
        'latitude',
        'longitude',
        'elevation',
        'productionPlanAllocation_id',
        'adjacentPlatformGroupsForIpm',
        'commissionDate',
        'lastIrrigatedTime',
        'nextIrrigatedTime',
    ];
    public $timestamps = false;

    public function platforms(): HasMany
    {
        return $this->hasMany(Platform::class, 'platformGroup_id');
    }
}
