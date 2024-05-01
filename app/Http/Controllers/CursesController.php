<?php

namespace App\Http\Controllers;

use App\Models\Curse;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
class cursesController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('query');

        if ($query) {
            $curses = Curse::where('Name', 'like', "%$query%")
                            ->orWhere('Description', 'like', "%$query%")
                            ->get();
        } else {
            $curses = Curse::all();
        }

        return view("dashboard", compact('curses'));
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
        return view('curses.create');
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


        Curse::create($request->all());
        return redirect()->route('dashboard')->with('success', 'Curse created');
    }
    public function show(int $id)
    {
        $curse = Curse::with(['lessions' => function ($query) {
            $query->orderBy('Number');
        }])->find($id);

        return view('curses.show', compact('curse'));
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
    public function destroy(Curse $Curse)
    {
        $Curse->delete();
        return redirect()->route('dashboard')->with('success', 'Curse deleted');
    }
}
