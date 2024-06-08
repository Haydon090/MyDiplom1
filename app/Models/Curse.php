<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use League\CommonMark\Extension\Table\Table;

class Curse extends Model
{
    use HasFactory;
    protected $fillable = ['Name','Description','Price','file_path'];
    protected $table = 'curses';
    public function users()
{
    return $this->belongsToMany(User::class);

}
public function ratings()
    {
        return $this->hasMany(CurseRating::class);
    }
protected static function boot()
{
    parent::boot();

    static::deleting(function ($curse) {
        // При удалении курса удаляем связанные записи из таблицы промежуточной связи с тегами
        $curse->tags()->detach();
    });
}
public function tags()
{
    return $this->belongsToMany(Tag::class);
}
public function lessions()
{
    return $this->hasMany(Lession::class);
}
public function hasUserRated($userId)
{
    return $this->ratings()->where('user_id', $userId)->exists();
}
}
