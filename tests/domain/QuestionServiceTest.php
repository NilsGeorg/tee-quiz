<?php

namespace domain;

use Nils\QuizTee\domain\QuestionService;
use Nils\QuizTee\persistence\entity\QuestionEntity;
use Nils\QuizTee\persistence\repository\QuestionRepository;
use Nils\QuizTee\util\SessionStorage;
use PHPUnit\Framework\TestCase;

class QuestionServiceTest extends TestCase
{

    public function testStart(): void
    {
        $questionMock = $this->getQuestionRepositoryMock();
        $sessionStorageMock = $this->getSessionStorageMock();

        $questionEntityMock = new QuestionEntity('test', array(), 1);

        $questionMock->expects($this->once())->method('findFirstQuestion')->willReturn($questionEntityMock);
        $sessionStorageMock->expects($this->once())->method('resetQuiz')->willReturn(true);

        $questionService = new QuestionService($questionMock, $sessionStorageMock);

        $question = $questionService->start();

        $this->assertEquals($question, $questionEntityMock);
    }

    private function getQuestionRepositoryMock()
    {
        return $this->createMock(QuestionRepository::class);
    }

    private function getSessionStorageMock()
    {
        return $this->createMock(SessionStorage::class);
    }
}