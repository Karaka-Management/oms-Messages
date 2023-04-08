<?php
/**
 * Karaka
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

namespace Modules\Messages\Controller;

use Modules\Admin\Models\NullAccount;
use Modules\Messages\Models\Email;
use Modules\Messages\Models\EmailMapper;
use phpOMS\Message\Http\RequestStatusCode;
use phpOMS\Message\NotificationLevel;
use phpOMS\Message\RequestAbstract;
use phpOMS\Message\ResponseAbstract;
use phpOMS\Model\Message\FormValidation;

/**
 * Media class.
 *
 * @package Modules\Messages
 * @license OMS License 2.0
 * @link    https://jingga.app
 * @since   1.0.0
 */
final class ApiController extends Controller
{

    /**
     * Api method to create tag
     *
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param mixed            $data     Generic data
     *
     * @return void
     *
     * @api
     *
     * @since 1.0.0
     */
    public function apiEmailCreate(RequestAbstract $request, ResponseAbstract $response, mixed $data = null) : void
    {
        if (!empty($val = $this->validateEmailCreate($request))) {
            $response->set('email_create', new FormValidation($val));
            $response->header->status = RequestStatusCode::R_400;

            return;
        }

        $email = $this->createEmailFromRequest($request);
        $this->createModel($request->header->account, $email, EmailMapper::class, 'email', $request->getOrigin());

        $this->fillJsonResponse($request, $response, NotificationLevel::OK, 'Email', 'Email successfully created', $email);
    }

    /**
     * Validate email create request
     *
     * @param RequestAbstract $request Request
     *
     * @return array<string, bool>
     *
     * @since 1.0.0
     */
    private function validateEmailCreate(RequestAbstract $request) : array
    {
        $val = [];
        if (($val['subject'] = !$request->hasData('subject'))
            || ($val['body'] = !$request->hasData('body'))
        ) {
            return $val;
        }

        return [];
    }

    /**
     * Method to create email from request.
     *
     * @param RequestAbstract $request Request
     *
     * @return Email
     *
     * @since 1.0.0
     */
    private function createEmailFromRequest(RequestAbstract $request) : Email
    {
        $email = new Email();

        if ($request->hasData('from')) {
            $from = $request->getDataJson('from');
            $email->setFrom($from['address'] ?? '', $from['name'] ?? '');
        }

        if ($request->hasData('to')) {
            $tos = $request->getDataJson('to');

            foreach ($tos as $to) {
                $email->addTo($to['address'] ?? '', $to['name'] ?? '');
            }
        }

        if ($request->hasData('cc')) {
            $ccs = $request->getDataJson('cc');

            foreach ($ccs as $cc) {
                $email->addCC($cc['address'] ?? '', $cc['name'] ?? '');
            }
        }

        if ($request->hasData('bcc')) {
            $bccs = $request->getDataJson('bcc');

            foreach ($bccs as $bcc) {
                $email->addBCC($bcc['address'] ?? '', $bcc['name'] ?? '');
            }
        }

        $email->account = new NullAccount($request->getDataInt('account') ?? $request->header->account);

        $email->setHtml($request->getDataBool('ishtml') ?? false);

        $email->subject = $request->getDataString('subject') ?? '';

        if ($request->getDataBool('ishtml') ?? false) {
            $email->msgHTML($request->getDataString('body') ?? '');
        } else {
            $email->body = $request->getDataString('body') ?? '';
        }

        $email->bodyAlt = $request->getDataString('bodyalt') ?? '';

        return $email;
    }
}
