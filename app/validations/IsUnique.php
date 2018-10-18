<?php

namespace CandleLight\Validation;

use CandleLight\Validation;

/**
 * Validation fails if the there is no other model in the database with the same field value
 * @package CandleLight\Validation
 */
class IsUnique extends Validation{

    protected function validate(): bool{
        $field = $this->getField();
        $value = $this->getModel()->{$field};

        $query = $this->getModel()->newInstance();
        $query = $query->where($field, $value)->get()->toArray();
        return count($query) > 0;
    }

    public function getMessage(): string{
        $field = $this->getField();
        $value = $this->getModel()->{$field};
        return sprintf('%s needs to be unique and the value %s is already in use.', $field, $value);
    }
}

/* @var \CandleLight\App $app */
$app->addValidation('is-unique', IsUnique::class);