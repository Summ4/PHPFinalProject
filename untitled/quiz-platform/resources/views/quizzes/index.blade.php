@extends('layouts.app')

@section('content')
<h1>Quizzes</h1>

@auth
<a href="{{ route('quizzes.create') }}">Create New Quiz</a>
@endauth

@foreach($quizzes as $quiz)
<div>
    <h2>{{ $quiz->name }}</h2>
    <!-- ... existing content ... -->

    @can('update', $quiz)
    <a href="{{ route('quizzes.edit', $quiz->id) }}">Edit</a>
    @endcan

    @can('delete', $quiz)
    <form action="{{ route('quizzes.destroy', $quiz->id) }}" method="POST" style="display:inline;">
        @csrf
        @method('DELETE')
        <button type="submit">Delete</button>
    </form>
    @endcan

    @can('publish', App\Models\Quiz::class)
    @if (!$quiz->published)
    <form action="{{ route('quizzes.publish', $quiz->id) }}" method="POST" style="display:inline;">
        @csrf
        @method('PUT')
        <button type="submit">Publish</button>
    </form>
    @endif
    @endcan
</div>
@endforeach
@endsection
