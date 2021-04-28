<?php

declare(strict_types=1);

namespace ASControllingReport\Core\Content\CostCentre;

use Shopware\Core\Framework\DataAbstractionLayer\EntityDefinition;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\PrimaryKey;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\Required;
use Shopware\Core\Framework\DataAbstractionLayer\Field\IdField;
use Shopware\Core\Framework\DataAbstractionLayer\FieldCollection;
use Shopware\Core\Framework\DataAbstractionLayer\Field\StringField;

class ASControllingCostCentreDefinition extends EntityDefinition
{

    public function getEntityName(): string
    {
        return 'as_controlling_report_cost_centres';
    }

    public function getCollectionClass(): string
    {
        return ASControllingCostCentreCollection::class;
    }

    public function getEntityClass(): string
    {
        return ASControllingCostCentreEntity::class;
    }

    protected function defineFields(): FieldCollection
    {
        return new FieldCollection(
            [
                (new IdField('id', 'id'))->addFlags(new Required(), new PrimaryKey()),
                new StringField('street', 'street'),
                new StringField('plz', 'plz'),
                new StringField('cost_centre_id', 'costCentreId'),
            ]
        );
    }
}
