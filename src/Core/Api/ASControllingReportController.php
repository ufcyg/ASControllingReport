<?php

declare(strict_types=1);

namespace ASControllingReport\Core\Api;

use ASControllingReport\Core\Content\CostCentre\ASControllingCostCentreEntity;
use ASControllingReport\Core\Content\ReportingData\ASControllingReportingDataEntity;
use ASMailService\Core\MailServiceHelper;
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
    /** @var string $senderName */
    private $senderName;
    public function __construct(
        SystemConfigService $systemConfigService,
        MailServiceHelper $mailServiceHelper
    ) {
        $this->systemConfigService = $systemConfigService;
        $this->mailServiceHelper = $mailServiceHelper;
        $this->path = $this->systemConfigService->get('ASControllingReport.config.workingDirectory');
        $this->senderName = 'Controlling Report';
    }

    /**
     * @Route("/api/v{version}/_action/as-controlling-report/dummyRoute", name="api.custom.as_controlling_report.dummyRoute", methods={"POST"})
     * @param Context $context;
     * @return Response
     */
    public function dummyRoute(Context $context): ?Response
    {


        return new Response('', Response::HTTP_NO_CONTENT);
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
        if ($this->addCostCentreCk($costCentresRepository, 'Gubenerstraße 39')) {
            $data[$c] = ['street' => 'Gubenerstraße 39', 'plz' => '86156', 'costCentreId' => '50518200'];
            $c++;
        }
        if ($this->addCostCentreCk($costCentresRepository, 'Hauptstraße 105')) {
            $data[$c] = ['street' => 'Hauptstraße 105', 'plz' => '04416', 'costCentreId' => '50528200'];
            $c++;
        }
        if ($this->addCostCentreCk($costCentresRepository, 'Köpenicker Straße 325, Haus 123')) {
            $data[$c] = ['street' => 'Köpenicker Straße 325, Haus 123', 'plz' => '12555', 'costCentreId' => '50538200'];
            $c++;
        }
        if ($this->addCostCentreCk($costCentresRepository, 'Turmstraße 21, Haus M Eingang O')) {
            $data[$c] = ['street' => 'Turmstraße 21, Haus M Eingang O', 'plz' => '10559', 'costCentreId' => '50548200'];
            $c++;
        }
        if ($this->addCostCentreCk($costCentresRepository, 'Otto-Hahn-Straße 18')) {
            $data[$c] = ['street' => 'Otto-Hahn-Straße 18', 'plz' => '76275', 'costCentreId' => '50558200'];
            $c++;
        }
        if ($this->addCostCentreCk($costCentresRepository, 'Pettenkoferstraße 1c')) {
            $data[$c] = ['street' => 'Pettenkoferstraße 1c', 'plz' => '87439', 'costCentreId' => '50568200'];
            $c++;
        }
        if ($this->addCostCentreCk($costCentresRepository, 'Celtestraße 1')) {
            $data[$c] = ['street' => 'Celtestraße 1', 'plz' => '85051', 'costCentreId' => '50588200'];
            $c++;
        }
        if ($this->addCostCentreCk($costCentresRepository, 'Zur Kesselschmiede 4')) {
            $data[$c] = ['street' => 'Zur Kesselschmiede 4', 'plz' => '92637', 'costCentreId' => '50618200'];
            $c++;
        }
        if ($this->addCostCentreCk($costCentresRepository, 'Höhenstraße 24')) {
            $data[$c] = ['street' => 'Höhenstraße 24', 'plz' => '70736', 'costCentreId' => '50648200'];
            $c++;
        }
        if ($this->addCostCentreCk($costCentresRepository, 'Industriestraße 300 Gebäude CPK 2703')) {
            $data[$c] = ['street' => 'Industriestraße 300 Gebäude CPK 2703', 'plz' => '50354', 'costCentreId' => '50658200'];
            $c++;
        }
        if ($this->addCostCentreCk($costCentresRepository, 'Paracelsusstraße 13')) {
            $data[$c] = ['street' => 'Paracelsusstraße 13', 'plz' => '51375', 'costCentreId' => '50718200'];
            $c++;
        }
        if ($this->addCostCentreCk($costCentresRepository, 'Bayerstraße 53')) {
            $data[$c] = ['street' => 'Bayerstraße 53', 'plz' => '80335', 'costCentreId' => '50778200'];
            $c++;
        }
        if ($this->addCostCentreCk($costCentresRepository, 'Frillendorfer Straße 154')) {
            $data[$c] = ['street' => 'Frillendorfer Straße 154', 'plz' => '45139', 'costCentreId' => '50788200'];
            $c++;
        }
        if ($this->addCostCentreCk($costCentresRepository, 'Orlaweg 2')) {
            $data[$c] = ['street' => 'Orlaweg 2', 'plz' => '07743', 'costCentreId' => '50798200'];
            $c++;
        }
        if ($this->addCostCentreCk($costCentresRepository, 'Südstraße 7')) {
            $data[$c] = ['street' => 'Südstraße 7', 'plz' => '03130', 'costCentreId' => '50808200'];
            $c++;
        }
        if ($this->addCostCentreCk($costCentresRepository, 'An der Hüls 183')) {
            $data[$c] = ['street' => 'An der Hüls 183', 'plz' => '52068', 'costCentreId' => '50878200'];
            $c++;
        }
        if ($this->addCostCentreCk($costCentresRepository, 'Hans-Inderfurth-Straße 1')) {
            $data[$c] = ['street' => 'Hans-Inderfurth-Straße 1', 'plz' => '77933', 'costCentreId' => '50908200'];
            $c++;
        }

        if ($data != null)
            $costCentresRepository->create($data, Context::createDefaultContext());

        return new Response('', Response::HTTP_NO_CONTENT);
    }
    private function addCostCentreCk(EntityRepositoryInterface $repo, string $street): bool
    {
        $criteria = new Criteria();
        $criteria->addFilter(new EqualsFilter('street', $street));
        $result = $repo->search($criteria, Context::createDefaultContext());

        return count($result) > 0 ? false : true;
    }

    /**
     * @Route("/api/v{version}/_action/as-controlling-report/sendReport", name="api.custom.as_controlling_report.sendReport", methods={"POST"})
     * @param Context $context;
     * @return Response
     */
    public function sendReport(Context $context): ?Response
    {
        $reportArray = null;
        $fallbackChannel = $this->systemConfigService->get('ASControllingReport.config.fallbackSaleschannelNotification');
        $controllingDataRepo = $this->container->get('as_controlling_reporting_data.repository');

        $reportEntities = $this->getEntitiesOfTheMonth($controllingDataRepo, 'createdAt');
        /** @var ASControllingReportingDataEntity $reportEntity */
        foreach ($reportEntities as $reportEntityID => $reportEntity) {
            $reportArray[] =
                [
                    'costCentreFROM' => '50538200',
                    'costCentreTO' => $reportEntity->getCostCentreTo(),
                    'articleNumber' => $reportEntity->getArticleNumber(),
                    'amount' => $reportEntity->getAmount(),
                    'unitPrice' => $reportEntity->getUnitPrice(),
                    'bookedPrice' => $reportEntity->getBookedPrice(),
                    'shipmentDate' => $reportEntity->getShipmentDate(),
                    'shipmentID' => $reportEntity->getShipmentId()
                ];
        }
        if ($reportArray == null)
            return new Response('', Response::HTTP_NO_CONTENT);;
        $filename = $this->generateReportCSV($reportArray);

        $recipientsList = $this->systemConfigService->get('ASControllingReport.config.reportRecipients');
        $recipientsList = explode(';', $recipientsList);
        for ($i = 0; $i < count($recipientsList); $i++) {
            $name = $recipientsList[$i];
            $i++;
            $mail = $recipientsList[$i];

            $recipients[$mail] = $name;
        }
        $this->mailServiceHelper->sendMyMail($recipients, $fallbackChannel, $this->senderName, $this->senderName, 'Hello<br><br>Enclosed you will find the monthly report for the eShop (www.zpmv-pmo.de) to download.<br><br>Have a nice day.', 'Hello<br><br>Enclosed you will find the monthly report for the eShop (www.zpmv-pmo.de) to download.<br><br>Have a nice day.', [$filename]);
        return new Response('', Response::HTTP_NO_CONTENT);
    }
    public function generateControllingEntityFromVLE(array $contentLine)
    {
        $reportEntries = null;
        /** @var EntityRepositoryInterface $orderRepository */
        $orderRepository = $this->container->get('order.repository');
        $criteria = new Criteria();
        $criteria->addFilter(new EqualsFilter('orderNumber', $contentLine[1]));

        /** @var OrderEntity $order */
        $order = $orderRepository->search($criteria, Context::createDefaultContext())->first();

        $orderID = $order->getId();


        $customerRepository = $this->container->get('customer.repository');
        /** @var CustomerEntity $customer */
        $customer = $this->getCustomerForOrder($customerRepository, $order);

        /** @var string $controlledCustomerGroup */
        $controlledCustomerGroup = $this->systemConfigService->get('ASControllingReport.config.controlledCustomerGroup');
        if ($this->customerIsControlled($controlledCustomerGroup, $customer)) {
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
            foreach ($costCentresSearchResult as $costCentreID => $costCentre) {
                $centrePLZ = $costCentre->getPlz();
                if ($centrePLZ == $orderPLZ) {
                    $plzMatch = true;
                }

                $centreStreet = $costCentre->getStreet();
                $equalPosCount = similar_text($centreStreet, $orderStreet, $similarity);

                if ($similarity > 75) {
                    $streetMatch = true;
                }

                if ($plzMatch && $streetMatch) {
                    $entityFound = false;
                    $costCentreIdentifier = $costCentre->getCostCentreId();

                    /** @var EntityRepositoryInterface $lineItemRepository */
                    $lineItemRepository = $this->container->get('order_line_item.repository');
                    $orderLineItems = $this->getOrderLineItemsFromOrderID($lineItemRepository, $orderID);
                    /** @var OrderLineItemEntity $orderLineItem */
                    foreach ($orderLineItems as $orderLineItemID => $orderLineItem) {
                        if ($orderLineItem->getIdentifier() == 'INTERNAL_DISCOUNT')
                            continue;
                        $productRepository = $this->container->get('product.repository');
                        $productID = $orderLineItem->getProductId();
                        $productEntity = $this->getProductEntityFromID($productRepository, $productID);
                        if ($productEntity->getProductNumber() == $contentLine[5]) {
                            $entityFound = true;
                            break;
                        }
                    }
                    if ($entityFound) {
                        $reportEntries[] =
                            [
                                'costCentreFrom' => '50538200',
                                'costCentreTo' => $costCentreIdentifier,
                                'articleNumber' => $productEntity->getProductNumber(),
                                'amount' => intval($contentLine[6]),
                                'unitPrice' => $orderLineItem->getUnitPrice(),
                                'shipmentDate' => $this->createDateFromString('now'),
                                'shipmentId' => $contentLine[9]
                            ];
                        break;
                    }
                }
            }
        }
        /** @var EntityRepositoryInterface $reportingDataRepository */
        $reportingDataRepository = $this->container->get('as_controlling_reporting_data.repository');
        $criteria = new Criteria();
        $criteria->addFilter(new EqualsFilter('shipmentId', $contentLine[9]));
        $searchResult = $reportingDataRepository->search($criteria, Context::createDefaultContext());
        if (count($searchResult) != 0)
            return;
        if ($reportEntries != null)
            $reportingDataRepository->create($reportEntries, Context::createDefaultContext());
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
        foreach ($ordersSearchResult as $orderID => $order) {
            /** @var CustomerEntity $customer */
            $customer = $this->getCustomerForOrder($customerRepository, $order);

            /** @var string $controlledCustomerGroup */
            $controlledCustomerGroup = $this->systemConfigService->get('ASControllingReport.config.controlledCustomerGroup');
            if ($this->customerIsControlled($controlledCustomerGroup, $customer)) {
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
                foreach ($costCentresSearchResult as $costCentreID => $costCentre) {
                    $centrePLZ = $costCentre->getPlz();
                    if ($centrePLZ == $orderPLZ) {
                        $plzMatch = true;
                    }

                    $centreStreet = $costCentre->getStreet();
                    $equalPosCount = similar_text($centreStreet, $orderStreet, $similarity);

                    if ($similarity > .75) {
                        $streetMatch = true;
                    }

                    if ($plzMatch && $streetMatch) {
                        $costCentreIdentifier = $costCentre->getCostCentreId();

                        /** @var EntityRepositoryInterface $lineItemRepository */
                        $lineItemRepository = $this->container->get('order_line_item.repository');
                        $orderLineItems = $this->getOrderLineItemsFromOrderID($lineItemRepository, $orderID);
                        /** @var OrderLineItemEntity $orderLineItem */
                        foreach ($orderLineItems as $orderLineItemID => $orderLineItem) {
                            if ($orderLineItem->getIdentifier() == 'INTERNAL_DISCOUNT')
                                continue;
                            $productRepository = $this->container->get('product.repository');
                            $productID = $orderLineItem->getProductId();
                            $productEntity = $this->getProductEntityFromID($productRepository, $productID);
                            $reportEntries[] =
                                [
                                    'costCentreFROM' => '50538200',
                                    'costCentreTO' => $costCentreIdentifier,
                                    'articleNumber' => $productEntity->getProductNumber(),
                                    'amount' => $orderLineItem->getQuantity(),
                                    'unitPrice' => $orderLineItem->getUnitPrice(),
                                    'bookedPrice' => $orderLineItem->getQuantity() * $orderLineItem->getUnitPrice(),
                                    'shipmentDate' => '',
                                    'shipmentID' => ''
                                ];
                        }
                        break;
                    }
                }
            }
        }
        return $reportEntries;
    }
    private function getOrdersOfMonth(EntityRepositoryInterface $orderRepository): EntitySearchResult
    {
        //define first and last day of the month
        $firstDayUTS = mktime(0, 0, 0, intval(date("n")), 1, intval(date("Y")));
        $lastDayUTS = mktime(0, 0, 0, intval(date("n")), intval(date('t')), intval(date("Y")));
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

        return $orderLineItemRepository->search($criteria, Context::createDefaultContext());
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
        return $productRepository->search($criteria, Context::createDefaultContext())->first();
    }
    private function customerIsControlled(string $controlledCustomerGroupID, CustomerEntity $customer): bool
    {
        return $customer->getGroupId() == $controlledCustomerGroupID ? true : false;
    }
    private function generateReportCSV(array $reportArray): string
    {
        $reportString = 'Kostenstelle von;Kostenstelle an;Artikelnr.;Menge;Bewertungspreis;Buchungswert;Wert-Datum;SendungsID' . "\n";
        foreach ($reportArray as $i => $entry) {
            $reportString = $reportString . $entry['costCentreFROM'] . ';' . $entry['costCentreTO'] . ';' . $entry['articleNumber'] . ';' . str_replace('.', ',', $entry['amount']) . ';' . str_replace('.', ',', $entry['unitPrice']) . ';' . str_replace('.', ',', $entry['bookedPrice']) . ';' . str_replace(' ', '_', $entry['shipmentDate']) . ';' . $entry['shipmentID'] . "\n";
        }

        if (!file_exists($this->path)) {
            mkdir($this->path, 0777, true);
        }

        $filename = $this->path . 'ControllingReport-' . $this->createDateFromString('now') . '.csv';
        file_put_contents($filename, $reportString);
        return $filename;
    }
    private function getEntitiesOfTheMonth(EntityRepositoryInterface $repository, string $fieldname): EntitySearchResult
    {
        $monthOffset = 1;
        //define first and last day of the month
        $firstDayUTS = mktime(0, 0, 0, intval(date("n")) - $monthOffset, 1, intval(date("Y")));
        $lastDayUTS = mktime(0, 0, 0, intval(date("n")) - $monthOffset, cal_days_in_month(CAL_GREGORIAN, intval(date("n")) - $monthOffset, intval(date("Y"))), intval(date("Y")));
        //generate strings to compare with entries in DB through DBAL
        $firstDay = date("Y-m-d", $firstDayUTS);
        $firstDay = $firstDay . " 00:00:00.000";
        $lastDay = date("Y-m-d", $lastDayUTS);
        $lastDay = $lastDay . " 23:59:59.999";
        //define criteria
        $criteria = new Criteria();
        $criteria->addFilter(new RangeFilter($fieldname, [
            RangeFilter::GTE => $firstDay,
            RangeFilter::LTE => $lastDay
        ]));
        //search for all orders in given timeframe
        /** @var EntitySearchResult $entities */
        $ordersSearchResult = $repository->search($criteria, Context::createDefaultContext()); // this are all orders of the month
        return $ordersSearchResult;
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
