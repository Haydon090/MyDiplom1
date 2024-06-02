<?php
use App\Http\Controllers\CurseRatingController;
use App\Http\Controllers\CursesController;
use App\Http\Controllers\LessionsController;
use App\Http\Controllers\LessonProgressController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SocialController;
use App\Http\Controllers\MaterialsConroller;
use App\Http\Controllers\TagsController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth/login');
});

Route::get('/register', function () {
return view('auth/register');
})->name('register');
Route::get('/login/vk',[SocialController::class,'index'])->name('vk.auth');
Route::get('/login/vk/callback',[SocialController::class,'callback']);
Route::get('/add/{id}',[CursesController::class, 'addUserToCourse'])->name('curses.add');
Route::get('/dashboard', [CursesController::class, 'index'])->name('dashboard');
Route::post('/create', [CursesController::class, 'store'])->name('curses.store');
Route::get('/create',[CursesController::class,'create()'])->name('curses.create');
Route::resource('curses', CursesController::class);
Route::get('/edit/{id}', [CursesController::class,'edit'])->name('curses.edit');
Route::post('/edit/{curse}', [CursesController::class,'update'])->name('curse.update');
Route::get('/show/{id}', [CursesController::class,'show'] )->name('curses.show');
Route::delete('/dashboard/{curse}',[CursesController::class,'destroy'])->name('curses.destroy');
Route::post("/curses/{curseId}/rate", [CurseRatingController::class, 'rateCurse'])->name('curses.rate');
Route::get("/myCursesIndex", [CursesController::class, 'indexMyCurses'])->name('curses.myCurses');
Route::post('/tags', [TagsController::class, 'store'])->name('tags.store');
require __DIR__.'/auth.php';

Route::post('/courses/{curseId}/lessons', [LessionsController::class,'store'])->name('curses.lessions.store'); // Изменил название маршрута
Route::delete('/courses/{curseId}/lessons/{lessionId}', [LessionsController::class,'destroy'])->name('curses.lessions.destroy'); // Изменил название маршрута
Route::get('lessions/create{curseId}',[LessionsController::class,'create'])->name('lessions.create');
Route::post('/courses/{curseId}/lessons/{lessionId}/move-up', [LessionsController::class, 'moveUp'])->name('curses.lessions.move-up');
Route::post('/courses/{curseId}/lessons/{lessionId}/move-down', [LessionsController::class, 'moveDown'])->name('curses.lessions.move-down');
Route::get('/curses/{curseId}/lessons/{lession}/update', [LessionsController::class,'update'])->name('lessions.update');
Route::post('/edit/lession/{lession}/{curseId}', [LessionsController::class,'edit'])->name('lession.edit');
Route::get('/show/lession/{lession}', [LessionsController::class,'show'])->name('lessions.show');

Route::post('/materials', [MaterialsConroller::class, 'store'])->name('materials.store');
Route::delete('/materials/{id}', [MaterialsConroller::class, 'destroy'])->name('materials.destroy');
Route::put('/materials/move-up/{currentId}/{prevId}', [MaterialsConroller::class, 'moveUp'])->name('materials.moveUp');
Route::put('/materials/move-down/{currentId}/{nextId}', [MaterialsConroller::class, 'moveDown'])->name('materials.moveDown');
Route::put('/materials/{id}', [MaterialsConroller::class, 'update'])->name('materials.update');

Route::get('/tests/create/{lession}', [TestController::class, 'create'])->name('tests.create');
Route::post('/tests/{lession}', [TestController::class, 'store'])->name('tests.store');
Route::get('/tests/{lession}', [TestController::class, 'show'])->name('tests.show');

Route::get('tests/{test}/questions/create', [QuestionController::class, 'create'])->name('questions.create');
Route::post('tests/{test}/questions', [QuestionController::class, 'store'])->name('questions.store');
Route::delete('questions/{question}', [QuestionController::class, 'destroy'])->name('questions.destroy');
Route::get('questions/{question}/edit', [QuestionController::class, 'edit'])->name('questions.edit');
Route::put('questions/{question}', [QuestionController::class, 'update'])->name('questions.update');
Route::get('/tests/{test}/take', [TestController::class, 'take'])->name('tests.take');
Route::post('/tests/{test}/submit', [TestController::class, 'submit'])->name('tests.submit');
Route::post('/lessions/{lession_id}/complete', [LessonProgressController::class, 'markLessonAsCompleted'])->name('lession.complete');
