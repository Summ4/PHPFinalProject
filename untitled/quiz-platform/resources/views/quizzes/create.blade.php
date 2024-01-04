@extends('layouts.app')

@section('content')
<h1>Create New Quiz</h1>

@auth
<form action="{{ route('quizzes.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <label for="name">Quiz Name:</label>
    <input type="text" name="name" id="name" value="{{ old('name') }}" required>

    <label for="description">Description:</label>
    <textarea name="description" id="description" rows="4" required>{{ old('description') }}</textarea>

    <label for="main_photo">Main Photo:</label>
    <input type="file" name="main_photo" id="main_photo">

    <button type="submit">Create Quiz</button>
</form>
@else
<p>You need to be logged in to create a quiz. <a href="{{ route('login') }}">Login</a></p>
@endauth

<a href="{{ route('quizzes.index') }}">Back to Quizzes</a>
@endsection
