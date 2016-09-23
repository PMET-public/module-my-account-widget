<?php
namespace MagentoEse\MyAccountWidget\Block\Widget;

class MyAccount extends \Magento\Framework\View\Element\Template implements \Magento\Widget\Block\BlockInterface
{
	public function _toHtml()
    {
    	$this->setTemplate('widget/my_account.phtml');
    }
}
