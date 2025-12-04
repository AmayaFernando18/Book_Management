<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookBorrowing extends Model
{
    protected $fillable = ['user_id', 'book_id', 'issued_at', 'returned_at'];
    protected $casts = [
        'issued_at' => 'datetime',
        'returned_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    /**
     * Check if borrowing is active (not returned)
     */
    public function isActive(): bool
    {
        return $this->returned_at === null;
    }

    /**
     * Get days held as integer 
     */
    public function getDaysHeld(): int
    {
        if ($this->returned_at) {
            // Days between issued and returned
            return (int) $this->issued_at->diffInDays($this->returned_at);
        }
        // Days from issued to now
        return (int) $this->issued_at->diffInDays(now());
    }
}
