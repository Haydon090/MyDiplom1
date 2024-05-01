<?php

namespace App\Models;
use App\Models\Curse;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lession extends Model
{
    use HasFactory;
    public function curse()
    {
        return $this->belongsTo(Curse::class);
    }
    public function materials()
    {
        return $this->hasMany(Material::class);
    }
    protected $fillable = ['Name','Number','Description','curse_id'];
    protected $table = 'lessions';
}
