<?php

declare(strict_types=1);

use App\Calculator;
use PHPUnit\Framework\TestCase;

class CalculatorTest extends TestCase
{
    /**
     * @dataProvider dataProvider
     */
    public function testCalculate(string $expression, float $expected): void
    {
        $calculator = new Calculator();

        $this->assertEquals($expected, $calculator->calculate($expression));
    }

    /**
     * @return array<string,array<int,mixed>>
     */
    public static function dataProvider(): array
    {
        return [
            '1 + 1' => [
                '1 + 1',
                2,
            ],
            '1 + 2 - 1' => [
                '1 + 2 - 1',
                2,
            ],
        ];
    }
}
