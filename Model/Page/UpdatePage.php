<?php

namespace Groskampweb\Updater\Model\Page;

use Exception;
use Groskampweb\ExtendedRepositories\Repository\PageRepository;
use Groskampweb\Updater\Helper\AssetFetcher;

class UpdatePage
{
    /** @var AssetFetcher */
    private $assetFetcher;
    /** @var PageRepository */
    private $pageRepository;

    /**
     * UpdatePage constructor.
     * @param AssetFetcher $assetFetcher
     * @param PageRepository $pageRepository
     */
    public function __construct(
        AssetFetcher $assetFetcher,
        PageRepository $pageRepository
    ) {
        $this->assetFetcher = $assetFetcher;
        $this->pageRepository = $pageRepository;
    }

    /**
     * @param $assetName
     * @param $urlKey
     * @throws Exception
     */
    public function updatePageHtml(string $assetName, string $urlKey): void
    {
        $assetHtml = $this->assetFetcher->getAssetHtml($assetName);
        $pages = $this->pageRepository->getByIdentifier($urlKey);

        $page = reset($pages);

        $page->setContent($assetHtml);
        $this->pageRepository->save($page);
    }
}
