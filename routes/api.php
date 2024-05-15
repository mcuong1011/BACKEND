<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\TestController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    // đăng kí
    Route::post('register', [AuthController::class, 'register']);
    // đăng nhập
    Route::post('login', [AuthController::class, 'login'])->name('login');

});

Route::middleware('api')->group(function () {
    Route::group(["middleware" => "auth:api"], function () {
        Route::post('logout', [AuthController::class, 'logout']);
        Route::post('refresh', [AuthController::class, 'refresh']);
        Route::post('me', [AuthController::class, 'me']);
        // lay ra cac quiz-
        Route::get('quizzes', [QuizController::class, 'index']);
        // Hien 1 quiz-
        Route::get('quizzes/{id}', [QuizController::class, 'show']);
        // lam 1 bai quiz-
        Route::post('test', [TestController::class, 'store']);
        // submit bai quiz-
        Route::post('test/submit', [TestController::class, 'submitTest']);
        // lay ra lich su lam bai-
        Route::get('test/results', [TestController::class, 'getMyResults']);
        // bang xep hang
        Route::get('test/leaderboard/{id}', [TestController::class, 'leaderboard']);
    })->middleware('auth:api');
    Route::middleware("auth:api")->middleware(\App\Middlewares\IsAdmin::class)->group(function () {
        // tao question-
        Route::post('questions', [QuestionController::class, 'store']);
        // sua question
        Route::put('questions/{id}', [QuestionController::class, 'edit']);
        //tao quiz moi-
        Route::post('quizzes', [QuizController::class, 'store']);
        // sua 1 quiz moi
        Route::put('quizzes/{id}', [QuizController::class, 'edit']);
    });
});
