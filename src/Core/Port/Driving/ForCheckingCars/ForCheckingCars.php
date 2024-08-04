<?php declare(strict_types=1);

namespace Bluezone\Core\Port\Driving\ForCheckingCars;

use Psr\Clock\ClockInterface;

/**
 * DRIVER PORT
 */
interface ForCheckingCars
{
    /**
     * A car is illegally parked at a zone, if the car does not have any valid ticket for the zone rate at the current date-time.
     * A ticket is valid if the given date-time is between the starting and ending date-time of the ticket.
     *
     * @param ClockInterface $clock Clock to get current date-time from
     * @param string $carPlate CarPlate of the car that we want to check
     * @param string $rateName	Rate name of the zone where the car to check is parked at
     * @return bool "true" if the car has no valid ticket for the rate at current date-time,
     * 				"false" otherwise.
     */
    public function illegallyParkedCar(ClockInterface $clock, string $carPlate, string $rateName): bool;
}
