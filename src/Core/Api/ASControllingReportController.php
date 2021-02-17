<?php declare(strict_types=1);

namespace ASControllingReport\Core\Api;

use ASControllingReport\Core\Helper\MailServiceHelper;
use ASControllingReport\Core\Content\CostCentre\ASControllingCostCentreEntity;
use DateInterval;
use DateTime;
use Shopware\Core\Checkout\Customer\CustomerEntity;
use Shopware\Core\Checkout\Order\Aggregate\OrderAddress\OrderAddressEntity;
use Shopware\Core\Checkout\Order\Aggregate\OrderCustomer\OrderCustomerEntity;
use Shopware\Core\Checkout\Order\Aggregate\OrderLineItem\OrderLineItemEntity;
use Shopware\Core\Checkout\Order\OrderEntity;
use Shopware\Core\Content\Product\ProductEntity;
use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepositoryInterface;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\DataAbstractionLayer\Search\EntitySearchResult;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\EqualsFilter;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\RangeFilter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Shopware\Core\Framework\Routing\Annotation\RouteScope;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Shopware\Core\System\SystemConfig\SystemConfigService;

/**
 * @RouteScope(scopes={"api"})
 */
class ASControllingReportController extends AbstractController
{
    /** @var string $path */
    private $path;
    /** @var SystemConfigService $systemConfigService */
    private $systemConfigService;
    /** @var MailServiceHelper $mailServiceHelper */
    private $mailServiceHelper;
    
    public function __construct(SystemConfigService $systemConfigService,
                                MailServiceHelper $mailServiceHelper)
    {
        $this->systemConfigService = $systemConfigService;
        $this->mailServiceHelper = $mailServiceHelper;
        $this->path = '../custom/plugins/ASControllingReport/Reports/';
    }

    /**
     * @Route("/api/v{version}/_action/as-controlling-report/dummyRoute", name="api.custom.as_controlling_report.dummyRoute", methods={"POST"})
     * @param Context $context;
     * @return Response
     */
    public function dummyRoute(Context $context): ?Response
    {

        return new Response('',Response::HTTP_NO_CONTENT);
    }

    /**
     * @Route("/api/v{version}/_action/as-controlling-report/addCostCentres", name="api.custom.as_controlling_report.addCostCentres", methods={"POST"})
     * @param Context $context;
     * @return Response
     */
    public function addCostCentres(Context $context): ?Response
    {
        $data = null;
        /** @var EntityRepositoryInterface $costCentresRepository */
        $costCentresRepository = $this->container->get('as_controlling_report_cost_centres.repository'); // get 
        //costcentres
        $c = 0;
        if($this->addCostCentreCk($costCentresRepository, 'Hauptstraße 105'))
        {
            $data[$c] = ['street' => 'Hauptstraße 105', 'plz' => '04416', 'costCentreId' => '50528200'];
            $c++;
        }
        if($this->addCostCentreCk($costCentresRepository, 'Köpenicker Straße 325, Haus 123'))
        {
            $data[$c] = ['street' => 'Köpenicker Straße 325, Haus 123', 'plz' => '12555', 'costCentreId' => '50538200'];
            $c++;
        }
        if($data != null)
            $costCentresRepository->create($data,Context::createDefaultContext());
        
        return new Response('',Response::HTTP_NO_CONTENT);
    }
    private function addCostCentreCk(EntityRepositoryInterface $repo, string $street): bool
    {
        $criteria = new Criteria();
        $criteria->addFilter(new EqualsFilter('street', $street));
        $result = $repo->search($criteria,Context::createDefaultContext());
        
        return count($result) > 0 ? false : true;
    }

