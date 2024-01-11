<?php

declare(strict_types=1);

namespace Goit\ShowProductHome\Block;

use Magento\Framework\View\Element\Template;
use Magento\Catalog\Api\ProductRepositoryInterface;

class Product extends Template implements \Magento\Framework\View\Element\Block\ArgumentInterface
{
    /**
     * @var array|\Magento\Checkout\Block\Checkout\LayoutProcessorInterface[]
     */
    protected $layoutProcessors;

    /**
     * Constructs a new instance of the class.
     *
     * @param Template\Context $context The context object.
     * @param ProductRepositoryInterface $productRepository The product repository.
     * @param array $layoutProcessors The layout processors.
     * @param array $data Additional data.
     */
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

    /**
     * Retrieves the JavaScript layout.
     *
     * @return string The JSON-encoded JavaScript layout.
     */
    public function getJsLayout()
    {
        foreach ($this->layoutProcessors as $processor) {
            $this->jsLayout = $processor->process($this->jsLayout);
        }

        return json_encode($this->jsLayout);
    }
}
