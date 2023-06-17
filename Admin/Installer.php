<?php
/**
 * Jingga
 *
 * PHP Version 8.1
 *
 * @package   Modules\Messages\Admin
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.0
 * @version   1.0.0
 * @link      https://jingga.app
 */
declare(strict_types=1);

namespace Modules\Messages\Admin;

use phpOMS\Application\ApplicationAbstract;
use phpOMS\Message\Http\HttpRequest;
use phpOMS\Message\Http\HttpResponse;
use phpOMS\Module\InstallerAbstract;
use phpOMS\System\File\PathException;
use phpOMS\Uri\HttpUri;

/**
 * Installer class.
 *
 * @package Modules\Messages\Admin
 * @license OMS License 2.0
 * @link    https://jingga.app
 * @since   1.0.0
 */
final class Installer extends InstallerAbstract
{
    /**
     * Path of the file
     *
     * @var string
     * @since 1.0.0
     */
    public const PATH = __DIR__;

    /**
     * Install data from providing modules.
     *
     * The data can be either directories which should be created or files which should be "uploaded"
     *
     * @param ApplicationAbstract $app  Application
     * @param array               $data Additional data
     *
     * @return array
     *
     * @throws PathException
     * @throws \Exception
     *
     * @since 1.0.0
     */
    public static function installExternal(ApplicationAbstract $app, array $data) : array
    {
        try {
            $app->dbPool->get()->con->query('select 1 from `messages_mail`');
        } catch (\Exception $_) {
            return []; // @codeCoverageIgnore
        }

        if (!\is_file($data['path'] ?? '')) {
            throw new PathException($data['path'] ?? '');
        }

        $messageFile = \file_get_contents($data['path'] ?? '');
        if ($messageFile === false) {
            throw new PathException($data['path'] ?? ''); // @codeCoverageIgnore
        }

        $messageData = \json_decode($messageFile, true) ?? [];
        if ($messageData === false) {
            throw new \Exception(); // @codeCoverageIgnore
        }

        $result = [
            'email_template' => [],
        ];

        $apiApp = new class() extends ApplicationAbstract
        {
            protected string $appName = 'Api';
        };

        $apiApp->dbPool         = $app->dbPool;
        $apiApp->unitId         = $app->unitId;
        $apiApp->accountManager = $app->accountManager;
        $apiApp->appSettings    = $app->appSettings;
        $apiApp->moduleManager  = $app->moduleManager;
        $apiApp->eventManager   = $app->eventManager;

        /** @var array{type:array} $messageData */
        foreach ($messageData as $message) {
            switch ($message['type']) {
                case 'email_template':
                    $result['email_template'][] = self::createMessageTemplate($apiApp, $message);
                    break;
                default:
            }
        }

        return $result;
    }

    /**
     * Create message template.
     *
     * @param ApplicationAbstract $app  Application
     * @param array               $data Type info
     *
     * @return array
     *
     * @since 1.0.0
     */
    private static function createMessageTemplate(ApplicationAbstract $app, array $data) : array
    {
        /** @var \Modules\Messages\Controller\ApiController $module */
        $module = $app->moduleManager->get('Messages');

        $response = new HttpResponse();
        $request  = new HttpRequest(new HttpUri(''));

        $request->header->account = 1;
        $request->setData('from', $data['from'] ?? '');
        $request->setData('to', $data['to'] ?? null);
        $request->setData('cc', $data['cc'] ?? null);
        $request->setData('bcc', $data['bcc'] ?? null);
        $request->setData('subject', $data['subject'] ?? '');
        $request->setData('ishtml', $data['ishtml'] ?? false);
        $request->setData('body', $data['body'] ?? '');
        $request->setData('bodyalt', $data['bodyalt'] ?? '');
        $request->setData('send', $data['send'] ?? false);
        $request->setData('template', true);

        $module->apiEmailCreate($request, $response);

        $responseData = $response->get('');
        if (!\is_array($responseData)) {
            return [];
        }

        $emailId = $responseData['response']->id;

        foreach ($data['l11n'] as $language => $l11n) {
            $l11nResponse = new HttpResponse();
            $l11nRequest  = new HttpRequest(new HttpUri(''));

            $l11nRequest->header->account = 1;
            $l11nRequest->setData('email', $emailId);
            $l11nRequest->setData('language', $language);
            $l11nRequest->setData('subject', $l11n['subject'] ?? '');
            $l11nRequest->setData('body', $l11n['body'] ?? '');
            $l11nRequest->setData('bodyalt', $l11n['bodyalt'] ?? '');

            $module->apiEmailL11nCreate($l11nRequest, $l11nResponse);
        }

        return \is_array($responseData['response'])
            ? $responseData['response']
            : $responseData['response']->toArray();
    }
}
