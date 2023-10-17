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

use Modules\Messages\Models\NullEmail;

/**
 * @internal
 */
final class NullEmailTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @covers Modules\Messages\Models\NullEmail
     * @group module
     */
    public function testNull() : void
    {
        self::assertInstanceOf('\Modules\Messages\Models\Email', new NullEmail());
    }

    /**
     * @covers Modules\Messages\Models\NullEmail
     * @group module
     */
    public function testId() : void
    {
        $null = new NullEmail(2);
        self::assertEquals(2, $null->id);
    }

    /**
     * @covers Modules\Messages\Models\NullEmail
     * @group module
     */
    public function testJsonSerialize() : void
    {
        $null = new NullEmail(2);
        self::assertEquals(['id' => 2], $null->jsonSerialize());
    }
}
