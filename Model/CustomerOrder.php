<?php
namespace MagentoEse\MyAccountWidget\Model;
class CustomerOrder
{
    /**
     * @var \Magento\Customer\Model\Session
     */
    protected $session;

    /**
    * @var \Magento\Sales\Model\ResourceModel\Order\CollectionFactoryInterface
    */
    protected $orders;

    /**
     * @var \Magento\CompanyCredit\Api\CreditLimitManagementInterface
     */
    protected $creditLimit;

    /**
     * @var \Magento\Customer\Api\CustomerRepositoryInterface;
     */
    protected $customerRepository;


    /**
     * CustomerOrder constructor.
     * @param \Magento\Customer\Model\Session $session
     * @param \Magento\Sales\Model\ResourceModel\Order\CollectionFactoryInterface $orders
     * @param \Magento\CompanyCredit\Api\CreditLimitManagementInterface $creditLimit
     * @param \Magento\Customer\Api\CustomerRepositoryInterface $customerRepository
     */
    public function __construct(
        \Magento\Customer\Model\Session $session,
        \Magento\Sales\Model\ResourceModel\Order\CollectionFactoryInterface $orders,
        \Magento\CompanyCredit\Api\CreditLimitManagementInterface $creditLimit,
        \Magento\Customer\Api\CustomerRepositoryInterface $customerRepository
    )
    {
        $this->session = $session;
        $this->orders = $orders;
        $this->creditLimit = $creditLimit;
        $this->customerRepository = $customerRepository;
    }

    /**
     * @return bool
     */
    public function isCustomerLoggedIn()
    {
        return $this->session->isLoggedIn();

    }

    /**
     * @return int|null
     */
    public function getUserId(){
        return $this->session->getCustomerId();
    }

    /**
     * @return string
     */
    public function getCreditLimit(){
        $customer = $this->customerRepository->getById($this->getUserId());
        $companyId = $customer->getExtensionAttributes()->getCompanyAttributes()->getCompanyId();
        if($companyId!=0){
            $formatter = new \NumberFormatter('en-US',\NumberFormatter::CURRENCY);
            return $formatter->formatCurrency($this->creditLimit->getCreditByCompanyId($companyId)->getAvailableLimit(),'USD');
        }
        else{
            return '$0.00';
        }


    }

    /**
     * @return string
     */
    public function getOrders()
    {

        $orderCollection = $this->orders->create($this->getUserId())->addFieldToSelect(
            '*'
        )->setOrder(
            'created_at',
            'desc'
        )->setPageSize(4);
        $returnString = '';
        if ($orderCollection->getSize() > 0){
            foreach ($orderCollection as $order) {
                $returnString .= '<tr>';
                $returnString .= '<td data-th="Order #" class="col id">';
                $returnString .= substr($order->getRealOrderId(), -4) . '<br>' . date_format(date_create($order->getCreatedAt()),'m/d/Y') . '</td>';
                $returnString .= '<td data-th="Total" class="col total">';
                $returnString .= $order->formatPrice($order->getGrandTotal()) . '</td>';
                $returnString .= '<td data-th="Status" class="col status">';
                $returnString .= $order->getStatusLabel() . '</td>';
                $returnString .= '</tr>';
            }
        }else{
            $returnString .= '<tr><td colspan="3">No Orders</td>';
        }
        return $returnString;

    }

}
