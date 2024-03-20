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

use phpOMS\Localization\ISO639Enum;
use phpOMS\Utils\Formatter\HtmlFormatter;

$mail = $this->data['template'];

echo $this->data['nav']->render(); ?>

<div class="tabview tab-2 right">
    <div class="box">
        <ul class="tab-links">
            <?php foreach ($mail->l11n as $idx => $l11n) : ?>
            <li<?= $idx === 1 ? ' class="active"' : ''; ?>><label for="c-tab-<?= $idx; ?>"><?= $this->printHtml(ISO639Enum::getBy2Code($l11n->language)); ?></label>
            <?php endforeach; ?>
        </ul>
    </div>
    <div class="tab-content">
        <?php foreach ($mail->l11n as $idx => $l11n) : ?>
        <input type="radio" id="c-tab-<?= $idx; ?>" name="tabular-1"<?= $l11n->language === $this->response->header->l11n->language ? ' checked' : ''; ?>>
        <div class="tab">
            <div class="row">
                <div class="col-xs-12">
                    <div class="portlet">
                        <div class="portlet-body">
                            <input type="text" value="<?= $this->printHtml($l11n->subject); ?>">
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12">
                    <div class="portlet">
                        <div class="portlet-body">
                            <pre><?= $this->printHtml(HtmlFormatter::format($l11n->body)); ?></pre>
                        </div>
                    </div>
                </div>
            </div>

            <!--
            <div class="row">
                <div class="col-xs-12">
                    <div class="portlet">
                        <div class="portlet-body">
                            <?= $l11n->body; ?>
                        </div>
                    </div>
                </div>
            </div>
            -->

            <div class="row">
                <div class="col-xs-12">
                    <div class="portlet">
                        <div class="portlet-body">
                            <pre><?= $l11n->bodyAlt; ?></pre>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>