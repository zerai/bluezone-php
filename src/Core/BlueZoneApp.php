<?php declare(strict_types=1);

namespace Bluezone\Core;

use Bluezone\Core\Port\Driven\ForObtainingRates\ForObtainingRates;
use Bluezone\Core\Port\Driven\ForPaying\ForPaying;
use Bluezone\Core\Port\Driven\ForStoringTickets\ForStoringTickets;
use Bluezone\Core\Port\Driving\ForCheckingCars\ForCheckingCars;
use Bluezone\Core\Port\Driving\ForConfiguringApp\ForConfiguringApp;
use Bluezone\Core\Port\Driving\ForParkingCars\ForParkingCars;

/**
 * API
 * Driver ports
 */
interface BlueZoneApp
{
    public function getInstance(ForObtainingRates $rateProvider, ForStoringTickets $ticketStore, ForPaying $paymentService): AppFromDrivenSide;

    public function carParker(): ForParkingCars;

    public function carChecker(): ForCheckingCars;

    public function appConfigurator(): ForConfiguringApp;
}
