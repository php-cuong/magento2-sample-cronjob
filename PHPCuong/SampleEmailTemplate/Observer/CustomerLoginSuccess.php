<?php

/**
 *
 * @Author              Ngo Quang Cuong <bestearnmoney87@gmail.com>
 * @Date                2017-01-15 04:06:54
 * @Last modified by:   nquangcuong
 * @Last Modified time: 2017-01-15 04:46:01
 */

namespace PHPCuong\SampleEmailTemplate\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Newsletter\Model\Template;
use Magento\Framework\Validator\EmailAddress;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Store\Model\StoreManagerInterface;

class CustomerLoginSuccess implements ObserverInterface
{
    /**
     * @var TransportBuilder
     */
    protected $transportBuilder;

    /**
     * Validate Email Address
     *
     * @var \Magento\Framework\Validator\EmailAddress
     */
    protected $validatorEmail;

    /**
     * Store manager
     *
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @param TransportBuilder $transportBuilder
     * @param StoreManagerInterface $storeManager
     * @param EmailAddress $validatorEmail
     */
    public function __construct(
        TransportBuilder $transportBuilder,
        StoreManagerInterface $storeManager,
        EmailAddress $validatorEmail
    ) {
        $this->validatorEmail = $validatorEmail;
        $this->storeManager = $storeManager;
        $this->transportBuilder = $transportBuilder;
    }

    /**
     * Handler for 'customer_login' event.
     *
     * @param Observer $observer
     * @return void
     */
    public function execute(Observer $observer)
    {
        // send email notification to the customer here
        $full_name = trim($observer->getEvent()->getCustomer()->getFirstname().' '.$observer->getEvent()->getCustomer()->getLastname());

        $email = $observer->getEvent()->getCustomer()->getEmail();
        // checking email is valid then send email
        if ($this->validatorEmail->isValid($email)) {
            $customerObject = new \Magento\Framework\DataObject();

            $templateParams = [
                'full_name' => $full_name
            ];

            $customerObject->setData($templateParams);

            $this->transportBuilder->setTemplateIdentifier(
                'customer_login_success'
            )->setTemplateOptions(
                [
                    'area' => \Magento\Framework\App\Area::AREA_FRONTEND,
                    'store' => $this->storeManager->getStore()->getId(),
                ]
            )->setTemplateVars(
                ['user' => $customerObject]
            )->setFrom(
                ['email' => 'sample@example.com', 'name' => 'Cuong Ngo']
            )->setReplyTo(
                'sample@example.com',
                'Cuong Ngo'
            )->addTo(
                $email,
                $full_name
            );

            $transport = $this->transportBuilder->getTransport();

            try {
                $transport->sendMessage();
            } catch (\Exception $e) {
                \Magento\Framework\App\ObjectManager::getInstance()->get('Psr\Log\LoggerInterface')->debug($e->getMessage());
            }
        }
    }
}
