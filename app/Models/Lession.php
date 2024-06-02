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
    public function userProgress()
    {
        return $this->hasMany(UserLessonProgress::class, 'lession_id', 'id');
    }
    public function isCompletedByUser($userId)
    {
        // Проверяем, есть ли запись в таблице UserLessonProgress для указанного пользователя и этого урока
        return UserLessonProgress::where('user_id', $userId)
            ->where('lession_id', $this->id)
            ->exists();
    }
    public function test()
    {
        return $this->hasOne(Test::class);
    }
    public function materials()
    {
        return $this->hasMany(Material::class);
    }
    protected $fillable = ['Name','Number','Description','curse_id'];
    protected $table = 'lessions';
}
