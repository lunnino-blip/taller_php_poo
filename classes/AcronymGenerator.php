<?php

class AcronymGenerator
{
    private string $text;

    public function __construct(string $text)
    {
        $this->text = $text;
    }

    public function generate(): string
    {
        
        $cleanText = str_replace('-', ' ', $this->text);
        $cleanText = preg_replace('/[^\p{L}\s]/u', '', $cleanText);
        $words = preg_split('/\s+/', trim($cleanText));

        $acronym = '';

        foreach ($words as $word) {
            if (!empty($word)) {
                
                $acronym .= mb_substr($word, 0, 1, 'UTF-8');
            }
        }


        return mb_strtoupper($acronym, 'UTF-8');
    }
}