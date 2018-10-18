<?php

namespace CandleLight\Validation;

use CandleLight\Validation;

/**
 * Validation fails if the field string is not a valid E-Mail
 * @package CandleLight\Validation
 */
class IsEmail extends Validation{

    protected function validate(): bool{
        $field = $this->getModel()->{$this->getField()};
        return !filter_var($field, FILTER_VALIDATE_EMAIL);
    }

    public function getMessage(): string{
        return sprintf('%s needs to be a valid E-Mail address.', $this->getField());
    }
}

/* @var \CandleLight\App $app */
$app->addValidation('is-email', IsEmail::class);