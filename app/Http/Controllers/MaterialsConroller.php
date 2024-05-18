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
        $maxNumber = Material::where('Lession_id', $request->input('lessionId'))->max('Number');
        // Создаем новый материал в зависимости от типа
        if ($type === 'text') {
            $material = new Material();
            $material->Content = $request->input('quillContent');
            $material->Type = 'text';
            $material->Lession_id = $request->input('lessionId');
            $material->Number = $maxNumber + 1;
            $material->save();
        } elseif ($type === 'video') {
            $material = new Material();
            $material->Url = $request->input('url');
            $material->Type = 'video';
            $material->Lession_id = $request->input('lessionId');
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
                $material->Lession_id = $request->input('lessionId');
                $material->Number = $maxNumber + 1;
                $material->save();
            } else {

                return response()->json(['error' => 'Image not provided'], 400);
            }
        } else {

            return response()->json(['error' => 'Invalid material type'], 400);
        }

        // Привязываем материал к уроку


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
        return redirect()->back()->with('success', 'lession deleted successfully.');
    }
}
