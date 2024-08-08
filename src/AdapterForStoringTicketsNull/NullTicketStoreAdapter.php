<?php declare(strict_types=1);

namespace Bluezone\AdapterForStoringTicketsNull;

use Bluezone\Core\Port\Driven\ForStoringTickets\ForStoringTickets;
use Bluezone\Core\Port\Driven\ForStoringTickets\Ticket;

class NullTicketStoreAdapter implements ForStoringTickets
{
    public function nextCode(): string
    {
        throw new \RuntimeException('NullTicketStoreAdapter: not implemented method.');
    }

    public function findByCode(string $ticketCode): Ticket
    {
        throw new \RuntimeException('NullTicketStoreAdapter: not implemented method.');
    }

    public function store(Ticket $ticket): void
    {
        throw new \RuntimeException('NullTicketStoreAdapter: not implemented method.');
    }

    public function findByCarRateOrderByEndingDateTimeDesc(string $carPlate, string $rateName): array
    {
        throw new \RuntimeException('NullTicketStoreAdapter: not implemented method.');
    }

    public function delete(string $ticketCode): void
    {
        throw new \RuntimeException('NullTicketStoreAdapter: not implemented method.');
    }

    public function exists(string $ticketCode): bool
    {
        throw new \RuntimeException('NullTicketStoreAdapter: not implemented method.');
    }

    public function setNextCode(string $ticketCode): void
    {
        throw new \RuntimeException('NullTicketStoreAdapter: not implemented method.');
    }

    public function nextAvailableCode(): string
    {
        throw new \RuntimeException('NullTicketStoreAdapter: not implemented method.');
    }
}
