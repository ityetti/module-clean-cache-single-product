<?php

declare(strict_types=1);

namespace ITYetti\CleanCacheSingleProduct\Service;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

class Config
{
    private const XML_PATH_ITYETTI_CLEAN_CACHE_SINGLE_PRODUCT = 'ityetti_clean_cache_single_product/general/is_enabled';

    /**
     * @var ScopeConfigInterface
     */
    private ScopeConfigInterface $scopeConfig;

    /**
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig
    ) {
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * Get config value
     *
     * @param int|null $storeId
     * @return string|null
     */
    private function getConfigValue(int $storeId = null): string|null
    {
        return $this->scopeConfig->getValue(
            self::XML_PATH_ITYETTI_CLEAN_CACHE_SINGLE_PRODUCT,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * Check if module enable
     *
     * @param int|null $storeId
     * @return string|null
     */
    public function isEnabled(int $storeId = null): string|null
    {
        return $this->getConfigValue((int)$storeId);
    }
}
