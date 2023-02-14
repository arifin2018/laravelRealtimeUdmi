<?php

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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
use Illuminate\Support\Facades\Lang;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/tesCollection', function () {

    $data = [];


    $collection = collect(str_split('AAABBCCCCCCCCCCCCCD'));

    for ($i = 0; $i < count($collection); $i++) {
        if (isset($collection[$i + 1]) && $collection[$i] == $collection[$i + 1]) {
            $data[$i][] = $collection[$i];
            $data[$i][] = $collection[$i + 1];
            $arr = $i;
            $i += 1;
            for ($j = $i + 1; $j < count($collection); $j++) {
                if (isset($collection[$j]) && $collection[$i] == $collection[$j]) {
                    $data[$arr][] = $collection[$j];
                    $i += 1;
                }
            }
        } else {
            if (isset($collection[$i - 1][0]) && $collection[$i] == $collection[$i - 1][0]) {
                print_r($i);
                $data[$i - 2][] = $collection[$i];
            } else {
                $data[$i] = $collection[$i];
            }
        }
    }

    return $data;

    // [['A', 'A'], ['B', 'B'], ['C', 'C', 'C'], ['D']]
    $collection = collect(str_split('AABBCCCD'));
    $chunks = $collection->chunkWhile(function ($value, $key, $chunk) {
        return $value === $chunk->last();
    });

    return $chunks->all();
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::view('/users', 'users.showAll')->name('users.all');
Route::view('/games', 'games.showAll')->name('games.all');
