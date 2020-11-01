<?php

namespace Groskampweb\Updater\Model\Page;

use Exception;
use Groskampweb\ExtendedRepositories\Repository\PageRepository;
use Groskampweb\Updater\Helper\AssetFetcher;
use Magento\Cms\Model\Page;
use Magento\Cms\Model\PageFactory;

class CreatePage
{
    /** @var PageFactory */
    private $pageFactory;
    /** @var PageRepository */
    private $pageRepository;
    /** @var AssetFetcher */
    private $assetFetcher;

    public function __construct(
        PageFactory $pageFactory,
        PageRepository $pageRepository,
        AssetFetcher $assetFetcher
    ) {
        $this->pageFactory = $pageFactory;
        $this->pageRepository = $pageRepository;
        $this->assetFetcher = $assetFetcher;
    }

    /**
     * @param string $assetName
     * @param string $pageTitle
     * @param string $pageUrlKey
     * @param string $pageLayout
     * @param int $storeId
     * @throws Exception
     */
    public function createPage(string $assetName, string $pageTitle, string $pageUrlKey, string $pageLayout = '1column', int $storeId = 0): void
    {
        if (!empty($this->pageRepository->getByIdentifier($pageUrlKey))) {
            return;
        }

        $pageHtml = $this->assetFetcher->getAssetHtml($assetName);
        /** @var Page $page */
        $page = $this->pageFactory->create();

        $page->setTitle($pageTitle);
        $page->setIdentifier($pageUrlKey);
        $page->setPageLayout($pageLayout);
        $page->setContent($pageHtml);
        $page->setStoreId($storeId);

        //TODO: log possible exceptions.
        $this->pageRepository->save($page);
    }
}
