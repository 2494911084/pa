<?php

namespace App\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;

use Illuminate\Database\Eloquent\Model;

class Word extends Model
{
    use HasDateTimeFormatter;

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
