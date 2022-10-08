<?php
/**
 * Karaka
 *
 * PHP Version 8.1
 *
 * @package   Modules\Messages
 * @copyright Dennis Eichhorn
 * @license   OMS License 1.0
 * @version   1.0.0
 * @link      https://karaka.app
 */
declare(strict_types=1);

use phpOMS\Uri\UriFactory;

/*
$mail = new \phpOMS\Message\Mail\Imap();
$mail->connect('{imap.gmail.com:993/imap/ssl}INBOX', 'dev.orange.management@gmail.com', 'DEV_PASSWORD');
$unseen = $mail->getInboxUnseen();
$seen = $mail->getInboxSeen();
$quota = $mail->getQuota();
*/

$messages = $this->getData('messages') ?? [];

$previous = empty($messages) ? '{/prefix}messages/dashboard' : '{/prefix}messages/dashboard?{?}&id=' . \reset($messages)->getId() . '&ptype=p';
$next     = empty($messages) ? '{/prefix}messages/dashboard' : '{/prefix}messages/dashboard?{?}&id=' . \end($messages)->getId() . '&ptype=n';

echo $this->getData('nav')->render(); ?>

<div class="row">
    <div class="col-xs-12 col-md-9">
        <div class="portlet">
            <div class="portlet-head"><?= $this->getHtml('Messages'); ?><i class="fa fa-download floatRight download btn"></i></div>
            <table id="profileList" class="default">
            <thead>
            <tr>
                <td><span class="check"><input type="checkbox" name="profile-list"></span>
                <td><?= $this->getHtml('Tag'); ?>
                <td class="wf-100"><?= $this->getHtml('Subject'); ?>
                <td><?= $this->getHtml('From'); ?>
                <td><?= $this->getHtml('Date'); ?>
            <tbody>
            <?php $count = 0;
                foreach ($messages as $key => $value) : ++$count;
                $url = UriFactory::build('{/prefix}messages/mail/single?{?}&id=' . $value->uid); ?>
                <tr>
                    <td><span class="check"><input type="checkbox" name=""></span>
                    <td><a href="<?= $url; ?>"<?= $this->printHtml($value->seen == 0 ? ' class="unseen"' : ''); ?>></a>
                    <td><a href="<?= $url; ?>"<?= $this->printHtml($value->seen == 0 ? ' class="unseen"' : ''); ?>><?= $this->printHtml(\str_replace('_',' ', \mb_decode_mimeheader($value->subject))); ?></a>
                    <td><a href="<?= $url; ?>"<?= $this->printHtml($value->seen == 0 ? ' class="unseen"' : ''); ?>><?= $this->printHtml($value->from); ?></a>
                    <td><a href="<?= $url; ?>"<?= $this->printHtml($value->seen == 0 ? ' class="unseen"' : ''); ?>><?= $this->printHtml((new \DateTime($value->date))->format('Y-m-d H:i:s')); ?></a>
            <?php endforeach; ?>
            <?php if ($count === 0) : ?>
            <tr>
                <td colspan="5" class="empty"><?= $this->getHtml('Empty', '0', '0'); ?>
            <?php endif; ?>
        </table>
        <div class="portlet-foot">
                <a tabindex="0" class="button" href="<?= UriFactory::build($previous); ?>"><?= $this->getHtml('Previous', '0', '0'); ?></a>
                <a tabindex="0" class="button" href="<?= UriFactory::build($next); ?>"><?= $this->getHtml('Next', '0', '0'); ?></a>
            </div>
        </div>
    </div>

    <div class="col-xs-12 col-md-3">
        <div class="box">
            <a tabindex="0" class="button" href="<?= UriFactory::build('{/prefix}messages/mail/create'); ?>"><i class="fa fa-pencil"></i> <?= $this->getHtml('Create', '0', '0'); ?></a>
        </div>

        <div class="portlet">
            <div class="portlet-head"><?= $this->getHtml('Channels'); ?></div>
            <div class="portlet-body">
                asdf
            </div>
        </div>

        <div class="portlet">
            <div class="portlet-head"><?= $this->getHtml('Email'); ?></div>
            <div class="portlet-body">
                asdf
            </div>
        </div>

        <div class="portlet">
            <div class="portlet-head"><?= $this->getHtml('Chat'); ?></div>
            <div class="portlet-body">
                asdf
            </div>
        </div>
    </div>
</div>
