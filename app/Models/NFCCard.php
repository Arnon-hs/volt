<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NFCCard extends Model
{
    use HasFactory;

    public $table = 'nfc_cards';
    protected $fillable = ['sak', 'uid', 'user_id'];
    public $timestamps = false;

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id')->first();
    }
}
