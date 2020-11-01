<?php

namespace Groskampweb\Updater\Model\Page;

use Groskampweb\ExtendedRepositories\Repository\PageRepository;
use Magento\Framework\Exception\CouldNotDeleteException;

class RemovePage
{
    /** @var PageRepository */
    private $pageRepository;

    /**
     * RemovePage constructor.
     * @param PageRepository $pageRepository
     */
    public function __construct(
        PageRepository $pageRepository
    ) {
        $this->pageRepository = $pageRepository;
    }

    /**
     * @param string $urlKey
     * @throws CouldNotDeleteException
     */
    public function removePage(string $urlKey): void
    {
        $pageInterfaces = $this->pageRepository->getByIdentifier($urlKey);
        $page = reset($pageInterfaces);

        $this->pageRepository->delete($page);
    }
}
