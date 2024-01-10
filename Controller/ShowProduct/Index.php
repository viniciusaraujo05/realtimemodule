<?php

declare(strict_types=1);

namespace Goit\ShowProductHome\Controller\ShowProduct;

use Magento\Catalog\Model\ProductFactory;
use Magento\Catalog\Helper\Image;
use Magento\Store\Model\StoreManager;
use Magento\CatalogInventory\Model\StockRegistry;

class Index extends \Magento\Framework\App\Action\Action
{
    protected $productFactory;
    protected $imageHelper;
    protected $listProduct;
    protected $_storeManager;
    private  $stockRegistry;

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\Data\Form\FormKey $formKey,
        ProductFactory $productFactory,
        StockRegistry $stockRegistry,
        StoreManager $storeManager,
        Image $imageHelper
    ) {
        $this->productFactory = $productFactory;
        $this->imageHelper = $imageHelper;
        $this->stockRegistry = $stockRegistry;
        $this->_storeManager = $storeManager;
        parent::__construct($context);
    }

    public function execute()
    {
        $product = $this->productFactory->create()->load(911);

        $productData = [
            'name' => $product->getName(),
            'price' => $product->getPrice(),
            'stockQty' => $this->getStock(),
            'src' => $this->imageHelper->init($product, 'product_base_image')->getUrl(),
        ];

        echo json_encode($productData);
        return;
    }

    public function getStock() {
        return $this->stockRegistry->getStockItem(911)->getQty();
    }
}
