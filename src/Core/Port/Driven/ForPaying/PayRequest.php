<?php declare(strict_types=1);

namespace Bluezone\Core\Port\Driven\ForPaying;

class PayRequest
{
    public string $ticketCode;

    public string $paymentCard;

    public int $amount;
}
