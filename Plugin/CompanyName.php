<?php

namespace MagentoEse\MyAccountWidget\Plugin;


class CompanyName {

    protected $companyAttributes;
    protected $companyRepository;
    protected $currentCustomer;

    public function __construct(
        \Magento\Company\Model\Customer\CompanyAttributes $companyAttributes,
        \Magento\Company\Model\CompanyRepository $companyRepository,
        \Magento\Customer\Helper\Session\CurrentCustomer $currentCustomer){

        $this->companyAttributes = $companyAttributes;
        $this->companyRepository = $companyRepository;
        $this->currentCustomer = $currentCustomer;
    }

    public function afterGetSectionData(\Magento\Customer\CustomerData\Customer $subject, $result){

        if(count($result)!=0){
            $customer = $this->currentCustomer->getCustomer();
            $result['company'] = $this->companyRepository->get($this->companyAttributes->getCompanyAttributesByCustomer($customer)->getCompanyId())->getName();
        }
        return $result;
    }

}
