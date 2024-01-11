<?php
declare(strict_types=1);

namespace Goit\ShowProductHome\Model\Config\Source;

use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\Framework\Data\OptionSourceInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;

class ProductList implements OptionSourceInterface
{
    const XML_PATH_PRODUCTS = 'product_home/display_settings/products_to_display';

    /**
     * Constructs a new instance of the class.
     *
     * @param CollectionFactory $collectionFactory The collection factory.
     * @param ScopeConfigInterface $scopeConfig The scope config.
     */
    public function __construct(
        protected CollectionFactory $collectionFactory,
        private ScopeConfigInterface $scopeConfig
    ) {
    }

    /**
     * Retrieves an array of options for a select input based on a collection of products.
     *
     * @return array An array of options where each option has a label and a value.
     */
    public function toOptionArray()
    {
        $collection = $this->collectionFactory->create();
        $collection->addAttributeToSelect('name');
        $collection->addAttributeToFilter('status', \Magento\Catalog\Model\Product\Attribute\Source\Status::STATUS_ENABLED);

        $options = [];
        foreach ($collection as $product) {
            $options[] = ['label' => $product->getName(), 'value' => $product->getId()];
        }

        return $options;
    }

    /**
     * Retrieves the selected products from the configuration.
     *
     * @return mixed The selected products.
     */
    public function getSelectedProducts()
    {
        return $this->scopeConfig->getValue(
            self::XML_PATH_PRODUCTS,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }
}
