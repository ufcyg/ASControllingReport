<?php

declare(strict_types=1);

namespace ASControllingReport\ScheduledTask;

use ASControllingReport\Core\Api\ASControllingReportController;
use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepositoryInterface;
use Shopware\Core\Framework\MessageQueue\ScheduledTask\ScheduledTaskHandler;


class ControllingReportTaskHandler extends ScheduledTaskHandler
{
    /** @var ASControllingReportController $controllingReportControler */
    private $controllingReportControler;
    public function __construct(
        EntityRepositoryInterface $scheduledTaskRepository,
        ASControllingReportController $controllingReportControler
    ) {
        $this->controllingReportControler = $controllingReportControler;
        parent::__construct($scheduledTaskRepository);
    }

    public static function getHandledMessages(): iterable
    {
        return [ControllingReportTask::class];
    }

    public function run(): void
    {
        // if today is the first of the month, send report
        if (intval(date("j")) === 1) {
            $this->controllingReportControler->sendReport(Context::createDefaultContext());
        }
    }
}
