<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LensMarkController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('lensMark')->group(function () {
    Route::get('/', [LensMarkController::class, 'index'])->name('lensMarks.index');                     // 전체리스트
    Route::get('/search', [LensMarkController::class, 'index'])->name('lensMarks.index');   // 전체리스트(type별 검색)
    Route::get('/show/{id}', [LensMarkController::class, 'show'])->name('lensMarks.show');              // 상세보기
    Route::post('/store', [LensMarkController::class, 'store'])->name('lensMarks.store');               // 등록
    Route::post('/update/{id}', [LensMarkController::class, 'update'])->name('lensMarks.update');       // 수정
    Route::post('/delete/{id}', [LensMarkController::class, 'destroy'])->name('lensMarks.destroy');     // 삭제


    Route::get('/findClassification/{select}', [LensMarkController::class, 'findClassification'])->name('lensMarks.classification'); // 분류별 보기
    Route::get('/findManufacturer/{select}', [LensMarkController::class, 'findManufacturer'])->name('lensMarks.manufacturer');  // 제조사별 보기
    Route::get('/findRefractiveIndex/{select}', [LensMarkController::class, 'findRefractiveIndex'])->name('lensMarks.refractive_index'); // 굴절률 보기
    Route::get('/findKeyword/{select}', [LensMarkController::class, 'findKeyword'])->name('lensMarks.keyword');  //검색어별 보기
});
