<?php declare(strict_types=1);

namespace Bluezone\Core\Port\Driving\ForConfiguringApp;

use Bluezone\Core\Port\Driven\ForPaying\PayRequest;
use Bluezone\Core\Port\Driven\ForStoringTickets\Ticket;

interface ForConfiguringApp
{
    public function initRateProviderWith(array $rates): void;

    public function createTicket(Ticket $ticket): void;

    public function eraseTicket(string $ticketCode): void;

    public function setNextTicketCodeToReturn(string $ticketCode): void;

    public function getNextTicketCodeToReturn(): string;

    public function getLastPayRequestDone(): PayRequest;

    public function setPaymentErrorPercentage(int $percent): void;
}
