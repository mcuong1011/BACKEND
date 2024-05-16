<?php

use App\Actions\Questions\CreateQuestion;
use App\Actions\Questions\UpdateQuestion;
use App\Actions\Quizzes\CreateQuiz;
use App\Actions\Quizzes\ShowQuiz;
use App\Actions\Quizzes\ShowQuizzes;
use App\Actions\Quizzes\UpdateQuiz;
use App\Actions\Tests\RegisterTest;
use App\Actions\Tests\ShowTestResult;
use App\Actions\Tests\SubmitTest;
use App\Http\Controllers\AuthController;
use App\Middlewares\IsAdmin;
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
        Route::get('quizzes', ShowQuizzes::class);
        // Hien 1 quiz-
        Route::get('quizzes/{id}', ShowQuiz::class);
        // lam 1 bai quiz-
        Route::post('test', RegisterTest::class);
        // submit bai quiz-
        Route::post('test/submit', SubmitTest::class);
        // lay ra lich su lam bai-
        Route::get('test/results', ShowTestResult::class);
        // bang xep hang
//        Route::get('test/leaderboard/{id}', [TestController::class, 'leaderboard']);
    })->middleware('auth:api');
    Route::middleware("auth:api")->middleware(IsAdmin::class)->group(function () {
        // tao question-
        Route::post('questions', CreateQuestion::class);
        // sua question-
        Route::put('questions/{id}', UpdateQuestion::class);
        //tao quiz moi-
        Route::post('quizzes', CreateQuiz::class);
        // sua 1 quiz moi
        Route::put('quizzes/{id}', UpdateQuiz::class);
    });
});
