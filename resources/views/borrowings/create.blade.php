@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-8">
        <h2>Issue Book</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="/borrowings" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label">User</label>
                <select name="user_id" class="form-control" required>
                    <option value="">Select User</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Book</label>
                <select name="book_id" class="form-control" required>
                    <option value="">Select Book</option>
                    @foreach ($books as $book)
                        <option value="{{ $book->id }}">{{ $book->title }} (Stock: {{ $book->stock }})</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-success">Issue Book</button>
            <a href="/borrowings" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>
@endsection