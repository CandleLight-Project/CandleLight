<?php


namespace CandleLight\Validation;

use CandleLight\Calculator;

class PasswordHash extends Calculator{

    private static $defaults = [
        'field' => false,
        'salt' => ''
    ];


    public function apply(): void{
        $atts = $this->parseAttributes(self::$defaults);
        if (!$atts['field'] || empty($atts['salt'])) {
            return;
        }
        $field = $atts['field'];
        $salt = $atts['salt'];
        if ($field && $this->fieldChanged($field)) {
            $this->getModel()->{$this->getField()} = $this->serialize($this->getModel()->{$field}, $this->getModel()->{$salt});
        }
    }

    private function serialize(string $field, $salt): string{
        return password_hash($field, PASSWORD_BCRYPT, [
            'cost' => 12
        ]);
    }
}

/* @var \CandleLight\App $app */
$app->addCalculator('hash-password', PasswordHash::class);