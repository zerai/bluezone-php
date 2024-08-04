<?php declare(strict_types=1);

namespace Bluezone\Core\Port\Driven\ForPaying;

use RuntimeException;

/**
 * Exception thrown by the pay method in the "for paying" port,
 * when it has been any error and the payment didn't take place.
 */
class PayErrorException extends RuntimeException
{
}
