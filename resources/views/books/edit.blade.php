@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-8">
        <h2>Edit Book</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="/books/{{ $book->id }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Title</label>
                <input type="text" name="title" class="form-control" value="{{ $book->title }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Author</label>
                <input type="text" name="author" class="form-control" value="{{ $book->author }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Price (Rs.)</label>
                <input type="number" name="price" class="form-control" step="0.01" value="{{ old('price', $book->price) }}" required>
                @error('price')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Stock</label>
                <input type="number" name="stock" class="form-control" value="{{ $book->stock }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Category</label>
                <select name="book_category_id" class="form-control" required>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" @selected($book->book_category_id == $category->id)>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-success">Update Book</button>
            <a href="/books" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>
@endsection