<?php declare(strict_types=1);

namespace ASControllingReport\Core\Content\ReportingData;

use Shopware\Core\Framework\DataAbstractionLayer\EntityCollection;

/**
 * @method void              add(ASControllingReportingData $entity)
 * @method void              set(string $key, ASControllingReportingData $entity)
 * @method ASControllingReportingData[]    getIterator()
 * @method ASControllingReportingData[]    getElements()
 * @method ASControllingReportingData|null get(string $key)
 * @method ASControllingReportingData|null first()
 * @method ASControllingReportingData|null last()
 */
class ASControllingReportingDataCollection extends EntityCollection
{
    protected function getExpectedClass(): string
    {
        return ASControllingReportingDataEntity::class;
    }
}