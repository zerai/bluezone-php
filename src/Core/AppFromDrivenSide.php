<?php declare(strict_types=1);

namespace Bluezone\Core;

use Bluezone\Core\Port\Driven\ForObtainingRates\ForObtainingRates;
use Bluezone\Core\Port\Driven\ForPaying\ForPaying;
use Bluezone\Core\Port\Driven\ForStoringTickets\ForStoringTickets;
use Bluezone\Core\Port\Driving\ForCheckingCars\ForCheckingCars;
use Bluezone\Core\Port\Driving\ForConfiguringApp\ForConfiguringApp;
use Bluezone\Core\Port\Driving\ForParkingCars\ForParkingCars;

/**
 * Application
 * Offers driver ports as API.
 * Has a configurable dependency on driven ports as RI (required interface).
 */
class AppFromDrivenSide implements BlueZoneApp
{
    public function __construct(
        // Driver ports
        private ?ForParkingCars $carParker = null,
        private ?ForCheckingCars $carChecker = null,
        private ?ForConfiguringApp $appConfigurator = null,
        // Driven ports
        private readonly ?ForObtainingRates $rateProvider = null,
        private readonly ?ForStoringTickets $ticketStore = null,
        private readonly ?ForPaying $paymentService = null,
    ) {
    }

    /**
     * TODO: UALTM  remove...
     */
    public function getInstance(ForObtainingRates $rateProvider, ForStoringTickets $ticketStore, ForPaying $paymentService): AppFromDrivenSide
    {
        return new AppFromDrivenSide(rateProvider: $rateProvider, ticketStore: $ticketStore, paymentService: $paymentService);
    }

    public function carParker(): ForParkingCars
    {
        if (! $this->carParker instanceof ForParkingCars) {
            $this->carParker = new CarParker($this->rateProvider, $this->ticketStore, $this->paymentService);
        }

        return $this->carParker;
    }

    public function carChecker(): ForCheckingCars
    {
        if (! $this->carChecker instanceof ForCheckingCars) {
            $this->carChecker = new CarChecker($this->ticketStore);
        }

        return $this->carChecker;
    }

    public function appConfigurator(): ForConfiguringApp
    {
        if (! $this->appConfigurator instanceof ForConfiguringApp) {
            $this->appConfigurator = new AppConfigurator($this->rateProvider, $this->ticketStore, $this->paymentService);
        }
        return $this->appConfigurator;
    }
}
