@extends('layouts.app')

@section('content')
<h1>Create New Question</h1>

<form action="{{ route('questions.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <label for="quiz_id">Quiz:</label>
    <select name="quiz_id" id="quiz_id">
        @foreach($quizzes as $quiz)
        <option value="{{ $quiz->id }}">{{ $quiz->name }}</option>
        @endforeach
    </select>

    <label for="question_text">Question Text:</label>
    <textarea name="question_text" id="question_text" rows="4"></textarea>

    <label for="photo">Photo:</label>
    <input type="file" name="photo" id="photo">

    <label for="position">Position:</label>
    <input type="number" name="position" id="position">

    <button type="submit">Create Question</button>
</form>

<a href="{{ route('questions.index') }}">Back to Questions</a>
@endsection
