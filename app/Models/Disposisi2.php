<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Disposisi2 extends Model
{
    use HasFactory;

    protected $fillable = [
        'catatan',
        'selesai',
        'diteruskan1_id'
    ];

    public function diteruskan1()
    {
        return $this->belongsTo(Diteruskan1::class);
    }

    public function diteruskan2()
    {
        return $this->hasMany(Diteruskan2::class);
    }
}
