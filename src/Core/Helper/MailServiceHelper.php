<?php declare(strict_types=1);
namespace ASControllingReport\Core\Helper;

use Shopware\Core\Content\MailTemplate\Service\MailService;
use Shopware\Core\Framework\Context;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBag;

/*

Contains the mail service and dispatches requested eMails

*/
class MailServiceHelper
{
    /** @var MailService $mailserviceInterface */
    private $mailservice;
    public function __construct(MailService $mailservice)
    {
        $this->mailservice = $mailservice;
    }

    public function sendMyMail(string $mailaddress, $recipientName ,$salesChannelID, string $subject, string $notificationPlain, string $notificationHTML): void
    {
        $data = new ParameterBag();
        $data->set(
            'recipients',
            [
                $mailaddress => $recipientName
            ]
        );

        $data->set('senderName', 'ControllingReport');

        $data->set('contentHtml', $notificationHTML);
        $data->set('contentPlain', $notificationPlain);
        $data->set('subject', $subject);
        $data->set('salesChannelId', $salesChannelID);

        $this->mailservice->send(
            $data->all(),
            Context::createDefaultContext()
        );
    }
}