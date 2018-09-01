<?php


namespace CandleLight\Validation;

use CandleLight\Calculator;

class SerializeField extends Calculator{

    private static $defaults = [
        'field' => false
    ];

    public function apply(){
        $atts = $this->parseAttributes(self::$defaults);
        if (!$atts['field']){
            return;
        }
        $field = $atts['field'];
        if ($field && $this->fieldChanged($field)) {
            $this->getModel()->{$this->getField()} = $this->serialize($this->getModel()->{$field});
        }
    }

    private function serialize(string $field): string{
        $field = urlencode($field);
        return $field;
    }
}

/* @var \CandleLight\App $app */
$app->addCalculator('serialize-field', SerializeField::class);