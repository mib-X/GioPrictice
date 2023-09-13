<?php

namespace App\Controllers;

use Generator;

class GeneratorController
{
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
