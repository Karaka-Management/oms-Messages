<?php
/**
 * Jingga
 *
 * PHP Version 8.2
 *
 * @package   Modules
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.0
 * @version   1.0.0
 * @link      https://jingga.app
 */
declare(strict_types=1);

use Modules\Messages\Controller\BackendController;
use Modules\Messages\Models\PermissionCategory;
use phpOMS\Account\PermissionType;
use phpOMS\Router\RouteVerb;

return [
    '^/messages/dashboard(\?.*$|$)' => [
        [
            'dest'       => '\Modules\Messages\Controller\BackendController:viewMessageInbox',
            'verb'       => RouteVerb::GET,
            'permission' => [
                'module' => BackendController::NAME,
                'type'   => PermissionType::READ,
                'state'  => PermissionCategory::MESSAGE,
            ],
        ],
    ],
    '^/messages/outbox(\?.*$|$)' => [
        [
            'dest'       => '\Modules\Messages\Controller\BackendController:viewMessageOutbox',
            'verb'       => RouteVerb::GET,
            'permission' => [
                'module' => BackendController::NAME,
                'type'   => PermissionType::READ,
                'state'  => PermissionCategory::MESSAGE,
            ],
        ],
    ],
    '^/messages/trash(\?.*$|$)' => [
        [
            'dest'       => '\Modules\Messages\Controller\BackendController:viewMessageTrash',
            'verb'       => RouteVerb::GET,
            'permission' => [
                'module' => BackendController::NAME,
                'type'   => PermissionType::READ,
                'state'  => PermissionCategory::MESSAGE,
            ],
        ],
    ],
    '^/messages/spam(\?.*$|$)' => [
        [
            'dest'       => '\Modules\Messages\Controller\BackendController:viewMessageSpam',
            'verb'       => RouteVerb::GET,
            'permission' => [
                'module' => BackendController::NAME,
                'type'   => PermissionType::READ,
                'state'  => PermissionCategory::MESSAGE,
            ],
        ],
    ],
    '^/messages/settings(\?.*$|$)' => [
        [
            'dest'       => '\Modules\Messages\Controller\BackendController:viewMessageSettings',
            'verb'       => RouteVerb::GET,
            'permission' => [
                'module' => BackendController::NAME,
                'type'   => PermissionType::READ,
                'state'  => PermissionCategory::MESSAGE,
            ],
        ],
    ],
    '^/messages/template/list(\?.*$|$)' => [
        [
            'dest'       => '\Modules\Messages\Controller\BackendController:viewMessageTemplates',
            'verb'       => RouteVerb::GET,
            'permission' => [
                'module' => BackendController::NAME,
                'type'   => PermissionType::READ,
                'state'  => PermissionCategory::MESSAGE,
            ],
        ],
    ],
    '^/messages/template/view(\?.*$|$)' => [
        [
            'dest'       => '\Modules\Messages\Controller\BackendController:viewMessageTemplate',
            'verb'       => RouteVerb::GET,
            'permission' => [
                'module' => BackendController::NAME,
                'type'   => PermissionType::READ,
                'state'  => PermissionCategory::MESSAGE,
            ],
        ],
    ],
    '^/messages/mail/create(\?.*$|$)' => [
        [
            'dest'       => '\Modules\Messages\Controller\BackendController:viewMessageCreate',
            'verb'       => RouteVerb::GET,
            'permission' => [
                'module' => BackendController::NAME,
                'type'   => PermissionType::CREATE,
                'state'  => PermissionCategory::MESSAGE,
            ],
        ],
    ],
    '^/messages/mail/view(\?.*$|$)' => [
        [
            'dest'       => '\Modules\Messages\Controller\BackendController:viewMessageView',
            'verb'       => RouteVerb::GET,
            'permission' => [
                'module' => BackendController::NAME,
                'type'   => PermissionType::READ,
                'state'  => PermissionCategory::MESSAGE,
            ],
        ],
    ],
    '^/messages/mail/view(\?.*$|$)' => [
        [
            'dest'       => '\Modules\Messages\Controller\BackendController:viewMessageView',
            'verb'       => RouteVerb::GET,
            'permission' => [
                'module' => BackendController::NAME,
                'type'   => PermissionType::READ,
                'state'  => PermissionCategory::MESSAGE,
            ],
        ],
    ],
];
