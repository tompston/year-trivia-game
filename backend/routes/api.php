<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TriviaController;

// GET URL/api/trivia to return the trivia questions
Route::get('/trivia', [TriviaController::class, 'index']);
