<?php
declare(strict_types=1);

namespace Goit\ShowProductHome\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Catalog\Helper\Image;

class Product extends Template implements \Magento\Framework\View\Element\Block\ArgumentInterface
{    /**
    * @var array|\Magento\Checkout\Block\Checkout\LayoutProcessorInterface[]
    */
   protected $layoutProcessors;

   public function __construct(
       Template\Context $context,
       private ProductRepositoryInterface $productRepository,
       array $layoutProcessors = [],
       array $data = []
   ) {
       parent::__construct($context, $data);
       $this->jsLayout = isset($data['jsLayout']) && is_array($data['jsLayout']) ? $data['jsLayout'] : [];
       $this->layoutProcessors = $layoutProcessors;
   }

   public function getJsLayout()
   {
       foreach ($this->layoutProcessors as $processor) {
           $this->jsLayout = $processor->process($this->jsLayout);
       }

        $product = $this->loadProduct(911);
        $this->jsLayout['components']['product']['name'] = $product->getName();
        $this->jsLayout['components']['product']['price'] = $product->getPrice();


\Magento\Framework\App\ObjectManager::getInstance()
->get('Psr\Log\LoggerInterface')
->debug('teste = '. print_r($this->jsLayout, true));

       return json_encode($this->jsLayout);
   }

   private function loadProduct($productId)
   {
       return $this->productRepository->getById($productId);
   }
}
