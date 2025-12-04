@extends('layouts.app')

@section('content')
<!-- Page Header -->
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h1>Books Library</h1>
        <p>Manage and organize your book collection</p>
    </div>
    <a href="/books/create" class="btn btn-primary btn-lg">
        <i class="bi bi-plus-circle"></i> Add New Book
    </a>
</div>

<!-- Filter Section -->
<div class="row mb-4">
    <div class="col-lg-3">
        <div class="card">
            <div class="card-body">
                <label class="form-label">Filter by Category</label>
                <form method="GET" action="/books">
                    <select name="category" class="form-select" onchange="this.form.submit()">
                        <option value="">All Categories</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" @selected(request('category') == $category->id)>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Books Table -->
@if($books->isEmpty())
    <div class="empty-state">
        <i class="bi bi-inbox"></i>
        <h3>No Books Found</h3>
        <p>
            @if(request('category'))
                No books in this category. Try selecting a different category.
            @else
                Your book library is empty. Get started by adding your first book.
            @endif
        </p>
        <a href="/books/create" class="btn btn-primary" style="font-size: 0.95rem; padding: 0.5rem 1rem;">
            <i class="bi bi-plus-circle" style="font-size: 0.9rem; margin-right: 0.4rem;"></i> Add First Book
        </a>
    </div>
@else
    <div class="card">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Category</th>
                        <th style="text-align: center;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($books as $book)
                        <tr>
                            <td>
                                <span style="font-weight: 600; color: var(--primary-color);">{{ $book->id }}</span>
                            </td>
                            <td>
                                <strong>{{ $book->title }}</strong>
                            </td>
                            <td>{{ $book->author }}</td>
                            <td>
                                <span style="font-weight: 600; color: var(--secondary-color);">
                                    Rs. {{ number_format($book->price, 2) }}
                                </span>
                            </td>
                            <td>
                                @if ($book->stock > 5)
                                    <span class="badge badge-success">
                                        <i class="bi bi-check-circle"></i> {{ $book->stock }} in stock
                                    </span>
                                @elseif ($book->stock > 0)
                                    <span class="badge badge-warning">
                                        <i class="bi bi-exclamation-circle"></i> {{ $book->stock }} left
                                    </span>
                                @else
                                    <span class="badge badge-danger">
                                        <i class="bi bi-x-circle"></i> Out of Stock
                                    </span>
                                @endif
                            </td>
                            <td>
                                <span class="badge badge-info">{{ $book->category->name }}</span>
                            </td>
                            <td style="text-align: center;">
                                <div class="d-flex gap-2 justify-content-center flex-nowrap">
                                    <a href="/books/{{ $book->id }}/edit" class="btn btn-warning btn-sm" title="Edit Book">
                                        <i class="bi bi-pencil"></i> Edit
                                    </a>
                                    <button type="button" class="btn btn-danger btn-sm" title="Delete Book"
                                            onclick="confirmDelete('{{ $book->id }}', '{{ addslashes($book->title) }}')">
                                        <i class="bi bi-trash"></i> Delete
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Delete Form (Hidden) -->
    <form id="deleteForm" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>

    <script>
        function confirmDelete(bookId, bookTitle) {
            if (confirm(`Are you sure you want to delete "${bookTitle}"?\n\nThis action cannot be undone.`)) {
                document.getElementById('deleteForm').action = `/books/${bookId}`;
                document.getElementById('deleteForm').submit();
            }
        }
    </script>
@endif
@endsection