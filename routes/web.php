<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\BookBorrowingController;
use App\Http\Controllers\BookCategoryController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/books');
});

Route::resource('books', BookController::class);
Route::resource('borrowings', BookBorrowingController::class);
Route::post('borrowings/{borrowing}/return', [BookBorrowingController::class, 'returnBook'])->name('borrowings.return');
Route::resource('categories', BookCategoryController::class);
