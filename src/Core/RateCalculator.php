<?php declare(strict_types=1);

namespace Bluezone\Core;

use Bluezone\Core\Port\Driven\ForObtainingRates\Rate;

class RateCalculator
{
    public function __construct(
        private readonly Rate $rate
    ) {

    }

    public function getUntilGivenAmount(\DateTimeImmutable $from, int $amount): \DateTimeImmutable
    {
        // minutes = (amount*60)/amountPerHour
        // int minutes = (int) ((amount.doubleValue()*60.0) / this.rate.getAmountPerHour().doubleValue())
        $minutes = (int) (($amount * 60.0) / $this->rate->amountPerHour);

        return $from->add(\DateInterval::createFromDateString('PT' . $minutes . 'M'));
    }
}
