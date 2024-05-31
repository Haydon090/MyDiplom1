<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;
    protected $fillable = ['test_id','question_text', 'text_answer','is_text_answer','answers', 'correct_answers'];

    protected $casts = [
        'answers' => 'array',
        'correct_answers' => 'array'
    ];
    public function test()
    {
        return $this->belongsTo(Test::class);
    }
}
