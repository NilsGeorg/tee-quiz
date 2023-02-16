<?php

namespace Nils\QuizTee\util;

/**
 * While rereading this I should have saved the Question ID instead of the order number
 */
class SessionStorage
{
    // could be configurable - will be replaced by database
    private const LAST_QUESTION_ORDER = 'LAST_QUESTION_ORDER';
    private const ANSWER = 'ANSWER';

    private const FILENAME = 'session_storage';

    private array $SESSION;

    private StorageService $storageService;

    public function __construct()
    {
//        $this->storageService = new StorageService();

//        $this->SESSION = $this->storageService->load(self::FILENAME);
    }

    public function resetQuiz(): bool
    {
        unset($this->SESSION[self::LAST_QUESTION_ORDER]);
        unset($this->SESSION[self::ANSWER]);

        return true;
    }

    /**
     * @param int $order
     * @param string[] $answers
     * @return void
     */
    public function addAnswer(int $order, array $answers)
    {
        if (!$this->exists(self::ANSWER)) {
            $this->addValue(self::ANSWER, array());
        }

        $currentAnswers = $this->getValue(self::ANSWER);
        $currentAnswers[$order] = $answers;
        $this->addValue(self::ANSWER, $currentAnswers);
    }

    public function setCurrentQuestionNumber(int $order)
    {
        $this->addValue(self::LAST_QUESTION_ORDER, $order);
    }

    public function getCurrentQuestionNumber(): ?int
    {
        return $this->getValue(self::LAST_QUESTION_ORDER);
    }

    private function addValue(string $key, $value)
    {
        $this->SESSION[$_SESSION['TOKEN']][$key] = $value;
        $this->storageService->save(self::FILENAME, $this->SESSION);
    }

    private function getValue(string $key)
    {
        return $this->SESSION[$_SESSION['TOKEN']][$key];
    }

    private function exists(string $key)
    {
        return array_key_exists($key, $this->SESSION[$_SESSION['TOKEN']]);
    }
}
