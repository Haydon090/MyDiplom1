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
    protected $fillable = ['Title','Content','Size','Type','File_path','Url','Number','Lession_id','FileName'];
    protected $table = 'materials';
}
