<?php declare(strict_types=1);

namespace Bluezone\AdapterForObtainingRatesStub;

use Bluezone\Core\Port\Driven\ForObtainingRates\ForObtainingRates;
use Bluezone\Core\Port\Driven\ForObtainingRates\Rate;
use RuntimeException;

class StubRateProviderAdapter implements ForObtainingRates
{
    public function __construct(
        private array $rates = [],
    ) {
    }

    public function findAll(): array
    {
        return $this->rates;
    }

    public function findByName(string $rateName): Rate
    {
        $occurrences = 0;
        $rateFound = null;
        /** @var Rate $rate */
        foreach ($this->rates as $rate) {
            if ($rate->name === $rateName) {
                $rateFound = $rate;
                $occurrences++;
            }
        }
        if ($occurrences === 0) {
            throw new RuntimeException("StubRateProviderAdapter: No rate found with name = " . $rateName);
        }
        if ($occurrences > 1) {
            throw new RuntimeException("StubRateProviderAdapter: Multiple rates found with name = " . $rateName);
        }
        return $rateFound;
    }

    public function addRate(Rate $rate): void
    {
        if ($this->exists($rate->name)) {
            throw new RuntimeException("Cannot add rate to repository. Rate name '" . $rate->name . "' already exists.");
        }
        $this->rates[] = $rate;
    }

    public function exists(string $rateName): bool
    {
        $result = false;
        /** @var Rate $rate */
        foreach ($this->rates as $rate) {
            if ($rate->name === $rateName) {
                $result = true;
            }
        }
        return $result;
    }

    public function empty(): void
    {
        $this->rates = [];
    }
}
