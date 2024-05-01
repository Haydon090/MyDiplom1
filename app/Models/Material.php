<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory;
    public function lessions()
    {
        return $this->belongsToMany(Lession::class);
    }
    protected $fillable = ['Title','Content','Size','Font','Section_id','Type','File_pah','Url','Number'];
    protected $table = 'materials';
}
