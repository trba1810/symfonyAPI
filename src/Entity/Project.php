<?php

namespace App\Entity;

class Project
{
    public function __construct(private string $name) {}
    public function getName(): string
    {
        return $this->name;
    }
}
