<?php

namespace App\Http\Controllers;

use App\Models\Curse;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Tag;
class cursesController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('query');
        $selectedTags = $request->input('tags', []);

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

        // Сортируем курсы по среднему рейтингу в убывающем порядке
        $cursesQuery->orderByDesc('ratings_avg');

        $curses = $cursesQuery->get();

        return view('dashboard', ['curses' => $curses]);
    }
    public function myCurses(){
        return view("curses.myCurses");
    }
    public function indexMyCurses(){
        $userId = Auth::user()->id;

    $user = User::findOrFail($userId);
    $curses = $user->curses;

    return view('curses.myCurses', compact('curses'));

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
   return $user->curses()->attach($curse);


}

    public function store(Request $request)
    {


        $curse = Curse::create($request->all());

        // Если выбраны теги, добавляем их к курсу
        if ($request->has('tags')) {
            $tags = $request->input('tags');
            $curse->tags()->attach($tags);
        }

        return redirect()->route('dashboard')->with('success', 'Curse created');
    }
    public function show(int $id)
    {
        $userId = auth()->id();

        $curse = Curse::with(['lessions' => function ($query) {
            $query->orderBy('Number');
        }, 'lessions.userProgress' => function ($query) use ($userId) {
            $query->where('user_id', $userId);
        }])->find($id);
        $user = auth()->user();
        $curse = Curse::withCount('ratings')->withAvg('ratings as ratings_avg', 'rating')->find($id);
        return view('curses.show', compact('curse', 'userId','user'));
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
