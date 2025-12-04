<?php

namespace App\Http\Controllers;

use App\Models\BookBorrowing;
use App\Models\Book;
use App\Models\User;
use Illuminate\Http\Request;

class BookBorrowingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $borrowings = BookBorrowing::with('user', 'book')->orderBy('issued_at', 'desc')->get();
        return view('borrowings.index', compact('borrowings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::all();
        $books = Book::where('stock', '>', 0)->get();
        return view('borrowings.create', compact('users', 'books'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'book_id' => 'required|exists:books,id',
        ]);

        $book = Book::find($request->book_id);
        
        // Check if book is out of stock
        if ($book->stock <= 0) {
            return back()->with('error', 'This book is currently out of stock!');
        }

        // Check if user already has THIS SPECIFIC BOOK borrowed (not yet returned)
        $alreadyBorrowed = BookBorrowing::where('user_id', $request->user_id)
            ->where('book_id', $request->book_id)
            ->whereNull('returned_at')
            ->exists();

        if ($alreadyBorrowed) {
            return back()->with('error', 'This user already has this book borrowed! Please return it first.');
        }

        // Reduce stock and create borrowing record
        $book->decrement('stock');

        BookBorrowing::create([
            'user_id' => $request->user_id,
            'book_id' => $request->book_id,
            'issued_at' => now(),
        ]);

        return redirect('/borrowings')->with('success', 'Book issued successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(BookBorrowing $borrowing)
    {
        $borrowing->load('user', 'book.category');
        return view('borrowings.show', compact('borrowing'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BookBorrowing $borrowing)
    {
        // Note: Typically borrowings shouldn't be edited after creation
        // This is here for completeness, but you might want to disable it
        $users = User::all();
        $books = Book::all();
        return view('borrowings.edit', compact('borrowing', 'users', 'books'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BookBorrowing $borrowing)
    {
        // Note: Typically borrowings shouldn't be updated after creation
        // This is here for completeness, but you might want to disable it
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'book_id' => 'required|exists:books,id',
        ]);

        // If book changed, handle stock adjustments
        if ($borrowing->book_id != $request->book_id) {
            $oldBook = Book::find($borrowing->book_id);
            $newBook = Book::find($request->book_id);
            
            // Only adjust if not returned
            if (!$borrowing->returned_at) {
                $oldBook->increment('stock');
                if ($newBook->stock <= 0) {
                    return back()->with('error', 'The new book is out of stock!');
                }
                $newBook->decrement('stock');
            }
        }

        $borrowing->update($request->only(['user_id', 'book_id']));
        return redirect('/borrowings')->with('success', 'Borrowing record updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BookBorrowing $borrowing)
    {
        // If not returned, restore stock
        if (!$borrowing->returned_at) {
            $borrowing->book->increment('stock');
        }
        
        $borrowing->delete();
        return redirect('/borrowings')->with('success', 'Borrowing record deleted successfully!');
    }

    public function returnBook(BookBorrowing $borrowing)
    {
        // Check if already returned
        if ($borrowing->returned_at) {
            return back()->with('error', 'This book has already been returned!');
        }

        // Mark as returned and increase stock
        $borrowing->update(['returned_at' => now()]);
        $borrowing->book->increment('stock');

        return redirect('/borrowings')->with('success', 'Book returned successfully!');
    }
}
