<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Disposisi2 extends Model
{
    use HasFactory;

    protected $fillable = [
        'isi',
        'selesai',
        'user_id',
        'disposisi1_id'
    ];

    public function disposisi3()
    {
        return $this->hasOne(Disposisi3::class);
    }

    public function disposisi1()
    {
        return $this->belongsTo(Disposisi1::class);
    }
}
