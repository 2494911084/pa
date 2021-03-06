<?php

namespace App\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasDateTimeFormatter;

    public function word()
    {
        return $this->hasOne(Word::class);
    }
}
