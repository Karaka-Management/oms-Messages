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

use phpOMS\Uri\UriFactory;

/*
$mail = new \phpOMS\Message\Mail\Imap();
$mail->connect('{imap.gmail.com:993/imap/ssl}INBOX', 'dev.orange.management@gmail.com', 'DEV_PASSWORD');
$unseen = $mail->getInboxUnseen();
$seen = $mail->getInboxSeen();
$quota = $mail->getQuota();
*/

$messages = $this->data['messages'] ?? [];

$previous = empty($messages) ? 'messages/dashboard' : 'messages/dashboard?{?}&id=' . \reset($messages)->id . '&ptype=p';
$next     = empty($messages) ? 'messages/dashboard' : 'messages/dashboard?{?}&id=' . \end($messages)->id . '&ptype=n';

echo $this->data['nav']->render(); ?>

<div class="row">
    <div class="col-xs-12 col-md-9">
        <div class="portlet">
            <div class="portlet-head"><?= $this->getHtml('Messages'); ?><i class="g-icon download btn end-xs">download</i></div>
            <table id="profileList" class="default sticky">
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
                $url = UriFactory::build('{/base}/messages/mail/view?{?}&id=' . $value->uid); ?>
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
            <a tabindex="0" class="button" href="<?= UriFactory::build('{/base}/messages/mail/create'); ?>"><?= $this->getHtml('Create', '0', '0'); ?></a>
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
