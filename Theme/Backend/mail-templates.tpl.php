<?php
/**
 * Jingga
 *
 * PHP Version 8.1
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

$messages = $this->data['templates'] ?? [];

$previous = empty($messages) ? 'messages/dashboard' : 'messages/dashboard?{?}&id=' . \reset($messages)->id . '&ptype=p';
$next     = empty($messages) ? 'messages/dashboard' : 'messages/dashboard?{?}&id=' . \end($messages)->id . '&ptype=n';

echo $this->data['nav']->render(); ?>

<div class="row">
    <div class="col-xs-12 col-md-9">
        <div class="portlet">
            <div class="portlet-head"><?= $this->getHtml('Templates'); ?><i class="lni lni-download download btn end-xs"></i></div>
            <table id="profileList" class="default">
            <thead>
            <tr>
                <td><span class="check"><input type="checkbox" name="profile-list"></span>
                <td class="wf-100"><?= $this->getHtml('Subject'); ?>
                <td><?= $this->getHtml('Date'); ?>
            <tbody>
            <?php $count = 0;
                foreach ($messages as $key => $value) : ++$count;
                $url = UriFactory::build('{/base}/messages/template/single?{?}&id=' . $value->id); ?>
                <tr data-href="<?= $url; ?>">
                    <td><span class="check"><input type="checkbox" name=""></span>
                    <td><a href="<?= $url; ?>"><?= $this->printHtml(empty($value->subject) ? $value->getL11nByLanguage($this->response->header->l11n->language)->subject : $value->subject); ?></a>
                    <td><a href="<?= $url; ?>"><?= $this->printHtml($value->createdAt->format('Y-m-d')); ?></a>
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
            <a tabindex="0" class="button" href="<?= UriFactory::build('{/base}/messages/template/create'); ?>"><i class="fa fa-pencil"></i> <?= $this->getHtml('Create', '0', '0'); ?></a>
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
