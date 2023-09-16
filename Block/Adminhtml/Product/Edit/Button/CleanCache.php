<?php

declare(strict_types=1);

namespace ITYetti\CleanCacheSingleProduct\Block\Adminhtml\Product\Edit\Button;

use ITYetti\CleanCacheSingleProduct\Service\Config;
use Magento\Framework\View\Element\UiComponent\Context;
use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

class CleanCache implements ButtonProviderInterface
{
    /**
     * @var Config
     */
    private Config $config;

    /**
     * @var Context
     */
    private Context $context;

    /**
     * @param Config $config
     * @param Context $context
     */
    public function __construct(
        Config $config,
        Context $context
    ) {
        $this->config = $config;
        $this->context = $context;
    }

    /**
     * {@inheritdoc}
     */
    public function getButtonData(): array
    {
        if ($this->config->isEnabled()) {
            $message = __('Are you sure you want to clean the cache?');
            return [
                'label' => __('Clean Product Cache'),
                'class' => 'action-secondary',
                'data_attribute' => [
                    'mage-init' => [
                        'buttonAdapter' => [
                            'actions' => [
                                [
                                    'targetName' => 'product_form.product_form.clean_product_cache',
                                    'actionName' => 'clean_product_cache',
                                    'params' => [
                                        false
                                    ]
                                ]
                            ]
                        ]
                    ]
                ],
                'on_click' => "confirmSetLocation('{$message}', '{$this->getButtonUrl()}')",
                'sort_order' => 30
            ];
        }
        return [];
    }

    /**
     * Get clean cache single product url button
     *
     * @return string
     */
    private function getButtonUrl(): string
    {
        return $this->getUrl('ityetti/product/cleanCache', ['id' => $this->context->getRequestParam('id')]);
    }

    /**
     * Generate url by route and parameters
     *
     * @param string $route
     * @param array $params
     * @return string
     */
    private function getUrl(string $route = '', array $params = []): string
    {
        return $this->context->getUrl($route, $params);
    }
}
