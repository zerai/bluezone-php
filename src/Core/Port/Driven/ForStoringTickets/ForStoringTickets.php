<?php declare(strict_types=1);

namespace Bluezone\Core\Port\Driven\ForStoringTickets;

/**
 * DRIVEN PORT
 */
interface ForStoringTickets
{
    public function nextCode(): string;

    public function findByCode(string $ticketCode): Ticket;
}
