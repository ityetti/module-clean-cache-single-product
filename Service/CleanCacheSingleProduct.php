<?php

declare(strict_types=1);

namespace ITYetti\CleanCacheSingleProduct\Service;

use Exception;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Catalog\Model\Product;
use Magento\InventoryCache\Model\FlushCacheByCacheTag;

class CleanCacheSingleProduct
{
    /**
     * @var ProductRepositoryInterface
     */
    private ProductRepositoryInterface $productRepository;

    /**
     * @var FlushCacheByCacheTag
     */
    private FlushCacheByCacheTag $flushCacheByCacheTag;

    /**
     * @param ProductRepositoryInterface $productRepository
     * @param FlushCacheByCacheTag $flushCacheByCacheTag
     */
    public function __construct(
        ProductRepositoryInterface $productRepository,
        FlushCacheByCacheTag $flushCacheByCacheTag,
    ) {
        $this->productRepository = $productRepository;
        $this->flushCacheByCacheTag = $flushCacheByCacheTag;
    }

    /**
     * Clean magento cache in files and varnish cache for product
     *
     * @param int $productId
     * @return void
     * @throws Exception
     */
    public function execute(int $productId): void
    {
        //Clean magento cache in files for product
        $product = $this->productRepository->getById($productId);
        $product->cleanCache();
        $this->productRepository->save($product);
        //Clean varnish cache for product
        $this->flushCacheByCacheTag->execute(Product::CACHE_TAG, [$productId]);
    }
}
