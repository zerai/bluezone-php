<?php declare(strict_types=1);

namespace Bluezone\Tests\Bdd\Core\Context;

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use Bluezone\AdapterForObtainingRatesStub\StubRateProviderAdapter;
use Bluezone\AdapterForPayingNull\NullPaymentServiceAdapter;
use Bluezone\AdapterForStoringTicketsFake\FakeAdapterForStoringTickets;
use Bluezone\Core\AppFromDrivenSide;
use Bluezone\Core\Port\Driven\ForObtainingRates\Rate;
use Bluezone\Core\Port\Driven\ForStoringTickets\Ticket;
use Bluezone\Core\Port\Driving\ForConfiguringApp\ForConfiguringApp;
use Bluezone\Core\Port\Driving\ForParkingCars\ForParkingCars;
use PHPUnit\Framework\Assert;

// use Behat\Gherkin\Node\PyStringNode;
// use Behat\Gherkin\Node\TableNode;

/**
 * Defines application features from the specific context.
 */
class ForParkingCarScenarioContext implements Context
{
    private readonly ForParkingCars $carParker;

    private readonly ForConfiguringApp $appConfigurator;

    private array $currentRatesByName;

    private ?Ticket $currentTicket = null;

    public function __construct()
    {
        $bluezoneApp = new AppFromDrivenSide(rateProvider: new StubRateProviderAdapter(), ticketStore: new FakeAdapterForStoringTickets(), paymentService: new NullPaymentServiceAdapter());
        $this->carParker = $bluezoneApp->carParker();
        $this->appConfigurator = $bluezoneApp->appConfigurator();
    }

    /**
     * @Transform table:name,amountPerHour
     */
    public function castRatesTable(TableNode $rateTable): array
    {
        $rates = [];
        foreach ($rateTable as $row) {
            $rate = new Rate($row['name'], (int) $row['amountPerHour']);
            $rates[] = $rate;
        }

        return $rates;
    }

    /**
     * @Transform table:index,name,amountPerHour
     */
    public function castIndexedRatesTable(TableNode $rateTable): array
    {
        $rates = [];
        foreach ($rateTable as $row) {
            $rate = new Rate($row['name'], (int) $row['amountPerHour']);
            $rates[$row['name']] = $rate;
        }

        return $rates;
    }

    /**
     * @Given there are the following rates at rate repository:
     */
    public function thereAreTheFollowingRatesAtRateRepository(array $rates)
    {
        $this->appConfigurator->initRateProviderWith($rates);
    }

    /**
     * @When I ask for getting all rates by name
     */
    public function iAskForGettingAllRatesByName()
    {
        $this->currentRatesByName = $this->carParker->getAllRatesByName();
    }

    /**
     * @Then I should obtain the following rates indexed by name:
     */
    public function iShouldObtainTheFollowingRatesIndexedByName(array $indexedRates)
    {
        Assert::assertEquals($this->currentRatesByName, $indexedRates);
    }

    /**
     * @Given there is the following ticket at ticket repository:
     */
    public function thereIsTheFollowingTicketAtTicketRepository(array $tickets): void
    {
        foreach ($tickets as $ticket) {
            $this->appConfigurator->createTicket($ticket);
        }
    }

    /**
     * @Transform table:code,carPlate,rateName,startingDateTime,endingDateTime,price
     */
    public function castTicketTable(TableNode $ticketTable): array
    {
        $tickets = [];
        foreach ($ticketTable as $ticketHash) {
            $ticket = new Ticket(
                $ticketHash['code'],
                $ticketHash['carPlate'],
                $ticketHash['rateName'],
                \DateTimeImmutable::createFromFormat('Y/m/d H:i', $ticketHash['startingDateTime']),
                \DateTimeImmutable::createFromFormat('Y/m/d H:i', $ticketHash['endingDateTime']),
                (int) $ticketHash['price'],
            );
            $tickets[] = $ticket;
        }

        return $tickets;
    }

    /**
     * @When I ask for getting the ticket with code :ticketCode
     */
    public function iAskForGettingTheTicketWithCode(string $ticketCode)
    {
        $this->currentTicket = $this->carParker->getTicket($ticketCode);
    }

    /**
     * @Then I should obtain the following ticket:
     */
    public function iShouldObtainTheFollowingTicket(array $tickets)
    {
        Assert::assertEquals($this->currentTicket, $tickets[0]);
    }

    /**
     * @Given there is no ticket with code :ticketCode at ticket repository
     */
    public function thereIsNoTicketWithCodeAtTicketRepository(string $ticketCode)
    {
        $this->appConfigurator->eraseTicket($ticketCode);
    }

    /**
     * @Then I should obtain no ticket
     */
    public function iShouldObtainNoTicket()
    {
        Assert::assertNull($this->currentTicket);
    }
}
