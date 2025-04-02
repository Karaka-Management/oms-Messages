<?php
/**
 * Jingga
 *
 * PHP Version 8.2
 *
 * @package   Modules\Messages\Admin\Install
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.2
 * @version   1.0.0
 * @link      https://jingga.app
 */
declare(strict_types=1);

namespace Modules\Messages\Admin\Install;

use Modules\Messages\Models\SettingsEnum;
use phpOMS\Application\ApplicationAbstract;
use phpOMS\Message\Http\HttpRequest;
use phpOMS\Message\Http\HttpResponse;

/**
 * Media class.
 *
 * @package Modules\Messages\Admin\Install
 * @license OMS License 2.2
 * @link    https://jingga.app
 * @since   1.0.0
 */
class Messages
{
    /**
     * Install media providing
     *
     * @param ApplicationAbstract $app  Application
     * @param string              $path Module path
     *
     * @return void
     *
     * @since 1.0.0
     */
    public static function install(ApplicationAbstract $app, string $path) : void
    {
        $messages = \Modules\Messages\Admin\Installer::installExternal($app, ['path' => __DIR__ . '/Messages.install.json']);

        /** @var \Modules\Admin\Controller\ApiController $module */
        $module = $app->moduleManager->get('Admin');

        $settings = [
            [
                'id'      => null,
                'name'    => SettingsEnum::HEADER_TEMPLATE,
                'content' => (string) $messages['email_template'][0]['id'],
                'module'  => 'Messages',
            ],
            [
                'id'      => null,
                'name'    => SettingsEnum::FOOTER_TEMPLATE,
                'content' => (string) $messages['email_template'][1]['id'],
                'module'  => 'Messages',
            ],
        ];

        $response = new HttpResponse();
        $request  = new HttpRequest();

        $request->header->account = 1;
        $request->setData('settings', \json_encode($settings));

        $module->apiSettingsSet($request, $response);
    }
}
