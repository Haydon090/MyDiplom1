<?php

namespace App\Http\Controllers;
use App\Models\Material;
use Dotenv\Validator;
use Facade\FlareClient\Stacktrace\File;
use Illuminate\Http\Request;
use App\Models\Lession;
use Illuminate\Support\Facades\Storage;
class MaterialsConroller extends Controller
{
    public function store(Request $request)
    {
        // Проверяем тип материала
        $type = $request->input('materialType');
        $maxNumber = Material::where('lession_id', $request->input('lessionId'))->max('Number');

        // Создаем новый материал в зависимости от типа
        if ($type === 'text') {
            $material = new Material();
            $material->Content = $request->input('quillContent');
            $material->Type = 'text';
            $material->lession_id = $request->input('lessionId');
            $material->Number = $maxNumber + 1;
            $material->save();
        } elseif ($type === 'video') {
            $material = new Material();
            $material->Url = $request->input('url');
            $material->Type = 'video';
            $material->lession_id = $request->input('lessionId');
            $material->Number = $maxNumber + 1;
            $material->save();
        } elseif ($type === 'image') {
            // Обработка загрузки изображения
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = $image->getClientOriginalName();
                $imagePath = 'images/' . $imageName;
                $image->move(public_path('images'), $imageName);
                $material = new Material();
                $material->FileName = $imageName;
                $material->File_path = $imagePath;
                $material->Type = 'image';
                $material->lession_id = $request->input('lessionId');
                $material->Number = $maxNumber + 1;
                $material->save();
            } else {
                return response()->json(['error' => 'Image not provided'], 400);
            }
        } else {
            return response()->json(['error' => 'Invalid material type'], 400);
        }
        // Возвращаем успешный ответ
        return response()->json(['message' => 'Material successfully stored'], 200);
    }

    public function destroy($id)
    {
        // Находим материал по его идентификатору
        $material = Material::findOrFail($id);

        // Удаляем файл, если это изображение
        if ($material->Type === 'image') {
            Storage::delete($material->File_path);
        }

        // Удаляем материал из базы данных
        $material->delete();

        // Возвращаем успешный ответ
        return redirect()->back()->with('success', 'Material deleted successfully.');
    }

    public function moveUp($currentId, $prevId)
    {
        $currentMaterial = Material::findOrFail($currentId);
        $prevMaterial = Material::findOrFail($prevId);

        // Меняем местами номера
        $temp = $currentMaterial->Number;
        $currentMaterial->Number = $prevMaterial->Number;
        $prevMaterial->Number = $temp;

        $currentMaterial->save();
        $prevMaterial->save();

        return redirect()->back()->with('success', 'Material moved up successfully.');
    }
   // MaterialController.php

public function update(Request $request, $id)
{
    $material = Material::find($id);
    $material->Type = $request->input('materialType');

    if ($material->Type === 'text') {
        $material->Content = $request->input('quillContent');
    } else if ($material->Type === 'image') {
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $path = $file->store('images', 'public');
            $material->File_path = $path;
        }
    } else if ($material->Type === 'video') {
        $material->Url = $request->input('url');
    }

    $material->save();

    return response()->json(['success' => true]);
}

    public function moveDown($currentId, $nextId)
    {
        $currentMaterial = Material::findOrFail($currentId);
        $nextMaterial = Material::findOrFail($nextId);

        // Меняем местами номера
        $temp = $currentMaterial->Number;
        $currentMaterial->Number = $nextMaterial->Number;
        $nextMaterial->Number = $temp;

        $currentMaterial->save();
        $nextMaterial->save();

        return redirect()->back()->with('success', 'Material moved down successfully.');
    }
}
