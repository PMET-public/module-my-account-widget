<?php

namespace MagentoEse\MyAccountWidget\Block\Widget;

class MyAccount extends \Magento\Framework\View\Element\Template implements \Magento\Widget\Block\BlockInterface
{
    protected function _construct()
    {
        parent::_construct();
        $this->setTemplate('widget/my_account.phtml');
    }
}
