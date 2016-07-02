<?php
/**
 * Orange Management
 *
 * PHP Version 7.0
 *
 * @category   TBD
 * @package    TBD
 * @author     OMS Development Team <dev@oms.com>
 * @author     Dennis Eichhorn <d.eichhorn@oms.com>
 * @copyright  2013 Dennis Eichhorn
 * @license    OMS License 1.0
 * @version    1.0.0
 * @link       http://orange-management.com
 */
$mail = new \phpOMS\Message\Mail\Imap();
$mail->connect('{imap.gmail.com:993/imap/ssl}[Gmail]/Gesendet', 'dev.orange.management@gmail.com', DEV_PASSWORD);
$sent = $mail->getInboxAll();
$quota = $mail->getQuota();

echo $this->getData('nav')->render(); ?>

<section class="box w-100">
    <ul class="btns floatLeft">
        <li><a href="<?= \phpOMS\Uri\UriFactory::build('/{/lang}/backend/messages/mail/create'); ?>"><i class="fa fa-pencil"></i> <?= $this->l11n->getText(0, 'Create'); ?></a>
        <li><a href=""><i class="fa fa-trash"></i> <?= $this->l11n->getText(0, 'Delete'); ?></a>
    </ul>
</section>

<div class="box w-100">
    <table class="table">
        <caption><?= $this->l11n->getText('Messages', 'Messages'); ?></caption>
        <thead>
        <tr>
            <td><span class="check"><input type="checkbox"></span>
            <td><?= $this->l11n->getText('Messages', 'Tag'); ?>
            <td class="wf-100"><?= $this->l11n->getText('Messages', 'Subject'); ?>
            <td><?= $this->l11n->getText('Messages', 'From'); ?>
            <td><?= $this->l11n->getText('Messages', 'Date'); ?>
        <tfoot>
        <tr><td colspan="5"><?= \phpOMS\Utils\Converter\File::kilobyteSizeToString($quota['usage']); ?> / <?= \phpOMS\Utils\Converter\File::kilobyteSizeToString($quota['limit']); ?>
        <tbody>
        <?php $count = 0; foreach($sent as $key => $value) : $count++;
        $url = \phpOMS\Uri\UriFactory::build('/{/lang}/backend/messages/mail/single?id=' . $value->uid); ?>
        <tr>
            <td><span class="check"><input type="checkbox"></span>
            <td><a href="<?= $url; ?>"<?= $value->seen == 0 ? ' class="unseen"' : ''; ?>></a>
            <td><a href="<?= $url; ?>"<?= $value->seen == 0 ? ' class="unseen"' : ''; ?>><?= str_replace('_',' ', mb_decode_mimeheader($value->subject)); ?></a>
            <td><a href="<?= $url; ?>"<?= $value->seen == 0 ? ' class="unseen"' : ''; ?>><?= $value->from; ?></a>
            <td><a href="<?= $url; ?>"<?= $value->seen == 0 ? ' class="unseen"' : ''; ?>><?= (new \DateTime($value->date))->format('Y-m-d H:i:s'); ?></a>
                <?php endforeach; ?>
                <?php if($count < 1) : ?>
        <tr>
            <td colspan="5" class="empty"><?= $this->l11n->getText(0, 'Empty'); ?>
                <?php endif; ?>
    </table>
</div>