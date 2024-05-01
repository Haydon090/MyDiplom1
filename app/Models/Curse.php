<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use League\CommonMark\Extension\Table\Table;

class Curse extends Model
{
    use HasFactory;
    protected $fillable = ['Name','Description','Price'];
    protected $table = 'curses';
    public function users()
{
    return $this->belongsToMany(User::class);
}
public function lessions()
{
    return $this->hasMany(Lession::class);
}
}
