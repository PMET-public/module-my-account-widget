<?php
namespace MagentoEse\MyAccountWidget\Model;
use Magento\Customer\Helper\Session\CurrentCustomer;
use Magento\Customer\Helper\View;
/**
 * Customer section
 */
class Customer implements \Magento\Customer\CustomerData\SectionSourceInterface
{
    /**
     * @var CurrentCustomer
     */
    protected $currentCustomer;
    protected $companyAttributes;
    protected $companyRepository;
    protected $creditLimitManagement;
    /**
     * @param CurrentCustomer $currentCustomer
     * @param View $customerViewHelper
     */
    public function __construct(
        CurrentCustomer $currentCustomer,
        View $customerViewHelper,
        \Magento\Company\Model\Customer\CompanyAttributes $companyAttributes,
        \Magento\Company\Model\CompanyRepository $companyRepository,
        \Magento\CompanyCredit\Api\CreditLimitManagementInterface $creditLimitManagement
    ) {
        $this->currentCustomer = $currentCustomer;
        $this->customerViewHelper = $customerViewHelper;
        $this->companyAttributes = $companyAttributes;
        $this->companyRepository = $companyRepository;
        $this->creditLimitManagement = $creditLimitManagement;
    }
    /**
     * {@inheritdoc}
     */
    public function getSectionData()
    {
        if (!$this->currentCustomer->getCustomerId()) {
            return [];
        }
        $customer = $this->currentCustomer->getCustomer();
        return [
            'fullname' => $this->customerViewHelper->getCustomerName($customer),
            'firstname' => $customer->getFirstname(),
            'company' => $this->companyRepository->get($this->companyAttributes->getCompanyAttributesByCustomer($customer)->getCompanyId())->getCompanyName(),
            'creditlimit' => $this->creditLimitManagement->getCreditByCompanyId($this->companyAttributes->getCompanyAttributesByCustomer($customer)->getCompanyId())->getCreditLimit(),
        ];
    }
}