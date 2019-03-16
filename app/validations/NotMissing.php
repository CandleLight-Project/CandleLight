<?php

namespace CandleLight\Validation;

use CandleLight\Validation;


/**
 * Validation fails if the field is not set in the request
 * @package CandleLight\Validation
 */
class NotMissing extends Validation{

    protected function validate(): bool{
        $field = $this->getModel()->{$this->getField()};
        return !isset($field);
    }

    public function getMessage(): string{
        return sprintf('%s needs to be set.', $this->getField());
    }
}

/* @var \CandleLight\App $app */
$app->addValidation('not-missing', NotMissing::class);