<?php

namespace Inchoo\NewsWithComments\Block\Adminhtml\Form;

use Magento\Framework\Data\OptionSourceInterface;

class Stores implements OptionSourceInterface
{
    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    private $_storeManager;

    /**
     * Stores constructor.
     *
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     */
    public function __construct(
        \Magento\Store\Model\StoreManagerInterface $storeManager
    ) {
        $this->_storeManager = $storeManager;
    }

    /**
     * @inheritdoc
     */
    public function toOptionArray()
    {
        $stores = $this->_storeManager->getStores();
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
