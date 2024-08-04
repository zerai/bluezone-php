<?php declare(strict_types=1);

namespace Bluezone\Core\Port\Driven\ForPaying;

/**
 * DRIVEN PORT
 */
interface ForPaying
{
    /**
     * @throws PayErrorException
     */
    public function pay(PayRequest $payRequest): void;

    public function setPayErrorGenerationPercentage(int $percent): void;
}
