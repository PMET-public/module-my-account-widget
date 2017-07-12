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

    /**
     * @var \Magento\Company\Model\Customer\CompanyAttributes
     */
    protected $companyAttributes;

    /**
     * @var \Magento\Company\Model\CompanyRepository
     */
    protected $companyRepository;

    /**
     * @var \Magento\CompanyCredit\Api\CreditLimitManagementInterface
     */
    protected $creditLimitManagement;

    /**
     * Customer constructor.
     * @param CurrentCustomer $currentCustomer
     * @param View $customerViewHelper
     * @param \Magento\Company\Model\Customer\CompanyAttributes $companyAttributes
     * @param \Magento\Company\Model\CompanyRepository $companyRepository
     * @param \Magento\CompanyCredit\Api\CreditLimitManagementInterface $creditLimitManagement
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
     * @return array
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
         ];
    }
}