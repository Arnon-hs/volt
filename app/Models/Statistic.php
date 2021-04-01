<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use PhpClickHouseLaravel\BaseModel;

class Statistic extends BaseModel
{
    use HasFactory;

    protected $table = 'stat';
}
