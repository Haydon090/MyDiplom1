<?php

namespace App\Http\Controllers;
use App\Models\Material;
use Dotenv\Validator;
use Illuminate\Http\Request;
use App\Models\Lession;
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

}
