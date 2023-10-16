<?php
/**
 * Jingga
 *
 * PHP Version 8.1
 *
 * @package   tests
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.0
 * @version   1.0.0
 * @link      https://jingga.app
 */
declare(strict_types=1);

namespace Modules\Messages\tests\Models;

use Modules\Messages\Models\NullEmailL11n;

/**
 * @internal
 */
final class NullEmailL11nTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @covers Modules\Messages\Models\NullEmailL11n
     * @group module
     */
    public function testNull() : void
    {
        self::assertInstanceOf('\Modules\Messages\Models\EmailL11n', new NullEmailL11n());
    }

    /**
     * @covers Modules\Messages\Models\NullEmailL11n
     * @group module
     */
    public function testId() : void
    {
        $null = new NullEmailL11n(2);
        self::assertEquals(2, $null->getId());
    }

    /**
     * @covers Modules\Messages\Models\NullEmailL11n
     * @group module
     */
    public function testJsonSerialize() : void
    {
        $null = new NullEmailL11n(2);
        self::assertEquals(['id' => 2], $null);
    }
}
