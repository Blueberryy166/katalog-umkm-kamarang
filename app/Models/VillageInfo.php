<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VillageInfo extends Model
{
    use HasFactory;

    protected $fillable = [
        'village_name',
        'district',
        'regency',
        'province',
        'total_population',
        'total_families',
        'total_umkm',
        'history',
        'vision_mission',
        'contact_phone',
        'contact_email',
        'village_head_name',
        'village_head_speech',
        'kkm_team_name',
    ];
}
