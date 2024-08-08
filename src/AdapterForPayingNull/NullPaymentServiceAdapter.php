<?php declare(strict_types=1);

namespace Bluezone\AdapterForPayingNull;

use Bluezone\Core\Port\Driven\ForPaying\ForPaying;
use Bluezone\Core\Port\Driven\ForPaying\PayRequest;

class NullPaymentServiceAdapter implements ForPaying
{
    public function pay(PayRequest $payRequest): void
    {
        throw new \RuntimeException('NullPaymentServiceAdapter::pay() not implemented method.');
    }

    public function setPayErrorGenerationPercentage(int $percent): void
    {
        throw new \RuntimeException('NullPaymentServiceAdapter::setPayErrorGenerationPercentage() not implemented method.');
    }
}
