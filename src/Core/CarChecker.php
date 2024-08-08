<?php declare(strict_types=1);

namespace Bluezone\Core;

use Bluezone\Core\Port\Driven\ForStoringTickets\ForStoringTickets;
use Bluezone\Core\Port\Driving\ForCheckingCars\ForCheckingCars;
use Psr\Clock\ClockInterface;

class CarChecker implements ForCheckingCars
{
    public function __construct(
        private readonly ForStoringTickets $ticketStore,
    ) {
    }

    public function illegallyParkedCar(ClockInterface $clock, string $carPlate, string $rateName): bool
    {
        $ticketsOfCarAndRate = $this->ticketStore->findByCarRateOrderByEndingDateTimeDesc($carPlate, $rateName);
        if ($ticketsOfCarAndRate === []) {
            return true;
        }

        /** TODO: should use clock interface */
        $currentDateTime = new \DateTimeImmutable('now');
        $latestEndingDateTime = $ticketsOfCarAndRate[0]->getEndingDateTime();

        return ($currentDateTime > $latestEndingDateTime);
    }
}