    /**
     * @Route("/api/v{version}/_action/as-controlling-report/sendReport", name="api.custom.as_controlling_report.sendReport", methods={"POST"})
     * @param Context $context;
     * @return Response
     */
    public function sendReport(Context $context): ?Response
    {
        $this->generateReport();
        return new Response('',Response::HTTP_NO_CONTENT);
    }
    private function generateReport()
    {
        $reportEntries = null;
        //load orders
        $orderRepository = $this->container->get('order.repository');
        /** @var EntitySearchResult $ordersSearchResult */
        $ordersSearchResult = $this->getOrdersOfMonth($orderRepository); //load all orders of current month

        //load customers
        /** @var EntityRepositoryInterface $orderAddressRepository */
        $customerRepository = $this->container->get('customer.repository');

        //iterate through all orders of the month, first we check if the customer ordering is an internal customer and therefor will be monitored
        foreach($ordersSearchResult as $orderID => $order)
        {
            /** @var CustomerEntity $customer */
            $customer = $this->getCustomerForOrder($customerRepository, $order);

            /** @var string $controlledCustomerGroup */
            $controlledCustomerGroup = $this->systemConfigService->get('ASControllingReport.config.controlledCustomerGroup');
            if($this->customerIsControlled($controlledCustomerGroup,$customer))
            {
                //order is internal, we want to add this order to the report
                
                //load order address repository to compare the address with the possible cost centres
                /** @var EntityRepositoryInterface $orderAddressRepository */
                $orderAddressRepository = $this->container->get('order_address.repository');
                //order line items are unique positions of an order
                /** @var EntityRepositoryInterface $orderLineItemRepository */
                $orderLineItemRepository = $this->container->get('order_line_item.repository');
                //load list of cost centres
                $costCentresRepository = $this->container->get('as_controlling_report_cost_centres.repository');

                $criteria = new Criteria();
                $costCentresSearchResult = $costCentresRepository->search($criteria, Context::createDefaultContext());
                
                $costCentreIdentifier = null;
                $plzMatch = false;
                $streetMatch = false;

                /** @var OrderAddressEntity $orderAddress */
                $orderAddress = $this->getOrderAddressFromOrderID($orderAddressRepository, $orderID);

                $orderStreet = $orderAddress->getStreet();
                $orderPLZ = $orderAddress->getZipcode();
                /** @var ASControllingCostCentreEntity $costCentre */
                foreach($costCentresSearchResult as $costCentreID => $costCentre)
                {
                    $centrePLZ = $costCentre->getPlz();
                    if($centrePLZ == $orderPLZ)
                    {
                        $plzMatch = true;
                    }

                    $centreStreet = $costCentre->getStreet();
                    $equalPosCount = similar_text($centreStreet,$orderStreet,$similarity);

                    if($similarity > .75)
                    {
                        $streetMatch = true;
                    }
                    
                    if($plzMatch && $streetMatch)
                    {
                        $costCentreIdentifier = $costCentre->getCostCentreId();
                        
                        /** @var EntityRepositoryInterface $lineItemRepository */
                        $lineItemRepository = $this->container->get('order_line_item.repository');
                        $orderLineItems = $this->getOrderLineItemsFromOrderID($lineItemRepository, $orderID);
                        /** @var OrderLineItemEntity $orderLineItem */
                        foreach($orderLineItems as $orderLineItemID => $orderLineItem)
                        {
                            if ($orderLineItem->getIdentifier() == 'INTERNAL_DISCOUNT')
                                continue;
                            $productRepository = $this->container->get('product.repository');
                            $productID = $orderLineItem->getProductId();
                            $productEntity = $this->getProductEntityFromID($productRepository,$productID);
                            $reportEntries[] = 
                                                [
                                                    'costCentreFROM' => '50538200',
                                                    'costCentreTO' => $costCentreIdentifier,
                                                    'articleNumber' => $productEntity->getProductNumber(),
                                                    'amount' => $orderLineItem->getQuantity(),
                                                    'unitPrice' => $orderLineItem->getUnitPrice(),
                                                    'bookedPrice' => $orderLineItem->getQuantity()*$orderLineItem->getUnitPrice(),
                                                    'shipmentDate' => '',
                                                    'shipmentID' => ''
                                                ];
                        }
                        break;
                    }
                }
            }
        }
        $this->generateReportCSV($reportEntries);
    }
    private function getOrdersOfMonth(EntityRepositoryInterface $orderRepository): EntitySearchResult
    {
        //define first and last day of the month
        $firstDayUTS = mktime (0, 0, 0, intval(date("n")), 1, intval(date("Y")));
        $lastDayUTS = mktime (0, 0, 0, intval(date("n")), intval(date('t')), intval(date("Y")));
        //generate strings to compare with entries in DB through DBAL
        $firstDay = date("Y-m-d", $firstDayUTS);
        $firstDay = $firstDay . " 00:00:00.000";
        $lastDay = date("Y-m-d", $lastDayUTS);
        $lastDay = $lastDay . " 23:59:59.999";
        //define criteria
        $criteria = new Criteria();
        $criteria->addFilter(new RangeFilter('orderDate', [
            RangeFilter::GTE => $firstDay,
            RangeFilter::LTE => $lastDay
        ]));
        //search for all orders in given timeframe
        /** @var EntitySearchResult $entities */
        $ordersSearchResult = $orderRepository->search($criteria, Context::createDefaultContext()); // this are all orders of the month
        return $ordersSearchResult;
    }
    private function getOrderAddressFromOrderID(EntityRepositoryInterface $orderAddressRepository, string $orderID): ?OrderAddressEntity
    {
        $criteria = new Criteria();
        $criteria->addFilter(new EqualsFilter('orderId', $orderID));

        $searchResult = $orderAddressRepository->search($criteria, Context::createDefaultContext());

        return $searchResult->first();
    }
    private function getOrderLineItemsFromOrderID(EntityRepositoryInterface $orderLineItemRepository, string $orderID): EntitySearchResult
    {
        $criteria = new Criteria();
        $criteria->addFilter(new EqualsFilter('orderId', $orderID));

        return $orderLineItemRepository->search($criteria,Context::createDefaultContext());
    }
    private function getCustomerForOrder(EntityRepositoryInterface $customerRepository, OrderEntity $order): ?CustomerEntity
    {
        /** @var OrderCustomerEntity $orderCustomer */
        $orderCustomer = $order->getOrderCustomer();

        $customerID = $orderCustomer->getCustomerId();

        $criteria = new Criteria();
        $criteria->addFilter(new EqualsFilter('id', $customerID));

        return $customerRepository->search($criteria, Context::createDefaultContext())->first();
    }
    private function getProductEntityFromID(EntityRepositoryInterface $productRepository, $productID): ?ProductEntity
    {
        $criteria = new Criteria();
        $criteria->addFilter(new EqualsFilter('id', $productID));
        return $productRepository->search($criteria,Context::createDefaultContext())->first();
    }
    private function customerIsControlled(string $controlledCustomerGroupID, CustomerEntity $customer): bool
    {
        return $customer->getGroupId() == $controlledCustomerGroupID ? true : false;
    }
    private function generateReportCSV(array $reportArray)
    {
        $reportString = 'Kostenstelle von;Kostenstelle an;Artikelnr.;Menge;Bewertungspreis;Buchungswert;Wert-Datum;SendungsID' . "\n";
        foreach($reportArray as $i => $entry)
        {
            $reportString = $reportString . $entry['costCentreFROM'] . ';' . $entry['costCentreTO'] . ';' . $entry['articleNumber'] . ';' . $entry['amount'] . ';' . $entry['unitPrice'] . ';' . $entry['bookedPrice'] . ';' . $entry['shipmentDate'] . ';' . $entry['shipmentID'] . "\n";
        }

        if (!file_exists($this->path)) {
            mkdir($this->path, 0777, true);
        }

        $filename = $this->path . '/' . 'ControllingReport-' . $this->createDateFromString('now') . '-' . '.csv';
        file_put_contents($filename, $reportString);
    }
    /* Creates a timestamp that will be used to filter by this date */
    public function createDateFromString(string $daytime): string
    {
        $timeStamp = new DateTime();
        $timeStamp->add(DateInterval::createFromDateString($daytime));
        $timeStamp = $timeStamp->format('Y-m-d H:i:s.u');
        $timeStamp = substr($timeStamp, 0, strlen($timeStamp) - 3);

        return $timeStamp;
    }
}