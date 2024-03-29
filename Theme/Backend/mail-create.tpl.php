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

echo $this->data['nav']->render(); ?>

<section class="box w-100">
    <div class="inner">
        <form>
            <table class="layout wf-100">
                <tr><td style="width: 1%"><button class="simple"><i class="g-icon">book</i></button><td><input type="text" name="to">
                <tr><td style="width: 1%"><button class="simple"><i class="g-icon">book</i></button><td><input type="text" name="cc">
                <tr><td style="width: 1%"><button class="simple"><i class="g-icon">book</i></button><td><input type="text" name="bcc">
                <tr><td><td><input type="text" name="subject">
                <tr><td><td><input type="file" name="files" multiple>
                <tr><td><td><div class="textarea" contenteditable="true" style="height: 400px;"></div><textarea style="display: none" name="mail"></textarea>
                <tr><td><td><input type="submit" value="<?= $this->getHtml('Send', '0', '0'); ?>" name="send-mail"> <input type="submit" value="<?= $this->getHtml('Save', '0', '0'); ?>" name="save-mail">
            </table>
        </form>
    </div>
</section>
