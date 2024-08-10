<?php declare(strict_types=1);

namespace Bluezone\AdapterForStoringTicketsFake;

use Bluezone\Core\Port\Driven\ForStoringTickets\ForStoringTickets;
use Bluezone\Core\Port\Driven\ForStoringTickets\Ticket;

class FakeAdapterForStoringTickets implements ForStoringTickets
{
    private const MAX_TICKET_CODE_LENGTH = 10;

    private string $counter = '';

    public function __construct(
        private array $ticketsByCode = []
    ) {
        $this->setNextCode('1');
    }

    public function nextCode(): string
    {
        $currentTicketAndIncrement = (int) $this->counter;
        $currentTicketAndIncrement++;
        $this->counter = (string) $currentTicketAndIncrement;
        return $this->leftPaddedTicketCode($this->counter);
    }

    public function findByCode(string $ticketCode): ?Ticket
    {
        if (! $this->exists($ticketCode)) {
            return null;
        }
        return $this->ticketsByCode[$ticketCode];
    }

    public function store(Ticket $ticket): void
    {
        if ($this->exists($ticket->code)) {
            throw new \RuntimeException("Cannot store ticket. Code '" . $ticket->code . "' already exists.");
        }
        $this->ticketsByCode[$ticket->code] = $ticket;

    }

    public function findByCarRateOrderByEndingDateTimeDesc(string $carPlate, string $rateName): array
    {
        throw new \RuntimeException("Method not yet implemented.");
    }

    public function delete(string $ticketCode): void
    {
        if (! $this->exists($ticketCode)) {
            throw new \RuntimeException("Cannot delete ticket. Code '" . $ticketCode . "' does not exist.");
        }
        $this->ticketsByCode[$ticketCode] = null;
    }

    public function exists(string $ticketCode): bool
    {
        $result = false;
        /** @var Ticket $ticket */
        foreach ($this->ticketsByCode as $ticket) {
            if ($ticket->code === $ticketCode) {
                $result = true;
            }
        }
        return $result;
    }

    public function setNextCode(string $ticketCode): void
    {
        if (\strlen($ticketCode) > self::MAX_TICKET_CODE_LENGTH) {
            throw new \RuntimeException("Ticket code overflow");
        }

        $this->counter = $ticketCode;

    }

    public function nextAvailableCode(): string
    {
        return $this->leftPaddedTicketCode($this->counter);
    }

    private function leftPaddedTicketCode(string $ticketCode): string
    {
        $numberOfZeroesToPad = self::MAX_TICKET_CODE_LENGTH - \strlen($ticketCode);
        if ($numberOfZeroesToPad < 0) {
            throw new \RuntimeException("Ticket code overflow");
        }
        for ($counter = 0; $counter < $numberOfZeroesToPad; $counter++) {
            $ticketCode = "0" . $ticketCode;
        }
        return $ticketCode;
    }
}
