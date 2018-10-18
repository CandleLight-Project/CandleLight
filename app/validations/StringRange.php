<?php

namespace CandleLight\Validation;

use CandleLight\Validation;

/**
 * Validation fails if the field string length is not in the given range
 * @package CandleLight\Validation
 */
class StringRange extends Validation{

    private static $defaults = [
        'min' => 0,
        'max' => PHP_INT_MAX
    ];

    protected function validate(): bool{
        $field = $this->getModel()->{$this->getField()};
        $atts = $this->parseAttributes(self::$defaults);
        if (strlen($field) < $atts['min']) {
            return true;
        }
        if (isset($values[1]) && strlen($field) > $atts['max']) {
            return true;
        }
        return false;
    }

    public function getMessage(): string{
        $atts = $this->parseAttributes(self::$defaults);
        return sprintf('%s needs to be between %d and %d digits long.', $this->getField(), $atts['min'], $atts['max']);
    }
}

/* @var \CandleLight\App $app */
$app->addValidation('range', StringRange::class);