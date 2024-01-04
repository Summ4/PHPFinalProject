@extends('layouts.app')

@section('content')
<h1>Edit Quiz</h1>

@auth
<form action="{{ route('quizzes.update', $quiz=>id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <label for="name">Quiz Name:</label>
    <input type="text" name="name" id="name" value="{{ old('name', $quiz=>name) }}" required>

    <label for="description">Description:</label>
    <textarea name="description" id="description" rows="4" required>{{ old('description', $quiz->description) }}</textarea>

    <label for="main_photo">Main Photo:</label>
    <input type="file" name="main_photo" id="main_photo">

    <button type="submit">Update Quiz</button>
</form>
@else
<p>You need to be logged in to edit this quiz. <a href="{{ route('login') }}">Login</a></p>
@endauth

<a href="{{ route('quizzes.index') }}">Back to Quizzes</a>
@endsection
