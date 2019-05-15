<?php

namespace Inchoo\NewsWithComments\Ui\Component\Listing;

use Magento\Ui\DataProvider\AbstractDataProvider;

class NewsDataProvider extends AbstractDataProvider
{
    /**
     * @var \Magento\User\Model\UserFactory
     */
    private $userFactory;
    /**
     * @var \Magento\User\Model\ResourceModel\User
     */
    private $userResource;

    /**
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param \Inchoo\NewsWithComments\Model\ResourceModel\News\CollectionFactory $collectionFactory
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        \Inchoo\NewsWithComments\Model\ResourceModel\News\CollectionFactory $collectionFactory,
        \Magento\User\Model\UserFactory $userFactory,
        \Magento\User\Model\ResourceModel\User $userResource,
        array $meta = [],
        array $data = []
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);

        $this->collection = $collectionFactory->create();
        $this->userFactory = $userFactory;
        $this->userResource = $userResource;
    }

    public function getAdminName($id)
    {
        $admin = $this->userFactory->create();
        $this->userResource->load($admin, (int)$id);
        return ucfirst($admin->getFirstName()) . ' ' . ucfirst($admin->getLastName());
    }

    /**
     * This class can be declared with virtualType
     *
     * {@inheritdoc}
     */
    public function getData()
    {
        $data = $this->getCollection()->toArray();
        return $data;
    }
}
