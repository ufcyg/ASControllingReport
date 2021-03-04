<?php declare(strict_types=1);

namespace ASControllingReport\Core\Content\ReportingData;

use Shopware\Core\Framework\DataAbstractionLayer\EntityDefinition;
use Shopware\Core\Framework\DataAbstractionLayer\Field\DateField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\PrimaryKey;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\Required;
use Shopware\Core\Framework\DataAbstractionLayer\Field\FloatField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\IdField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\IntField;
use Shopware\Core\Framework\DataAbstractionLayer\FieldCollection;
use Shopware\Core\Framework\DataAbstractionLayer\Field\StringField;

class ASControllingReportingDataDefinition extends EntityDefinition
{

    public function getEntityName(): string
    {
        return 'as_controlling_reporting_data';
    }

    public function getCollectionClass(): string
    {
        return ASControllingReportingDataCollection::class;
    }

    public function getEntityClass(): string
    {
        return ASControllingReportingDataEntity::class;
    }

    protected function defineFields(): FieldCollection
    {
        return new FieldCollection(
            [
                (new IdField('id','id'))->addFlags(new Required(), new PrimaryKey()),
                new StringField('cost_centre_from','costCentreFrom'),
                new StringField('cost_centre_to','costCentreTo'),
                new StringField('article_number','articleNumber'),
                new IntField('amount','amount'),
                new FloatField('unit_price','unitPrice'),
                new StringField('shipment_date','shipmentDate'),
                new StringField('shipment_id','shipmentId')
            ]
        );
    }
}