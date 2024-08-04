<?php declare(strict_types=1);

namespace Bluezone\Core\Port\Driving\ForParkingCars;

use Bluezone\Core\Port\Driven\ForPaying\PayErrorException;
use Bluezone\Core\Port\Driven\ForStoringTickets\Ticket;

/**
 * DRIVER PORT
 */
interface ForParkingCars
{
    /**
     * Returns the available rates in the city, indexed by name.
     *
     * @return array a collection of Rate objects, with the rate name as the key.
     * @see Rate
     */
    public function getAllRatesByName(): array;

    /**
     * It pays for a parking ticket, which will be valid for the following period of time:
     *		- Starting:	Current date-time.
     *		- Ending:	Date-time calculated from the payment amount, according to the rate of the zone the car is parked at.
     * The payment is done by charging the amount to the card given in the purchase ticket request.
     *
     * @throws  PayErrorException
     */
    public function purchaseTicket(PurchaseTicketRequest $purchaseTicketRequest): string;

    /**
     * Given the code of a previously purchased ticket, returns the whole data of the ticket.
     *
     * @param string $ticketCode	Code of a purchased ticket.
     * @return null|Ticket   The ticket with the given ticket code,
     *                  or null if it doesn't exist any ticket with such a code.
     */
    public function getTicket(string $ticketCode): ?Ticket;
}
