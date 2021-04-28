<?php

declare(strict_types=1);

namespace ASControllingReport\Migration;

use Doctrine\DBAL\Connection;
use Shopware\Core\Framework\Migration\MigrationStep;

class Migration1614685573ControllingReportingData extends MigrationStep
{
    public function getCreationTimestamp(): int
    {
        return 1614685573;
    }

    public function update(Connection $connection): void
    {
        $connection->exec("CREATE TABLE IF NOT EXISTS `as_controlling_reporting_data` (
            `id`                BINARY(16) NOT NULL,
            `cost_centre_from`  VARCHAR(512) NOT NULL,
            `cost_centre_to`    VARCHAR(512) NOT NULL,
            `article_number`    VARCHAR(512) NOT NULL,
            `amount`            INTEGER NOT NULL,
            `unit_price`        FLOAT NOT NULL,
            `shipment_date`     VARCHAR(512) NOT NULL,
            `shipment_id`       VARCHAR(512) NOT NULL,
            `created_at`        DATETIME(3),
            `updated_at`        DATETIME(3)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");
    }

    public function updateDestructive(Connection $connection): void
    {
        // implement update destructive
    }
}
