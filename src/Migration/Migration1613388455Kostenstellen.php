<?php

declare(strict_types=1);

namespace ASControllingReport\Migration;

use Doctrine\DBAL\Connection;
use Shopware\Core\Framework\Migration\MigrationStep;

class Migration1613388455Kostenstellen extends MigrationStep
{
    public function getCreationTimestamp(): int
    {
        return 1613388455;
    }

    public function update(Connection $connection): void
    {
        $connection->exec("CREATE TABLE IF NOT EXISTS `as_controlling_report_cost_centres` (
            `id`                BINARY(16) NOT NULL,
            `street`            VARCHAR(512) NOT NULL,
            `plz`               VARCHAR(512) NOT NULL,
            `cost_centre_id`    VARCHAR(512) NOT NULL,
            `created_at`        DATETIME(3),
            `updated_at`        DATETIME(3)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");
    }

    public function updateDestructive(Connection $connection): void
    {
        // implement update destructive
    }
}
