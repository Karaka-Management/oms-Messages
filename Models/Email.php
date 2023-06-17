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

use Modules\Admin\Models\Account;
use Modules\Admin\Models\NullAccount;
use phpOMS\Message\Mail\Email as MailEmail;

/**
 * Null bill type class.
 *
 * @package Modules\Messages\Models
 * @license OMS License 2.0
 * @link    https://jingga.app
 * @since   1.0.0
 */
class Email extends MailEmail implements \JsonSerializable
{
    /**
     * Mail id.
     *
     * @var int
     * @since 1.0.0
     */
    public int $id = 0;

    public Account $account;

    public \DateTimeImmutable $createdAt;

    public int $status = 0;

    private array $media = [];

    public array $l11n = [];

    public bool $isTemplate = false;

    /**
     * Constructor.
     *
     * @since 1.0.0
     */
    public function __construct()
    {
        $this->account   = new NullAccount();
        $this->createdAt = new \DateTimeImmutable('now');
    }

    /**
     * Get localization by language
     *
     * @param string $language Language code
     *
     * @return EmailL11n
     *
     * @since 1.0.0
     */
    public function getL11nByLanguage(string $language) : EmailL11n
    {
        foreach ($this->l11n as $l11n) {
            if ($l11n->language === $language) {
                return $l11n;
            }
        }

        return new NullEmailL11n();
    }

    /**
     * {@inheritdoc}
     */
    public function toArray() : array
    {
        return [
           'id'      => $this->id,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function jsonSerialize() : mixed
    {
        return $this->toArray();
    }
}
