<?php

namespace Inchoo\NewsWithComments\Block\Adminhtml\Form;

use Magento\Framework\Data\OptionSourceInterface;

class Stores implements OptionSourceInterface
{
    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    private $storeManager;

    public function __construct(\Magento\Store\Model\StoreManagerInterface $storeManager)
    {
        $this->storeManager = $storeManager;
    }

    /**
     * @inheritdoc
     */
    public function toOptionArray()
    {
        $stores = $this->storeManager->getStores();
        $options = [];
        foreach ($stores as $store) {
            $options[] = [
                'label' => $store->getName(),
                'value' => $store->getId(),
            ];
        }

        return $options;
    }
}
