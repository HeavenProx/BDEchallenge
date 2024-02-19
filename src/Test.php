<?php

namespace App;

class Test
{
    public function __construct(
        private string $test
    ) {
    }

    public function getTest()
    {
        return $this->test;
    }
    public function setTest($test): self
    {
        $this->test = $test;
        return $this;
    }
}
