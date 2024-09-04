<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Disposisi3 extends Model
{
    use HasFactory;

    protected $fillable = [
        'isi',
        'selesai',
        'user_id',
        'disposisi2_id'
    ];

    public function disposisi2()
    {
        return $this->belongsTo(Disposisi2::class);
    }

}
