<?php declare(strict_types=1);

namespace ASControllingReport\ScheduledTask;

use Shopware\Core\Framework\MessageQueue\ScheduledTask\ScheduledTask;

class ControllingReportTask extends ScheduledTask
{
    public static function getTaskName(): string
    {
        return 'as.controlling_report_task';
    }

    public static function getDefaultInterval(): int
    {
        return 86340; // 24 hours
    }
}