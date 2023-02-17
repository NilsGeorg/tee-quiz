<?php

namespace Nils\QuizTee\web\dto;

use Nils\QuizTee\exception\BadRequestHttpException;

class AnswerRequest
{
    /**
     * @var int[]
     */
    protected array $positions;

    public function __construct(array $positions)
    {
        $this->positions = $positions;
    }

    /**
     * @return array
     */
    public function getPositions(): array
    {
        return $this->positions;
    }

    /**
     * @param array $positions
     */
    public function setPositions(array $positions): void
    {
        $this->positions = $positions;
    }

    public static function from($data)
    {
        // replace with proper serialisation
        if (!is_array($data)) {
            throw new BadRequestHttpException();
        }

        foreach ($data as $string) {
            if (!is_int($string)) {
                throw new BadRequestHttpException();
            }
        }

        return new AnswerRequest($data);
    }
}
