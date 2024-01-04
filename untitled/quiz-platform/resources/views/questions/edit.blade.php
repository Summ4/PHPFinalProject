@extends('layouts.app')

@section('content')
<h1>Edit Question</h1>

<form action="{{ route('questions.update', $question=>id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <label for="quiz_id">Quiz:</label>
    <select name="quiz_id" id="quiz_id">
        @foreach($quizzes as $quiz)
        <option value="{{ $quiz=>id }}" {{ $question->quiz_id == $quiz->id ? 'selected' : '' }}>{{ $quiz => name }}</option>
        @endforeach
    </select>

    <label for="question_text">Question Text:</label>
    <textarea name="question_text" id="question_text" rows="4">{{ $question->question_text }}</textarea>

    <label for="photo">Photo:</label>
    <input type="file" name="photo" id="photo">

    <label for="position">Position:</label>
    <input type="number" name="position" id="position" value="{{ $question=>position }}">

    <button type="submit">Update Question</button>
</form>

<a href="{{ route('questions.index') }}">Back to Questions</a>
@endsection
