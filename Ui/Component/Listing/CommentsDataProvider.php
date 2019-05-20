<?php

namespace Inchoo\NewsWithComments\Ui\Component\Listing;

use Magento\Ui\DataProvider\AbstractDataProvider;

class CommentsDataProvider extends AbstractDataProvider
{
    /**
     * @var \Magento\Customer\Api\CustomerRepositoryInterface
     */
    private $customerRepositoryInterface;


    /**
     * @param string                                                                  $name
     * @param string                                                                  $primaryFieldName
     * @param string                                                                  $requestFieldName
     * @param \Inchoo\NewsWithComments\Model\ResourceModel\Comments\CollectionFactory $collectionFactory
     * @param array                                                                   $meta
     * @param array                                                                   $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        \Inchoo\NewsWithComments\Model\ResourceModel\Comments\CollectionFactory $collectionFactory,
        \Magento\Customer\Api\CustomerRepositoryInterface $customerRepositoryInterface,
        array $meta = [],
        array $data = []
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);

        $this->collection = $collectionFactory->create();
        $this->customerRepositoryInterface = $customerRepositoryInterface;
    }

    public function getCustomerName($id)
    {
        $customer = $this->customerRepositoryInterface->getById($id);
        return ucfirst($customer->getFirstName()) . ' ' . ucfirst($customer->getLastName());
    }

    /**
     * This class can be declared with virtualType
     *
     * {@inheritdoc}
     */
    public function getData()
    {
        $data = $this->getCollection()->toArray();

        foreach ($data['items'] as $item => $value) {
            if ($value['comments_published'] == 1) {
                $data['items'][$item]['comments_published'] = "True";
            } else {
                $data['items'][$item]['comments_published'] = "False";
            }
            $data['items'][$item]['comment_added_by'] = $this->getCustomerName($value['comment_added_by']);
        }
        return $data;
    }
}
