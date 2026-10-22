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
        // 1. Reemplazar guiones por espacios
        $cleanText = str_replace('-', ' ', $this->text);

        // 2. Eliminar puntuación (deja solo letras, números y espacios)
        $cleanText = preg_replace('/[^\p{L}\s]/u', '', $cleanText);

        // 3. Dividir la frase en palabras separadas por uno o más espacios
        $words = preg_split('/\s+/', trim($cleanText));

        $acronym = '';

        // 4. Extraer la primera letra de cada palabra
        foreach ($words as $word) {
            if (!empty($word)) {
                // mb_substr asegura el manejo correcto de caracteres con acento o especiales
                $acronym .= mb_substr($word, 0, 1, 'UTF-8');
            }
        }

        // 5. Convertir todo el acrónimo a mayúsculas
        return mb_strtoupper($acronym, 'UTF-8');
    }
}