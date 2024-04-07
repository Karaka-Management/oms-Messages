<?php
/**
 * Jingga
 *
 * PHP Version 8.2
 *
 * @package   Modules\Messages\Models
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.0
 * @version   1.0.0
 * @link      https://jingga.app
 */
declare(strict_types=1);

namespace Modules\Messages\Models;

use Modules\Admin\Models\AccountMapper;
use Modules\Media\Models\MediaMapper;
use phpOMS\DataStorage\Database\Mapper\DataMapperFactory;

/**
 * Email mapper class.
 *
 * @package Modules\Messages\Models
 * @license OMS License 2.0
 * @link    https://jingga.app
 * @since   1.0.0
 *
 * @template T of Email
 * @extends DataMapperFactory<T>
 */
final class EmailMapper extends DataMapperFactory
{
    /**
     * Columns.
     *
     * @var array<string, array{name:string, type:string, internal:string, autocomplete?:bool, readonly?:bool, writeonly?:bool, annotations?:array}>
     * @since 1.0.0
     */
    public const COLUMNS = [
        'messages_mail_id'           => ['name' => 'messages_mail_id',           'type' => 'int',               'internal' => 'id'],
        'messages_mail_msgid'        => ['name' => 'messages_mail_msgid',        'type' => 'string',            'internal' => 'messageId'],
        'messages_mail_status'       => ['name' => 'messages_mail_status',       'type' => 'int',               'internal' => 'status'],
        'messages_mail_to'           => ['name' => 'messages_mail_to',           'type' => 'Json',              'internal' => 'to'],
        'messages_mail_from'         => ['name' => 'messages_mail_from',         'type' => 'Json',              'internal' => 'from'],
        'messages_mail_from_account' => ['name' => 'messages_mail_from_account', 'type' => 'int',               'internal' => 'account'],
        'messages_mail_cc'           => ['name' => 'messages_mail_cc',           'type' => 'Json',              'internal' => 'cc'],
        'messages_mail_bcc'          => ['name' => 'messages_mail_bcc',          'type' => 'Json',              'internal' => 'bcc'],
        'messages_mail_replyto'      => ['name' => 'messages_mail_replyto',      'type' => 'Json',              'internal' => 'replyTo'],
        'messages_mail_confimation'  => ['name' => 'messages_mail_confimation',  'type' => 'string',            'internal' => 'confirmationAddress'],
        'messages_mail_subject'      => ['name' => 'messages_mail_subject',         'type' => 'string',            'internal' => 'subject'],
        'messages_mail_body'         => ['name' => 'messages_mail_body',         'type' => 'string',            'internal' => 'body'],
        'messages_mail_bodyalt'      => ['name' => 'messages_mail_bodyalt',      'type' => 'string',            'internal' => 'bodyAlt'],
        'messages_mail_bodymime'     => ['name' => 'messages_mail_bodymime',     'type' => 'string',            'internal' => 'bodyMime'],
        'messages_mail_ical'         => ['name' => 'messages_mail_ical',         'type' => 'string',            'internal' => 'ical'],
        'messages_mail_created_at'   => ['name' => 'messages_mail_created_at',   'type' => 'DateTimeImmutable', 'internal' => 'createdAt'],
        'messages_mail_sent'         => ['name' => 'messages_mail_sent',         'type' => 'DateTimeImmutable',          'internal' => 'createdAt'],
        'messages_mail_received'     => ['name' => 'messages_mail_received',     'type' => 'DateTimeImmutable',          'internal' => 'createdAt'],
        'messages_mail_priority'     => ['name' => 'messages_mail_priority',     'type' => 'int',               'internal' => 'priority'],
        'messages_mail_encoding'     => ['name' => 'messages_mail_encoding',     'type' => 'string',            'internal' => 'encoding', 'private' => true],
        'messages_mail_contenttype'  => ['name' => 'messages_mail_contenttype',  'type' => 'string',            'internal' => 'contentType', 'private' => true],
        'messages_mail_charset'      => ['name' => 'messages_mail_charset',      'type' => 'string',            'internal' => 'charset'],
        'messages_mail_template'     => ['name' => 'messages_mail_template',      'type' => 'bool',            'internal' => 'isTemplate'],
    ];

    /**
     * Has many relation.
     *
     * @var array<string, array{mapper:class-string, table:string, self?:?string, external?:?string, column?:string}>
     * @since 1.0.0
     */
    public const HAS_MANY = [
        'files' => [
            'mapper'   => MediaMapper::class,
            'table'    => 'messages_mail_media',
            'external' => 'messages_mail_media_dst',
            'self'     => 'messages_mail_media_src',
        ],
        'l11n' => [
            'mapper'   => EmailL11nMapper::class,
            'table'    => 'messages_mail_l11n',
            'self'     => 'messages_mail_l11n_message',
            'external' => null,
        ],
    ];

    /**
     * Belongs to.
     *
     * @var array<string, array{mapper:class-string, external:string, column?:string, by?:string}>
     * @since 1.0.0
     */
    public const BELONGS_TO = [
        'account' => [
            'mapper'   => AccountMapper::class,
            'external' => 'messages_mail_from_account',
        ],
    ];

    /**
     * Primary table.
     *
     * @var string
     * @since 1.0.0
     */
    public const TABLE = 'messages_mail';

    /**
     * Created at.
     *
     * @var string
     * @since 1.0.0
     */
    public const CREATED_AT = 'messages_mail_created_at';

    /**
     * Primary field name.
     *
     * @var string
     * @since 1.0.0
     */
    public const PRIMARYFIELD = 'messages_mail_id';
}
