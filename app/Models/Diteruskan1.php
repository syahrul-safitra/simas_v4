<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Diteruskan1 extends Model
{
    use HasFactory;

    protected $fillable = ['disposisi1_id', 'user_id'];

    public function disposisi1()
    {
        return $this->belongsTo(Disposisi1::class);
    }

    public function disposisi2()
    {
        return $this->hasOne(Disposisi2::class);
    }
}
