<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Lession;

class Test extends Model
{
    use HasFactory;
    protected $fillable = ['lesson_id', 'title'];

    public function lession()
    {
        return $this->belongsTo(Lession::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }
}
