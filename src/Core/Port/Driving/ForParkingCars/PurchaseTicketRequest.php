<?php declare(strict_types=1);

namespace Bluezone\Core\Port\Driving\ForParkingCars;

use Psr\Clock\ClockInterface;

/**
 * DTO with the data needed for purchasing a parking ticket:
 * 		carPlate			Plate of the car to be parked
 * 		rateName			Rate name of the zone where the car will be parked at
 *		clock				A clock to get current date-time from, since it will be the starting date-time of the ticket period
 * 		amount				Money (euros) to be paid for the parking ticket
 * 		paymentCard			Number of the card where the amount will be charged
 */
class PurchaseTicketRequest
{
    public string $carPlate;

    public string $rateName;

    public ClockInterface $clock;

    public int $amount;

    public string $paymentCard;
}
