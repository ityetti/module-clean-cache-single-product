<?php

declare(strict_types=1);

namespace ITYetti\CleanCacheSingleProduct\Controller\Adminhtml\Product;

use Exception;
use Magento\Framework\App\ActionInterface;
use Magento\Framework\App\Request\Http;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Controller\Result\RedirectFactory;
use Magento\Framework\Message\ManagerInterface;
use ITYetti\CleanCacheSingleProduct\Service\CleanCacheSingleProduct;
use Psr\Log\LoggerInterface;

class CleanCache implements ActionInterface
{
    /**
     * @var Http
     */
    private Http $request;

    /**
     * @var RedirectFactory
     */
    private RedirectFactory $redirectFactory;

    /**
     * @var ManagerInterface
     */
    private ManagerInterface $messageManager;

    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * @var CleanCacheSingleProduct
     */
    private CleanCacheSingleProduct $cleanCacheSingleProduct;

    /**
     * @param Http $request
     * @param RedirectFactory $redirectFactory
     * @param ManagerInterface $messageManager
     * @param LoggerInterface $logger
     * @param CleanCacheSingleProduct $cleanCacheSingleProduct
     */
    public function __construct(
        Http $request,
        RedirectFactory $redirectFactory,
        ManagerInterface $messageManager,
        LoggerInterface $logger,
        CleanCacheSingleProduct $cleanCacheSingleProduct
    ) {
        $this->request = $request;
        $this->redirectFactory = $redirectFactory;
        $this->messageManager = $messageManager;
        $this->logger = $logger;
        $this->cleanCacheSingleProduct = $cleanCacheSingleProduct;
    }

    /**
     * Run clean cache for single product
     *
     * @return Redirect
     */
    public function execute(): Redirect
    {
        $resultRedirect = $this->redirectFactory->create();
        $productId = $this->request->getParam('id');
        try {
            $this->cleanCacheSingleProduct->execute((int)$productId);
        } catch (Exception $e) {
            $this->messageManager->addErrorMessage(__('Clean cache ended unsuccessfully. See logs for details.'));
            $this->logger->critical($e->getMessage());
        }
        $this->messageManager->addSuccessMessage(__('You successfully clean product cache'));

        return $resultRedirect->setPath('catalog/*/edit', ['id' => $productId]);
    }
}
