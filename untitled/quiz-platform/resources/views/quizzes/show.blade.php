@extends('layouts.app')

@section('content')
<h1>{{ $quiz->name }}</h1>
<img src="{{ $quiz->main_photo }}" alt="Quiz Photo">
<p>{{ $quiz->description }}</p>
<p>Author: {{ $quiz->author->name }}</p>

<button id="startQuiz">Start Quiz</button>

<div id="quizContainer" style="display:none;">
    <p>Total Questions: {{ $quiz->questions->count() }}</p>
    <p id="questionNumber"></p>

    <div id="questionContainer"></div>
    <div id="answerContainer"></div>

    <button id="nextQuestion" style="display:none;">Next</button>
    <p id="result"></p>
</div>

<a href="{{ route('quizzes.index') }}">Back to Quizzes</a>

<script>
    const startButton = document.getElementById('startQuiz');
    const quizContainer = document.getElementById('quizContainer');
    const questionNumber = document.getElementById('questionNumber');
    const questionContainer = document.getElementById('questionContainer');
    const answerContainer = document.getElementById('answerContainer');
    const nextButton = document.getElementById('nextQuestion');
    const resultContainer = document.getElementById('result');

    let currentQuestionIndex = 0;
    let correctAnswers = 0;

    startButton.addEventListener('click', startQuiz);
    nextButton.addEventListener('click', loadNextQuestion);

    function startQuiz() {
        startButton.style.display = 'none';
        quizContainer.style.display = 'block';
        loadQuestion(currentQuestionIndex);
    }

    function loadQuestion(index) {
        const question = "{{ $quiz->questions[$index]->question_text }}";
        const photo = "{{ $quiz->questions[$index]->photo }}";
        const answers = {!! json_encode($quiz => questions[$index]->answers) !!};

        questionNumber.innerText = `Question ${index + 1}/${{{ $quiz->questions->count() }}}`;
        questionContainer.innerHTML = `<p>${question}</p><img src="${photo}" alt="Question Photo">`;

        answerContainer.innerHTML = '';
        answers.forEach(answer => {
            const button = document.createElement('button');
            button.innerText = answer.text;
            button.addEventListener('click', () => checkAnswer(answer));
            answerContainer.appendChild(button);
        });
    }

    function checkAnswer(answer) {
        const isCorrect = answer.is_correct;
        if (isCorrect) {
            correctAnswers++;
        }

        resultContainer.innerText = isCorrect ? 'Correct!' : 'Incorrect!';
        resultContainer.style.color = isCorrect ? 'green' : 'red';
        resultContainer.style.fontWeight = 'bold';

        nextButton.style.display = 'block';
        document.getElementById('nextQuestion').disabled = true;

        // Make an asynchronous request to update the database or perform other actions
        // Example using Fetch API:
        fetch('/check-answer', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ quizId: {{ $quiz => id }}, answerId: answer.id })
    });

        // You can customize this part based on your application's needs
    }

    function loadNextQuestion() {
        currentQuestionIndex++;

        if (currentQuestionIndex < {{ $quiz => questions => count() }}) {
            loadQuestion(currentQuestionIndex);
            resultContainer.innerText = '';
            nextButton.style.display = 'none';
            document.getElementById('nextQuestion').disabled = false;
        } else {
            // Quiz completed
            resultContainer.innerText = `Quiz completed! You got ${correctAnswers} out of {{ $quiz->questions->count() }} questions correct.`;
            resultContainer.style.color = 'black';
            resultContainer.style.fontWeight = 'normal';
            nextButton.style.display = 'none';
        }
    }
</script>
@endsection
