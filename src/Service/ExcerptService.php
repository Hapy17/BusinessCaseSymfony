<?php

namespace App\Service;

class ExcerptService
{

    public function excerpt(string $text, int $length = 20): string
    {
        if(strlen($text) <= $length) return $text;
        return substr($text, 0, $length) . '...';
    }
}