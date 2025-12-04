@extends('layouts.app')

@section('content')
<!-- Page Header -->
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h1>Book Borrowings</h1>
        <p>Track book issuance and returns</p>
    </div>
    <a href="/borrowings/create" class="btn btn-success btn-lg">
        <i class="bi bi-plus-circle"></i> Issue Book
    </a>
</div>

<!-- Borrowings Table -->
@if($borrowings->isEmpty())
    <div class="empty-state">
        <i class="bi bi-inbox"></i>
        <h3>No Borrowing Records</h3>
        <p>Start by issuing a book to members.</p>
        <a href="/borrowings/create" class="btn btn-primary" style="font-size: 0.95rem; padding: 0.5rem 1rem;">
            <i class="bi bi-plus-circle" style="font-size: 0.9rem; margin-right: 0.4rem;"></i> Issue First Book
        </a>
    </div>
@else
    <div class="card">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Book Title</th>
                        <th>Issued Date</th>
                        <th>Return Date</th>
                        <th>Status</th>
                        <th style="text-align: center;">Days</th>
                        <th style="text-align: center;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($borrowings as $borrowing)
                        <tr>
                            <td>
                                <strong>{{ $borrowing->user->name }}</strong>
                            </td>
                            <td>{{ $borrowing->book->title }}</td>
                            <td>{{ $borrowing->issued_at->format('M d, Y') }}</td>
                            <td>
                                @if ($borrowing->returned_at)
                                    {{ $borrowing->returned_at->format('M d, Y') }}
                                @else
                                    <span style="color: var(--text-secondary);">-</span>
                                @endif
                            </td>
                            <td>
                                @if ($borrowing->returned_at)
                                    <span class="badge badge-success">
                                        <i class="bi bi-check-circle"></i> Returned
                                    </span>
                                @else
                                    <span class="badge badge-warning">
                                        <i class="bi bi-hourglass-split"></i> Borrowed
                                    </span>
                                @endif
                            </td>
                            <td style="text-align: center;">
                                <strong>{{ $borrowing->getDaysHeld() }}</strong>
                            </td>
                            <td style="text-align: center;">
                                @if (!$borrowing->returned_at)
                                    <form action="/borrowings/{{ $borrowing->id }}/return" method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-info btn-sm" title="Return Book">
                                            <i class="bi bi-arrow-counterclockwise"></i> Return
                                        </button>
                                    </form>
                                @else
                                    <span style="color: var(--text-secondary);">-</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endif
@endsection