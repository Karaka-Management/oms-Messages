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

namespace Modules\Messages\Controller;

use Modules\Admin\Models\NullAccount;
use Modules\Media\Models\MediaMapper;
use Modules\Messages\Models\Email;
use Modules\Messages\Models\EmailL11n;
use Modules\Messages\Models\EmailL11nMapper;
use Modules\Messages\Models\EmailMapper;
use phpOMS\Localization\ISO639x1Enum;
use phpOMS\Message\Http\RequestStatusCode;
use phpOMS\Message\RequestAbstract;
use phpOMS\Message\ResponseAbstract;

/**
 * Media class.
 *
 * @package Modules\Messages
 * @license OMS License 2.0
 * @link    https://jingga.app
 * @since   1.0.0
 *
 * @todo Implement general email header & footer which can be used by all templates
 *      Load normal template
 *      Replace {header_template}
 *      Replace {footer_template}
 */
final class ApiController extends Controller
{
    /**
     * Api method to create tag
     *
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param array            $data     Generic data
     *
     * @return void
     *
     * @api
     *
     * @since 1.0.0
     */
    public function apiEmailCreate(RequestAbstract $request, ResponseAbstract $response, array $data = []) : void
    {
        $email = $this->createEmailFromRequest($request);
        $this->createModel($request->header->account, $email, EmailMapper::class, 'email', $request->getOrigin());
        $this->createStandardCreateResponse($request, $response, $email);
    }

    /**
     * Api method to create tag
     *
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param array            $data     Generic data
     *
     * @return void
     *
     * @api
     *
     * @since 1.0.0
     */
    public function apiMediaEmailSend(RequestAbstract $request, ResponseAbstract $response, array $data = []) : void
    {
        $email = $request->getDataString('email');

        $media = $data['media'] ?? MediaMapper::get()
            ->where('id', (int) $request->getData('id'))
            ->execute();

        /** @var \Model\Setting $template */
        $template = $this->app->appSettings->get(
            names: (string) $request->getDataString('template')
        );

        $handler = $this->app->moduleManager->get('Admin', 'Api')->setUpServerMailHandler();

        $mail = EmailMapper::get()
            ->with('l11n')
            ->where('id', $template)
            ->where('l11n/language', $response->header->l11n->language)
            ->execute();

        $status = false;
        if ($mail->id !== 0) {
            $status = $this->app->moduleManager->get('Admin', 'Api')->setupEmailDefaults($mail, $response->header->l11n->language);
        }

        $mail->addTo($email);
        $mail->addAttachment($media->getAbsolutePath(), $media->name);

        if ($status) {
            $status = $handler->send($mail);
        }

        if (!$status) {
            \phpOMS\Log\FileLogger::getInstance()->error(
                \phpOMS\Log\FileLogger::MSG_FULL, [
                    'message' => 'Couldn\'t send bill media: ' . $media->id,
                    'line'    => __LINE__,
                    'file'    => self::class,
                ]
            );
        }
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

        $email->isTemplate = $request->getDataBool('template') ?? false;

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

        if ($request->hasData('body')) {
            if ($request->getDataBool('ishtml') ?? false) {
                $email->msgHTML($request->getDataString('body') ?? '');
            } else {
                $email->body = $request->getDataString('body') ?? '';
            }
        }

        $email->bodyAlt = $request->getDataString('bodyalt') ?? '';

        return $email;
    }

    /**
     * Api method to create item l11n
     *
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param array            $data     Generic data
     *
     * @return void
     *
     * @api
     *
     * @since 1.0.0
     */
    public function apiEmailL11nCreate(RequestAbstract $request, ResponseAbstract $response, array $data = []) : void
    {
        if (!empty($val = $this->validateEmailL11nCreate($request))) {
            $response->header->status = RequestStatusCode::R_400;
            $this->createInvalidCreateResponse($request, $response, $val);

            return;
        }

        $emailL11n = $this->createEmailL11nFromRequest($request);
        $this->createModel($request->header->account, $emailL11n, EmailL11nMapper::class, 'message_l11n', $request->getOrigin());
        $this->createStandardCreateResponse($request, $response, $emailL11n);
    }

    /**
     * Method to create item l11n from request.
     *
     * @param RequestAbstract $request Request
     *
     * @return EmailL11n
     *
     * @since 1.0.0
     */
    private function createEmailL11nFromRequest(RequestAbstract $request) : EmailL11n
    {
        $itemL11n           = new EmailL11n();
        $itemL11n->email    = $request->getDataInt('email') ?? 0;
        $itemL11n->language = ISO639x1Enum::tryFromValue($request->getDataString('language')) ?? $request->header->l11n->language;
        $itemL11n->subject  = $request->getDataString('subject') ?? '';
        $itemL11n->body     = $request->getDataString('body') ?? '';
        $itemL11n->bodyAlt  = $request->getDataString('bodyalt') ?? '';

        return $itemL11n;
    }

    /**
     * Validate item l11n create request
     *
     * @param RequestAbstract $request Request
     *
     * @return array<string, bool>
     *
     * @since 1.0.0
     */
    private function validateEmailL11nCreate(RequestAbstract $request) : array
    {
        $val = [];
        if (($val['email'] = !$request->hasData('email'))
        ) {
            return $val;
        }

        return [];
    }
}
