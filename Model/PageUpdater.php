<?php

namespace Groskampweb\Updater\Model;

use Exception;
use Groskampweb\Updater\Model\Page\CreatePage;
use Groskampweb\Updater\Model\Page\RemovePage;
use Groskampweb\Updater\Model\Page\UpdatePage;
use Magento\Framework\Exception\CouldNotDeleteException;

class PageUpdater
{
    /** @var CreatePage */
    private $createPage;
    /** @var UpdatePage */
    private $updatePage;
    /** @var RemovePage */
    private $removePage;

    /**
     * PageUpdater constructor.
     * @param CreatePage $createPage
     * @param UpdatePage $updatePage
     * @param RemovePage $removePage
     */
    public function __construct(
        CreatePage $createPage,
        UpdatePage $updatePage,
        RemovePage $removePage
    ) {
        $this->createPage = $createPage;
        $this->updatePage = $updatePage;
        $this->removePage = $removePage;
    }

    /**
     * @param string $assetName
     * @param string $title
     * @param string $urlKey
     * @param string $pageLayout
     * @param int $storeId
     * @throws Exception
     */
    public function create(string $assetName, string $title, string $urlKey, string $pageLayout = '1column', int $storeId = 0): void
    {
        $this->createPage->createPage($assetName, $title, $urlKey, $pageLayout, $storeId);
    }

    /**
     * @param string $assetName
     * @param string $urlKey
     * @throws Exception
     */
    public function update(string $assetName, string $urlKey): void
    {
        $this->updatePage->updatePageHtml($assetName, $urlKey);
    }

    /**
     * @param string $urlKey
     * @throws CouldNotDeleteException
     */
    public function remove(string $urlKey): void
    {
        $this->removePage->removePage($urlKey);
    }
}
