<?php
declare(strict_types=1);

namespace Goit\ShowProductHome\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Catalog\Helper\Image;
use Magento\CatalogInventory\Model\StockRegistry;

class Product extends Template implements \Magento\Framework\View\Element\Block\ArgumentInterface
{
    public function __construct(
        Context $context,
        protected ProductRepositoryInterface $_productRepository,
        private Image $imageHelper,
        private StockRegistry $stockRegistry,
        array $data = []
    ) {
        parent::__construct($context, $data);
    }

    /**
     * Retrieves a product from the repository based on the given SKU.
     *
     * @return \Magento\Catalog\Api\Data\ProductInterface|null The product with the specified SKU, or null if not found.
     */
    public function getProduct()
    {
        return $this->_productRepository->getById(1);
    }

    /**
     * Retrieves the URL of the image associated with the product.
     *
     * @return string The URL of the image.
     */
    public function getImageUrl() {
        return $this->imageHelper->init($this->getProduct(), 'product_page_image_small')->getUrl();
    }

    /**
     * Retrieves the stock quantity of the product.
     *
     * @return int The stock quantity of the product.
     */
    public function getStock() {
        return $this->stockRegistry->getStockItem($this->getProduct()->getId())->getQty();
    }
}
