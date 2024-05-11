<?php

namespace App\Http\Controllers;
use App\Models\Curse;
use App\Models\Material;
use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Http\Request;
use App\Models\Lession;
use GuzzleHttp\Psr7\Message;

class LessionsController extends Controller
{
    public function create(int $id){
        return view('lessions.create', compact('id'));
    }
    public function store(Request $request, int $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);
        $maxNumber = Lession::where('curse_id', $id)->max('Number');
        $lession = new Lession();
        $lession->Name = $request->title; // Исправлено
        $lession->description = $request->description;
        $lession->curse_id = $id;
        $lession->Number = $maxNumber +1;
        $lession->save();

        return redirect()->route('curses.show', $id)->with('success', 'lession created successfully.');
    }
    public function moveUp($curseId, $lessionId)
    {
        $lession = Lession::findOrFail($lessionId);

        $lessions = Lession::where('curse_id', $curseId)->orderBy('Number')->get();
        $currentlessionIndex = $lessions->search(function ($item) use ($lessionId) {
            return $item->id == $lessionId;
        });

        if ($currentlessionIndex > 0) {
            $prevlession = $lessions[$currentlessionIndex - 1];
            $prevlession->Number += 1;
            $prevlession->save();

            $lession->Number -= 1;
            $lession->save();
        }

        return redirect()->back();
    }
    public function update($curseId,Lession $lession){
        // return view('lessions.update', compact('lession','curseId'));
        return view('lessions.update')->with('lession', $lession)->with('curseId', $curseId);
    }
    public function show(Lession $lession)
    {
         $materials = Material::where('Lession_id', $lession->id)->orderBy('Number')->get();

        //dd($materials[0]->Url);
        return view('lessions.show')->with('lession',$lession)->with('materials', $materials);
    }
    public function edit(Lession $lession, $curseId, Request $request)
    {

        $lession->update($request->all());
        return redirect()->route('curses.show', $curseId)->with('success', 'lession updated successfully.');
    }
    public function moveDown($curseId, $lessionId)
    {
        $lession = Lession::findOrFail($lessionId);

        $lessions = Lession::where('curse_id', $curseId)->orderBy('Number')->get();
        $currentlessionIndex = $lessions->search(function ($item) use ($lessionId) {
            return $item->id == $lessionId;
        });

        if ($currentlessionIndex < count($lessions) - 1) {
            $nextlession = $lessions[$currentlessionIndex + 1];
            $nextlession->Number -= 1;
            $nextlession->save();

            $lession->Number += 1;
            $lession->save();
        }

        return redirect()->back();
    }
    public function destroy($curseId, $lessionId)
    {
        // Находим курс
        $curse = Curse::findOrFail($curseId);
        $materials = Material::where('Lession_id', $lessionId)->get();
        foreach ($materials as $material) {
            $material->delete();
        }
        // Проверяем, принадлежит ли урок к указанному курсу
        $lession = $curse->lessions()->find($lessionId);
        if (!$lession) {
            return redirect()->back()->with('error', 'lession not found.');
        }

        // Удаляем урок
        $lession->delete();

        // Обновляем номера уроков
        $this->updatelessionNumbers($curseId);

        return redirect()->back()->with('success', 'lession deleted successfully.');
    }

    private function updatelessionNumbers($curseId)
    {
        $curse = Curse::findOrFail($curseId);
        $lessions = $curse->lessions()->orderBy('Number')->get();
        $number = 1;

        foreach ($lessions as $lession) {
            $lession->Number = $number++;
            $lession->save();
        }
    }
}
