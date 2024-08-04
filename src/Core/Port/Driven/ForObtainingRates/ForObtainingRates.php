<?php declare(strict_types=1);

namespace Bluezone\Core\Port\Driven\ForObtainingRates;

/**
 * DRIVEN PORT
 */
interface ForObtainingRates
{
    public function findAll(): array;

    public function findByName(string $rateName): Rate;

    public function addRate(Rate $rate): void;

    public function exists(string $rateName): bool;

    /**
     * UALFM
     */
    public function empty(): void;
}
