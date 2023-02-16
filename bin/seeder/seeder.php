<?php

use Nils\QuizTee\persistence\entity\AnswerEntity;
use Nils\QuizTee\persistence\entity\QuestionEntity;

require './bootstrap.php';

$dataBaseJson = file_get_contents('./bin/seeder/seed.json');

$seeds = json_decode($dataBaseJson, true);

$questionCounter = 0;
foreach ($seeds as $seed) {
    $rawQuestion = $seed['question'];
    $rawAnswers = $seed['answers'];

    $question = new QuestionEntity();
    $question->setQuestion($rawQuestion);
    $question->setOrderIndex(++$questionCounter);
    $entityManager->persist($question);

    $answerIndex = 0;
    foreach ($rawAnswers as $rawAnswer) {
        $answer = new AnswerEntity();
        $answer->setQuestion($question);
        $answer->setIsCorrect($rawAnswer['isCorrect']);
        $answer->setAnswer($rawAnswer['answer']);
        $answer->setOrderIndex(++$answerIndex);

        $entityManager->persist($answer);
    }
}

$entityManager->flush();
