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
        $questionMock = $this->createMock(QuestionRepository::class);
        $sessionStorageMock = $this->createMock(SessionStorage::class);

        $questionEntityMock = new QuestionEntity();

        $questionMock->expects($this->once())->method('findFirst')->willReturn($questionEntityMock);
        $sessionStorageMock->expects($this->once())->method('resetQuiz')->willReturn(true);

        $questionService = new QuestionService($questionMock, $sessionStorageMock);

        $question = $questionService->start();

        $this->assertEquals($question, $questionEntityMock);
    }

    public function testAnswer(): void
    {
        $questionMock = $this->createMock(QuestionRepository::class);
        $sessionStorageMock = $this->createMock(SessionStorage::class);

        $sessionStorageMock
            ->expects($this->once())
            ->method('getCurrentQuestionNumber')
            ->willReturn(1);
        $sessionStorageMock
            ->expects($this->once())
            ->method('addAnswer');

        $questionService = new QuestionService($questionMock, $sessionStorageMock);

        $questionService->answer(array('123', '456'));
    }

    public function testGetNextQuestionNumberWithoutOrder(): void
    {
        $questionMock = $this->createMock(QuestionRepository::class);
        $sessionStorageMock = $this->createMock(SessionStorage::class);
        $questionEntityMock = new QuestionEntity('test', array(), 1);

        $sessionStorageMock
            ->expects($this->once())
            ->method('getCurrentQuestionNumber')
            ->willReturn(null);
        $questionMock
            ->expects($this->once())
            ->method('findFirst')
            ->willReturn($questionEntityMock);

        $questionService = new QuestionService($questionMock, $sessionStorageMock);

        $question = $questionService->getNextQuestion();

        $this->assertEquals($question, $questionEntityMock);
    }

    public function testGetNextQuestionNumberWithOrder(): void
    {
        $questionMock = $this->createMock(QuestionRepository::class);
        $sessionStorageMock = $this->createMock(SessionStorage::class);
        $questionEntityMock = new QuestionEntity('test', array(), 1);

        $sessionStorageMock
            ->expects($this->once())
            ->method('getCurrentQuestionNumber')
            ->willReturn(1);
        $questionMock
            ->expects($this->once())
            ->method('findNext')
            ->with(1)
            ->willReturn($questionEntityMock);

        $questionService = new QuestionService($questionMock, $sessionStorageMock);

        $question = $questionService->getNextQuestion();

        $this->assertEquals($question, $questionEntityMock);
    }

    public function testGetNextQuestionNumberNotFound(): void
    {
        $questionMock = $this->createMock(QuestionRepository::class);
        $sessionStorageMock = $this->createMock(SessionStorage::class);

        $sessionStorageMock
            ->expects($this->once())
            ->method('getCurrentQuestionNumber')
            ->willReturn(1);
        $questionMock
            ->expects($this->once())
            ->method('findNext')
            ->with(1)
            ->willReturn(null);

        $questionService = new QuestionService($questionMock, $sessionStorageMock);

        $question = $questionService->getNextQuestion();

        $this->assertNull($question);
    }
}