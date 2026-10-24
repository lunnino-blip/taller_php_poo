<?php

class Node
{
    public string $value;
    public ?Node $left = null;
    public ?Node $right = null;

    public function __construct(string $value)
    {
        $this->value = trim($value);
    }
}