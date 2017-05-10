<?php
namespace MagentoEse\MyAccountWidget\Controller\Data;
class Customer extends \Magento\Framework\App\Action\Action
{




    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \MagentoEse\MyAccountWidget\Model\CustomerOrder $customerOrder
    )
    {
        $this->customerOrder = $customerOrder;
        return parent::__construct($context);
    }

    public function execute()
    {
        $isLoggedIn = $this->customerOrder->isCustomerLoggedIn();
        if($isLoggedIn){
            $notLoggedIn = false;
            $creditLimit = $this->customerOrder->getCreditLimit();
            $orderData = $this->customerOrder->getOrders();
        }else{
            $notLoggedIn = true;
            $creditLimit = '';
            $orderData = '';
        }

        $returnData = ['loggedin' => $isLoggedIn,'notloggedin'=>$notLoggedIn,'creditlimit'=>$creditLimit,'ordertable'=>$orderData];

        echo json_encode($returnData);
    }

}