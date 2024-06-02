<?php

namespace App\Http\Controllers;

use App\Models\Curse;
use App\Models\CurseRating;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CurseRatingController extends Controller
{
    public function rateCurse(Request $request, $curseId)
{
    // Получаем текущего пользователя
    $user = Auth::user();

    try {
        // Находим курс по ID
        $curse = Curse::findOrFail($curseId);

        // Загружаем связанные уроки
        $curse->load('lessions');

        // Проверяем, завершил ли пользователь все уроки курса
        $allLessonsCompleted = $curse->lessions->every(function ($lession) use ($user) {
            return $lession->isCompletedByUser($user->id);
        });

        if (!$allLessonsCompleted) {
            // Если пользователь не завершил все уроки, возвращаем ошибку
            return response()->json(['error' => 'Вы должны завершить все уроки курса для оценки'], 400);
        }

        // Создаем или обновляем запись оценки курса
        $rating = CurseRating::updateOrCreate(
            ['user_id' => $user->id, 'curse_id' => $curse->id],
            ['rating' => $request->rating]
        );

        // Возвращаем сообщение об успешной оценке курса
        return response()->json(['message' => 'Курс успешно оценен', 'rating' => $rating], 200);
    } catch (ModelNotFoundException $e) {
        // Если курс не найден, возвращаем ошибку
        return response()->json(['error' => 'Курс не найден'], 404);
    }
}
}
