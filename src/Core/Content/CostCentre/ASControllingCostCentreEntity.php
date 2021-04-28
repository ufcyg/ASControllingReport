<?php

declare(strict_types=1);

namespace ASControllingReport\Core\Content\CostCentre;

use Shopware\Core\Framework\DataAbstractionLayer\Entity;
use Shopware\Core\Framework\DataAbstractionLayer\EntityIdTrait;

class ASControllingCostCentreEntity extends Entity
{
    use EntityIdTrait;

    /** @var string */
    protected $street;
    /** @var string */
    protected $plz;
    /** @var string */
    protected $costCentreId;

    /** Get the value of street */
    public function getStreet()
    {
        return $this->street;
    }

    /** Set the value of street @return  self */
    public function setStreet($street)
    {
        $this->street = $street;

        return $this;
    }

    /** Get the value of plz */
    public function getPlz()
    {
        return $this->plz;
    }

    /** Set the value of plz @return  self */
    public function setPlz($plz)
    {
        $this->plz = $plz;

        return $this;
    }

    /** Get the value of costCentreId */
    public function getCostCentreId()
    {
        return $this->costCentreId;
    }

    /** Set the value of costCentreId @return  self */
    public function setCostCentreId($costCentreId)
    {
        $this->costCentreId = $costCentreId;

        return $this;
    }
}
