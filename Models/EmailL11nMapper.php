<?php
/**
 * Jingga
 *
 * PHP Version 8.1
 *
 * @package   Modules\Messages\Models
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.0
 * @version   1.0.0
 * @link      https://jingga.app
 */
declare(strict_types=1);

namespace Modules\Messages\Models;

use phpOMS\DataStorage\Database\Mapper\DataMapperFactory;

/**
 * Email mapper class.
 *
 * @package Modules\Messages\Models
 * @license OMS License 2.0
 * @link    https://jingga.app
 * @since   1.0.0
 *
 * @template T of EmailL11n
 * @extends DataMapperFactory<T>
 */
final class EmailL11nMapper extends DataMapperFactory
{
    /**
     * Columns.
     *
     * @var array<string, array{name:string, type:string, internal:string, autocomplete?:bool, readonly?:bool, writeonly?:bool, annotations?:array}>
     * @since 1.0.0
     */
    public const COLUMNS = [
        'messages_mail_l11n_id'             => ['name' => 'messages_mail_l11n_id',          'type' => 'int',    'internal' => 'id'],
        'messages_mail_l11n_subject'        => ['name' => 'messages_mail_l11n_subject', 'type' => 'string', 'internal' => 'subject'],
        'messages_mail_l11n_body'           => ['name' => 'messages_mail_l11n_body',        'type' => 'string',    'internal' => 'body'],
        'messages_mail_l11n_bodyalt'        => ['name' => 'messages_mail_l11n_bodyalt',        'type' => 'string', 'internal' => 'bodyAlt'],
        'messages_mail_l11n_message'        => ['name' => 'messages_mail_l11n_message',     'type' => 'int',    'internal' => 'email'],
        'messages_mail_l11n_lang'           => ['name' => 'messages_mail_l11n_lang',     'type' => 'string',    'internal' => 'language'],
    ];

    /**
     * Primary table.
     *
     * @var string
     * @since 1.0.0
     */
    public const TABLE = 'messages_mail_l11n';

    /**
     * Primary field name.
     *
     * @var string
     * @since 1.0.0
     */
    public const PRIMARYFIELD = 'messages_mail_l11n_id';
}
