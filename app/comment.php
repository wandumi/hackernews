<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class comment extends Model
{
    public function Story(){
        return $this->belongsTo(Story::class);
    }
}
