<?php

declare(strict_types=1);

namespace App;

use SplStack;

class Calculator
{
    private SplStack $operandStack;
    private SplStack $operatorStack;
    private array $operations;

    public function __construct()
    {
        $this->operandStack = new SplStack();
        $this->operatorStack = new SplStack();
        $this->operations = [
            '+' => fn (float $a, float $b) => $a + $b,
            '-' => fn (float $a, float $b) => $a - $b,
        ];
    }

    public function calculate(string $expression): float
    {
        $tokens = str_split(str_replace(' ', '', $expression));
        $tokens[] = PHP_EOL;

        foreach ($tokens as $token) {
            $this->handleToken($token);
        }

        return $this->operandStack->pop();
    }

    private function handleToken(string $token): void
    {
        switch ($token) {
            case is_numeric($token):
                $this->operandStack->push((float) $token);
                break;
            case $this->isOperation($token):
                $this->operatorStack->push($token);
                break;
            case $token === PHP_EOL:
                if ($this->operatorStack->isEmpty()) {
                    break;
                }

                $this->operandStack->push($this->calculateLastOperation());
                $this->handleToken($token);

                break;
        }
    }

    private function isOperation(string $token): bool
    {
        return array_key_exists($token, $this->operations);
    }

    private function calculateLastOperation(): float {
        $a = $this->operandStack->pop();
        $b = $this->operandStack->pop();
        $operation = $this->operatorStack->pop();

        return $this->operations[$operation]($b, $a);
    }
}
