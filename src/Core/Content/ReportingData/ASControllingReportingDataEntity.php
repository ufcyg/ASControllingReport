<?php declare(strict_types=1);

namespace ASControllingReport\Core\Content\ReportingData;

use Shopware\Core\Framework\DataAbstractionLayer\Entity;
use Shopware\Core\Framework\DataAbstractionLayer\EntityIdTrait;

class ASControllingReportingDataEntity extends Entity
{
    use EntityIdTrait;
    
    /** @var string */
    protected $costCentreFrom;
    /** @var string */
    protected $costCentreTo;
    /** @var string */
    protected $articleNumber;
    /** @var int */
    protected $amount;
    /** @var float */
    protected $unitPrice;
    /** @var string */
    protected $shipmentDate;
    /** @var string */
    protected $shipmentId;

    /** Get the value of costCentreFrom */ 
    public function getCostCentreFrom() { return $this->costCentreFrom; }

    /** Set the value of costCentreFrom @return  self */ 
    public function setCostCentreFrom($costCentreFrom)
    {
        $this->costCentreFrom = $costCentreFrom;
        return $this;
    }

    /** Get the value of costCentreTo */ 
    public function getCostCentreTo() { return $this->costCentreTo; }

    /** Set the value of costCentreTo @return  self */ 
    public function setCostCentreTo($costCentreTo)
    {
        $this->costCentreTo = $costCentreTo;
        return $this;
    }

    /** Get the value of articleNumber */ 
    public function getArticleNumber() { return $this->articleNumber; }

    /** Set the value of articleNumber @return  self */ 
    public function setArticleNumber($articleNumber)
    {
        $this->articleNumber = $articleNumber;
        return $this;
    }

    /** Get the value of amount */ 
    public function getAmount() { return $this->amount; }

    /** Set the value of amount @return  self */ 
    public function setAmount($amount)
    {
        $this->amount = $amount;
        return $this;
    }

    /** Get the value of unitPrice */ 
    public function getUnitPrice() { return $this->unitPrice; }

    /** Set the value of unitPrice @return  self */ 
    public function setUnitPrice($unitPrice)
    {
        $this->unitPrice = $unitPrice;
        return $this;
    }

    /** Get the value of unitPrice */ 
    public function getBookedPrice() { return $this->unitPrice * $this->amount; }

    /** Get the value of shipmentDate */ 
    public function getShipmentDate() { return $this->shipmentDate; }

    /** Set the value of shipmentDate @return  self */ 
    public function setShipmentDate($shipmentDate)
    {
        $this->shipmentDate = $shipmentDate;
        return $this;
    }

    /** Get the value of shipmentId */ 
    public function getShipmentId() { return $this->shipmentId; }

    /** Set the value of shipmentId @return  self */ 
    public function setShipmentId($shipmentId)
    {
        $this->shipmentId = $shipmentId;
        return $this;
    }
}