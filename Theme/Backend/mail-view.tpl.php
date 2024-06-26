<?php
/**
 * Jingga
 *
 * PHP Version 8.2
 *
 * @package   Modules\Messages
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.0
 * @version   1.0.0
 * @link      https://jingga.app
 */
declare(strict_types=1);

$mail = new \phpOMS\Message\Mail\Imap();
$mail->connect('{imap.gmail.com:993/imap/ssl}INBOX', 'dev.orange.management@gmail.com', 'DEV_PASSWORD');
$mails = $mail->getEmail($this->getData('id'));

echo $this->data['nav']->render(); ?>

<section class="box w-100">
    <header><h1><?= $this->printHtml(\str_replace('_',' ', \mb_decode_mimeheader($mails['overview'][0]->subject))); ?></h1></header>
    <div class="inner">
        <?= $this->printHtml($mail::decode($mails['body'], $mails['encoding']->encoding)); ?>
    </div>
</section>
