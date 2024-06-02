<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserLessonProgress extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'lession_id', 'completed'];
}
