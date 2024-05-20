<?php
/**
 * Jingga
 *
 * PHP Version 8.2
 *
 * @package   Modules\Messages\Models
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.2
 * @version   1.0.0
 * @link      https://jingga.app
 */
declare(strict_types=1);

namespace Modules\Messages\Models;

use phpOMS\DataStorage\Database\Mapper\DataMapperFactory;

/**
 * Server mapper class.
 *
 * @package Modules\Messages\Models
 * @license OMS License 2.2
 * @link    https://jingga.app
 * @since   1.0.0
 *
 * @template T of Email
 * @extends DataMapperFactory<T>
 */
final class ServerMapper extends DataMapperFactory
{
}
