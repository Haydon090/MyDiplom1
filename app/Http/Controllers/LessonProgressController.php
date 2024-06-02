<?php

namespace App\Http\Controllers;

use App\Models\Lession;
use App\Models\UserLessonProgress;
use Illuminate\Http\Request;

class LessonProgressController extends Controller
{
    public function markLessonAsCompleted(Request $request,$lession_id)
    {
        // Метод для пометки урока как завершенного пользователем
        $userId = auth()->id(); // Получаем ID текущего пользователя

        UserLessonProgress::create([
            'user_id' => $userId,
            'lession_id' => $lession_id,
            'completed' => true,
        ]);

        return response()->json(['message' => 'Lesson marked as completed']);
    }

}
