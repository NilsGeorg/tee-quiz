<?php

namespace Nils\QuizTee\util;

class StorageService
{
    private string $filePath = './storage/';

    public function save(string $fileName, array $data)
    {
//        file_put_contents($this->filePath . $fileName . '.json', serialize($data));
    }

    public function load(string $fileName)
    {
//        $content = file_get_contents($this->filePath . $fileName . '.json');

//        if ($content === false) {
//            return array();
//        } else {
//            return unserialize($content);
//        }
    }
}