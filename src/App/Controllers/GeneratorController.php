<?php

namespace App\Controllers;

use App\Attributes\Get;
use App\Attributes\Route;
use Generator;

class GeneratorController
{
    #[Get('/generator')]
    public function index()
    {
        $generator = $this->lazyrange(1, 15);
        foreach ($generator as $item => $value) {
            echo $item . " * " . $item . " = " . $value . "<br>";
        }
    }
    private function lazyrange(int $start, int $end): Generator
    {
        for ($i = $start; $i <= $end; $i++) {
            yield $i => $i * $i;
        }
    }
}
