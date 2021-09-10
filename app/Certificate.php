<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    protected $casts = [
        'shortcodes' => 'object'
    ];
}
