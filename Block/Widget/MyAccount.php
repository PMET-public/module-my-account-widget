<?php
namespace MagentoEse\MyAccountWidget\Block\Widget;

class MyAccount extends \Magento\Framework\View\Element\Template implements \Magento\Widget\Block\BlockInterface
{
    /**
     * @var \Magento\Framework\View\Element\Template\Context
     */
    protected $context;

    /**
     * @var \Magento\Customer\Model\Session
     */
    protected $session;

    /**
     * @var \MagentoEse\MyAccountWidget\Model\CustomerOrder
     */
    protected $customerOrder;

    /**
     * @var
     */
    protected $data;


    /**
     * MyAccount constructor.
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magento\Customer\Model\Session $session
     * @param \MagentoEse\MyAccountWidget\Model\CustomerOrder $customerOrder
     * @param array $data
     */
    public function __construct(\Magento\Framework\View\Element\Template\Context $context,
                                \Magento\Customer\Model\Session $session,
                                \MagentoEse\MyAccountWidget\Model\CustomerOrder $customerOrder,
                                array $data = [])
    {

        $this->setTemplate('widget/my_account.phtml');
        $this->session = $session;
        $this->customerOrder = $customerOrder;
        parent::__construct($context);
    }

    /**
     * @return bool
     */
    public function isloggedIn(){
       return $this->session->isLoggedIn();
    }

    /**
     * @return string
     */
    public function getOrders(){
        return $this->customerOrder->getOrders();
    }

    /**
     * @return string
     */
    public function getCreditLimit(){
        return $this->customerOrder->getCreditLimit();
    }
}