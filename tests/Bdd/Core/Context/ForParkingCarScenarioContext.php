<?php declare(strict_types=1);

namespace Bluezone\Tests\Bdd\Core\Context;

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use Bluezone\AdapterForObtainingRatesStub\StubRateProviderAdapter;
use Bluezone\AdapterForPayingNull\NullPaymentServiceAdapter;
use Bluezone\AdapterForStoringTicketsNull\NullTicketStoreAdapter;
use Bluezone\Core\AppFromDrivenSide;
use Bluezone\Core\Port\Driven\ForObtainingRates\Rate;
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

    public function __construct()
    {
        $bluezoneApp = new AppFromDrivenSide(rateProvider: new StubRateProviderAdapter(), ticketStore: new NullTicketStoreAdapter(), paymentService: new NullPaymentServiceAdapter()); //var_dump($bluzoneApp);
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
            $rate = new Rate();
            $rate->name = $row['name'];
            $rate->amountPerHour = (int) $row['amountPerHour'];
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
            $rate = new Rate();
            $rate->name = $row['name'];
            $rate->amountPerHour = (int) $row['amountPerHour'];
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
}
