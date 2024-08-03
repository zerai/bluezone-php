<?php declare(strict_types=1);

namespace Bluezone\Tests;

use Bluezone\Foo;
use PHPUnit\Framework\TestCase;

class FooTest extends TestCase
{
    public function testName(): void
    {
        $foo = new Foo();
        self::assertTrue($foo->bar());
    }
}
