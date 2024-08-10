<?php declare(strict_types=1);

namespace Bluezone\Core\Port\Driven\ForStoringTickets;

/**
 * DRIVEN PORT
 */
interface ForStoringTickets
{
    public function nextCode(): string;

    public function findByCode(string $ticketCode): ?Ticket;

    public function store(Ticket $ticket): void;

    public function findByCarRateOrderByEndingDateTimeDesc(string $carPlate, string $rateName): array;

    public function delete(string $ticketCode): void;

    public function exists(string $ticketCode): bool;

    /**
     * UALFM
     */
    public function setNextCode(string $ticketCode): void;

    /**
     * UALFM
     */
    public function nextAvailableCode(): string;
}
