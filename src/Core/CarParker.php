<?php declare(strict_types=1);

namespace Bluezone\Core;

use Bluezone\Core\Port\Driven\ForObtainingRates\ForObtainingRates;
use Bluezone\Core\Port\Driven\ForPaying\ForPaying;
use Bluezone\Core\Port\Driven\ForPaying\PayRequest;
use Bluezone\Core\Port\Driven\ForStoringTickets\ForStoringTickets;
use Bluezone\Core\Port\Driven\ForStoringTickets\Ticket;
use Bluezone\Core\Port\Driving\ForParkingCars\ForParkingCars;
use Bluezone\Core\Port\Driving\ForParkingCars\PurchaseTicketRequest;

class CarParker implements ForParkingCars
{
    public function __construct(
        private readonly ForObtainingRates $rateProvider,
        private readonly ForStoringTickets $ticketStore,
        private readonly ForPaying $paymentService,
    ) {
    }

    public function getAllRatesByName(): array
    {
        $allRatesByName = [];
        $allRates = $this->rateProvider->findAll();

        foreach ($allRates as $rate) {
            $allRatesByName[$rate->getName()] = $rate;
        }

        return $allRatesByName;
    }

    public function purchaseTicket(PurchaseTicketRequest $purchaseTicketRequest): string
    {
        // Pay
        $ticketCode = $this->ticketStore->nextCode();
        $paymentCard = $purchaseTicketRequest->paymentCard;
        $moneyToPay = $purchaseTicketRequest->amount;

        $payRequest = new PayRequest($ticketCode, $paymentCard, $moneyToPay);
        $this->paymentService->pay($payRequest);

        // Calc ending date-time
        $rateName = $purchaseTicketRequest->rateName;
        $rate = $this->rateProvider->findByName($rateName);
        /** TODO: IMPLEMENT RateCalculator::class */
        $rateCalculator = new RateCalculator($rate);
        /** TODO: should use clock interface */
        $starting = new \DateTimeImmutable('now');
        $ending = $rateCalculator->getUntilGivenAmount($starting, $moneyToPay);

        //store
        $carPlate = $purchaseTicketRequest->carPlate;
        /** TODO: IMPLEMENT Ticket::__construct() */
        $ticket = new Ticket($ticketCode, $carPlate, $rateName, $starting, $ending, $moneyToPay);
        $this->ticketStore->store($ticket);

        return $ticketCode;
    }

    public function getTicket(string $ticketCode): ?Ticket
    {
        return $this->ticketStore->findByCode($ticketCode);
    }
}
