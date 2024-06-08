<?php

namespace App\Http\Controllers;

use App\Models\Curse;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Tag;
use Dotenv\Validator;
use Facade\FlareClient\Stacktrace\File;
use Illuminate\Support\Facades\Storage;
class cursesController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('query');
        $selectedTags = $request->input('tags', []);
        $sortBy = $request->input('sort_by', 'completions'); // По умолчанию сортировка по количеству оценок

        $cursesQuery = Curse::query();

        if ($query) {
            $cursesQuery->where('curses.Name', 'like', "%$query%")
                        ->orWhere('curses.Description', 'like', "%$query%");
        }

        if ($selectedTags) {
            $cursesQuery->whereHas('tags', function ($query) use ($selectedTags) {
                $query->whereIn('tags.id', $selectedTags);
            });
        }

        // Загружаем количество оценок для каждого курса
        $cursesQuery->withCount('ratings');

        // Загружаем средний рейтинг для каждого курса
        $cursesQuery->withAvg('ratings as ratings_avg', 'rating');

        // Сортируем курсы по выбранному параметру
        if ($sortBy === 'completions') {
            $cursesQuery->orderByDesc('ratings_count'); // Сортировка по количеству оценок (прохождений)
        } else {
            $cursesQuery->orderByDesc('ratings_avg'); // Сортировка по среднему рейтингу
        }

        $curses = $cursesQuery->get();

        return view('dashboard', ['curses' => $curses, 'sortBy' => $sortBy, 'query' => $query]);
    }
    public function myCurses(){
        return view("curses.myCurses");
    }
    public function indexMyCurses(Request $request){
        $userId = Auth::id(); // Получаем ID текущего пользователя

        // Находим пользователя
        $user = User::findOrFail($userId);

        // Получаем курсы, добавленные пользователем на его аккаунт
        $cursesQuery = $user->curses();

        // Применяем фильтры поиска и сортировки
        if ($request->filled('query')) {
            $query = $request->input('query');
            $cursesQuery->where('Name', 'like', "%$query%")
                        ->orWhere('Description', 'like', "%$query%");
        }

        if ($request->filled('tags')) {
            $selectedTags = $request->input('tags', []);
            $cursesQuery->whereHas('tags', function ($query) use ($selectedTags) {
                $query->whereIn('tags.id', $selectedTags);
            });
        }

        // Загружаем количество оценок для каждого курса
        $cursesQuery->withCount('ratings');

        // Загружаем средний рейтинг для каждого курса
        $cursesQuery->withAvg('ratings as ratings_avg', 'rating');

        // Сортировка курсов
        $sortBy = $request->input('sort_by', 'completions'); // По умолчанию сортировка по количеству оценок

        if ($sortBy === 'completions') {
            $cursesQuery->orderByDesc('ratings_count'); // Сортировка по количеству оценок (прохождений)
        } else {
            $cursesQuery->orderByDesc('ratings_avg'); // Сортировка по среднему рейтингу
        }

        // Получаем отфильтрованные и отсортированные курсы
        $curses = $cursesQuery->get();

        // Передаем данные в представление
        return view('curses.myCurses', [
            'curses' => $curses,
            'sortBy' => $sortBy,
            'query' => $request->input('query'),
        ]);
    }

    public function create()
    {
        $tags = Tag::all(); // получаем список всех тегов
        return view('curses.create', compact('tags'));
    }
    public function addUserToCourse(int $curseId)
{
    // Находим пользователя по его идентификатору
    $userId = Auth::user()->id;
    $user = User::find($userId);
    $curse = Curse::find($curseId);
    if ($user->curses->contains($curseId)) {
        return redirect()->route('dashboard')->with('success', 'этот курс уже добавлен на аккаунт');
    }



    // Добавляем пользователя к курсу
    $user->curses()->attach($curse);

    return redirect()->route('dashboard')->with('success', 'курс добавлен на аккаунт');
}

    public function store(Request $request)
    {
        $request->validate([
            'Name' => 'required|string|max:255',
            'Description' => 'required|string',

        ]);


        $curse = Curse::create([
            'Name' => $request->input('Name'),
            'Description' => $request->input('Description'),

        ]);

        if ($request->has('tags')) {
            $tags = $request->input('tags');
            $curse->tags()->attach($tags);
        }


        return redirect()->route('dashboard')->with('success', 'Curse created');
    }

    public function show(int $id)
    {
        $userId = auth()->id();

        $curse = Curse::with([
            'lessions' => function ($query) {
                $query->orderBy('Number');
            },
            'lessions.userProgress' => function ($query) use ($userId) {
                $query->where('user_id', $userId);
            },
            'ratings', // Загружаем связанные рейтинги курса
            'ratings.user', // Загружаем информацию о пользователях, оставивших рейтинги
        ])->withCount('ratings')->withAvg('ratings as ratings_avg', 'rating')->find($id);

        $user = auth()->user();

        return view('curses.show', compact('curse', 'userId', 'user'));
    }
    public function statistics()
    {
        // Извлечение всех курсов с их оценками и пользователями, которые их оставили
        $curses = Curse::with(['ratings', 'ratings.user'])
                    ->withCount('ratings')
                    ->withAvg('ratings as ratings_avg', 'rating')
                    ->get();

    return view('curses.statistics', compact('curses'));
    }
    public function edit(int $id)
    {
        $curse = Curse::find($id);
        return view('curses.edit', compact('curse'));
    }
    public function update(Curse $curse, Request $request)
    {

        $curse->update($request->all());
        return redirect()->route('dashboard')->with('success', 'curse updated');
    }
    public function destroy(Curse $curse)
    {

        $curse->delete();
        return redirect()->route('dashboard')->with('success', 'Curse deleted');
    }
}
