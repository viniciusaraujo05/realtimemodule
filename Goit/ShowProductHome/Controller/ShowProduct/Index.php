<?php
declare(strict_types=1);

namespace Goit\ShowProductHome\Controller\ShowProduct;

use Magento\Catalog\Model\ProductFactory;
use Magento\Catalog\Helper\Image;
use Magento\Store\Model\StoreManager;
use Magento\CatalogInventory\Model\StockRegistry;
use Goit\ShowProductHome\Model\Config\Source\ProductList;
use Magento\Framework\Controller\Result\JsonFactory;

class Index extends \Magento\Framework\App\Action\Action
{
    /**
     * Constructor method for initializing the class.
     *
     * @param \Magento\Framework\App\Action\Context $context The context object.
     * @param \Magento\Framework\Data\Form\FormKey $formKey The form key object.
     * @param ProductFactory $productFactory The product factory object.
     * @param StockRegistry $stockRegistry The stock registry object.
     * @param StoreManager $storeManager The store manager object.
     * @param Image $imageHelper The image helper object.
     * @param ProductList $productList The product list object.
     * @param JsonFactory $resultJsonFactory The result json factory object.
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        protected ProductFactory $productFactory,
        protected StockRegistry $stockRegistry,
        protected StoreManager $storeManager,
        private Image $imageHelper,
        private ProductList $productList,
        private JsonFactory $resultJsonFactory

    ) {
        parent::__construct($context);
    }

    public function execute()
    {
        $productId = $this->productList->getSelectedProducts();
        $product = $this->productFactory->create()->load($productId);

        $productData = [
            'name' => $product->getName(),
            'price' => $product->getFormattedPrice(),
            'stockQty' => $this->getStock($productId) > 0 ? $this->getStock($productId) : 'Out of Stock',
            'src' => $this->imageHelper->init($product, 'product_base_image')->getUrl(),
            'url' => $product->getProductUrl(),
        ];

        $resultJson = $this->resultJsonFactory->create();
        return $resultJson->setData(json_encode($productData));
    }

    public function getStock($productId)
    {
        return $this->stockRegistry->getStockItem($productId)->getQty();
    }
}
