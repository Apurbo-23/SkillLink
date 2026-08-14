<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SkillOffering extends Model
{
    protected $fillable = ['user_id', 'category', 'skill_name'];

    public function attachments()
    {
        return $this->hasMany(SkillOfferingAttachment::class);
    }
}