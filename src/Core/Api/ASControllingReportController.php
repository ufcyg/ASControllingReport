<?php declare(strict_types=1);

namespace ASDispositionControl\Core\Api;

use ASDispositionControl\Core\Utilities\MailServiceHelper;
use Shopware\Core\Framework\Context;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Shopware\Core\Framework\Routing\Annotation\RouteScope;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Shopware\Core\System\SystemConfig\SystemConfigService;

/**
 * @RouteScope(scopes={"api"})
 */
class ASControllingReportController extends AbstractController
{
    /** @var SystemConfigService $systemConfigService */
    private $systemConfigService;
    /** @var MailServiceHelper $mailServiceHelper */
    private $mailServiceHelper;
    
    public function __construct(SystemConfigService $systemConfigService,
                                MailServiceHelper $mailServiceHelper)
    {
        $this->systemConfigService = $systemConfigService;
        $this->mailServiceHelper = $mailServiceHelper;
    }

    /**
     * @Route("/api/v{version}/_action/as-controlling-report/dummyRoute", name="api.custom.as_controlling_report.dummyRoute", methods={"POST"})
     * @param Context $context;
     * @return Response
     */
    public function dummyRoute(Context $context): ?Response
    {
        
        return new Response('',Response::HTTP_NO_CONTENT);
    }
}