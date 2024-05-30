<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;
    protected $fillable = ['Name'];
    protected $table = 'tags';
    public function curses()
    {
        return $this->belongsToMany(Curse::class);
    }

}
