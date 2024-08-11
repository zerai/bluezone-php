<?php declare(strict_types=1);

namespace Bluezone\Core\Port\Driven\ForStoringTickets;

class Ticket
{
    /**
     * @var string Id of the ticket purchasing transaction in the payment service
     */
    public string $paymentId;

    public function __construct(
        /**
         * @var string Unique identifier of the ticket
         */
        private readonly string $code,
        /**
         * @var string Plate of the car that has been parked
         */
        private readonly string $carPlate,
        /**
         * @var string Rate name of the zone where the car is parked at
         */
        private readonly string $rateName,
        /**
         * @var \DateTimeImmutable When the parking period begins
         */
        private readonly \DateTimeImmutable $startingDateTime,
        /**
         * @var \DateTimeImmutable When the parking period expires
         */
        private readonly \DateTimeImmutable $endingDateTime,
        /**
         * @var int Amount of money paid for the ticket
         */
        private readonly int $price
    ) {
    }

    public function getPaymentId(): string
    {
        return $this->paymentId;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function getCarPlate(): string
    {
        return $this->carPlate;
    }

    public function getRateName(): string
    {
        return $this->rateName;
    }

    public function getStartingDateTime(): \DateTimeImmutable
    {
        return $this->startingDateTime;
    }

    public function getEndingDateTime(): \DateTimeImmutable
    {
        return $this->endingDateTime;
    }

    public function getPrice(): int
    {
        return $this->price;
    }
}
