<?php

namespace CandleLight\Filter;

use CandleLight\Filter;

class GenerateSalt extends Filter{

    public function apply(): void{
        $model = $this->getModel();
        $field = $this->getField();
        $model->{$field} = self::getRandomSalt(32);
    }

    /**
     * Generates a random salt with the given length
     * @param int $length Length of the random salt
     * @return string The generated random salt
     * @throws \Exception
     */
    private static function getRandomSalt(int $length = 32): string{
        return bin2hex(random_bytes($length));
    }
}

/* @var \CandleLight\App $app */
$app->addFilter('generate-salt', GenerateSalt::class);