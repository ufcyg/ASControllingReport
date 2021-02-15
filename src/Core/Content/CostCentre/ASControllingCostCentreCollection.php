<?php declare(strict_types=1);

namespace ASControllingReport\Core\Content\CostCentre;

use Shopware\Core\Framework\DataAbstractionLayer\EntityCollection;

/**
 * @method void              add(ASControllingCostCentre $entity)
 * @method void              set(string $key, ASControllingCostCentre $entity)
 * @method ASControllingCostCentre[]    getIterator()
 * @method ASControllingCostCentre[]    getElements()
 * @method ASControllingCostCentre|null get(string $key)
 * @method ASControllingCostCentre|null first()
 * @method ASControllingCostCentre|null last()
 */
class ASControllingCostCentreCollection extends EntityCollection
{
    protected function getExpectedClass(): string
    {
        return ASControllingCostCentreEntity::class;
    }
}