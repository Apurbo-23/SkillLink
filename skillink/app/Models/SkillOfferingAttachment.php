<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SkillOfferingAttachment extends Model
{
    protected $fillable = ['skill_offering_id', 'type', 'original_name', 'path', 'url'];
    
    public function skillOffering()
    {
        return $this->belongsTo(SkillOffering::class);
    }
}

