<?php declare(strict_types=1);

namespace Bluezone\Core\Port\Driven\ForStoringTickets;

class Ticket
{
    /**
     * @var string Unique identifier of the ticket
     */
    public string $code;

    /**
     * @var string Plate of the car that has been parked
     */
    public string $carPlate;

    /**
     * @var string Rate name of the zone where the car is parked at
     */
    public string $rateName;

    /**
     * @var \DateTimeImmutable When the parking period begins
     */
    public \DateTimeImmutable $startingDateTime;

    /**
     * @var \DateTimeImmutable When the parking period expires
     */
    public \DateTimeImmutable $endingDateTime;

    /**
     * @var int Amount of money paid for the ticket
     */
    public int $price;

    /**
     * @var string Id of the ticket purchasing transaction in the payment service
     */
    public string $paymentId;
}
