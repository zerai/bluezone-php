<?php declare(strict_types=1);

namespace Bluezone\Core\Port\Driven\ForObtainingRates;

class Rate
{
    public function __construct(
        private readonly string $name,
        private readonly int|float $amountPerHour
    ) {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getAmountPerHour(): int|float
    {
        return $this->amountPerHour;
    }
}
