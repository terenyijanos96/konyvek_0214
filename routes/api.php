<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\CopyController;
use App\Http\Controllers\LendingController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\UserController;
use App\Models\Book;
use App\Models\Copy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth.basic')->group(function () {
    //bejelentkezett felhasználó láthatja
    Route::middleware( ['admin'])->group(function () {
        //admin útvonalai itt lesznek, pl.
            Route::apiResource('/users', UserController::class);
    });
    //Lekérdezések with
    Route::get('lending_by_user', [UserController::class, 'lendingByUser']);
    Route::get('all_lending_user_copy', [LendingController::class, 'allLendingUserCopy']);
    Route::get('lendings_count_user', [LendingController::class, 'lendingsCountByUser']);
    //DB lekérdezések
    Route::get('title_count/{title}', [BookController::class, 'titleCount']);
    Route::get('h_author_title/{hardcovered}', [CopyController::class, 'hAuthorTitle']);
    Route::get('ev/{year}', [CopyController::class, 'ev']);
    //2 tábla módosítása egyszerre
    Route::patch('bring-back/{copy_id}/{start}', [LendingController::class, 'bringBack']);
    //TRIGGER
    Route::post('lendings', [LendingController::class, 'store']);
});

//guest is láthatja
Route::apiResource('/copies', CopyController::class);
Route::apiResource('/books', BookController::class);

Route::get('lendings', [LendingController::class, 'index']);
Route::get('lendings/{user_id}/{copy_id}/{start}', [LendingController::class, 'show']);
//Route::put('/lendings/{user_id}/{copy_id}/{start}', [LendingController::class, 'update']);

Route::delete('lendings/{user_id}/{copy_id}/{start}', [LendingController::class, 'destroy']); 

Route::get('reservations', [ReservationController::class, 'index']);
Route::get('reservations/{book_id}/{user_id}/{start}', [ReservationController::class, 'show']);
Route::put('reservations/{book_id}/{user_id}/{start}', [ReservationController::class, 'update']);
Route::post('reservations', [ReservationController::class, 'store']);
Route::delete('reservations/{book_id}/{user_id}/{start}', [ReservationController::class, 'destroy']); 


Route::get('author_with_more_books', [BookController::class, 'authorWithMoreBooks']); 
Route::get('brought_back_on/{date}', [LendingController::class, 'broughtBackOn']); 

//egyéb végpontok
Route::patch('user_update_password/{id}', [UserController::class, 'updatePassword']);

