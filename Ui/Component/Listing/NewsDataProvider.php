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
     * @var \Inchoo\NewsWithComments\Model\ResourceModel\News\CollectionFactory
     */
    private $collectionFactory;

    /**
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param \Inchoo\NewsWithComments\Model\ResourceModel\News\CollectionFactory $collectionFactory
     * @param \Magento\User\Model\UserFactory $userFactory
     * @param \Magento\User\Model\ResourceModel\User $userResource
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        \Inchoo\NewsWithComments\Model\ResourceModel\News\CollectionFactory $collectionFactory,
        \Inchoo\NewsWithComments\Model\ResourceModel\News\Collection $collection,
        \Magento\User\Model\UserFactory $userFactory,
        \Magento\User\Model\ResourceModel\User $userResource,
        array $meta = [],
        array $data = []
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);

        $this->userFactory = $userFactory;
        $this->userResource = $userResource;
        $this->collectionFactory = $collectionFactory;
        $this->collection = $collection;
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
        $this->collection = $this->collectionFactory->create();
        $data = $this->getCollection()->toArray();

        foreach ($data['items'] as $item => $value) {
            if ($value['published'] == 1) {
                $data['items'][$item]['published'] = "True";
            } else {
                $data['items'][$item]['published'] = "False";
            }
            $data['items'][$item]['added_by'] = $this->getAdminName($value['added_by']);
        }
        return $data;
    }
}
