<?php

namespace Nils\QuizTee\web;

abstract class AbstractResponse implements \JsonSerializable
{
    public function jsonSerialize()
    {
        // this is some kind of lazy shortcut for quick transformation
        return get_object_vars($this);
    }
}