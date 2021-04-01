<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    public $table = 'clients';
    public $incrementing = false;
    public $timestamps = false;

    protected $casts = ['id' => 'string'];
    protected $fillable = ['id', 'address', 'country', 'price'];
}
