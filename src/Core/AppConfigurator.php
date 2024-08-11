<?php declare(strict_types=1);

namespace Bluezone\Core;

use Bluezone\Core\Port\Driven\ForObtainingRates\ForObtainingRates;
use Bluezone\Core\Port\Driven\ForObtainingRates\Rate;
use Bluezone\Core\Port\Driven\ForPaying\ForPaying;
use Bluezone\Core\Port\Driven\ForPaying\PayRequest;
use Bluezone\Core\Port\Driven\ForStoringTickets\ForStoringTickets;
use Bluezone\Core\Port\Driven\ForStoringTickets\Ticket;
use Bluezone\Core\Port\Driving\ForConfiguringApp\ForConfiguringApp;

class AppConfigurator implements ForConfiguringApp
{
    public function __construct(
        private readonly ForObtainingRates $rateProvider,
        private readonly ForStoringTickets $ticketStore,
        private readonly ForPaying $paymentService,
    ) {
    }

    public function initRateProviderWith(array $rates): void
    {
        $this->rateProvider->empty();
        /** @var Rate $rate */
        foreach ($rates as $rate) {
            if (! $this->rateProvider->exists($rate->getName())) {
                $this->rateProvider->addRate($rate);
            }
        }

    }

    public function createTicket(Ticket $ticket): void
    {
        if (! $this->ticketStore->exists($ticket->getCode())) {
            $this->ticketStore->store($ticket);
        }
    }

    public function eraseTicket(string $ticketCode): void
    {
        if ($this->ticketStore->exists($ticketCode)) {
            $this->ticketStore->delete($ticketCode);
        }
    }

    public function setNextTicketCodeToReturn(string $ticketCode): void
    {
        $this->ticketStore->setNextCode($ticketCode);
    }

    public function getNextTicketCodeToReturn(): string
    {
        return $this->ticketStore->nextAvailableCode();
    }

    public function getLastPayRequestDone(): PayRequest
    {
        return $this->paymentService->lastPayRequest();
    }

    public function setPaymentErrorPercentage(int $percent): void
    {
        $this->paymentService->setPayErrorGenerationPercentage($percent);
    }
}
