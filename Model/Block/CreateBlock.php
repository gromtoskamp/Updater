<?php

namespace Groskampweb\Updater\Model\Block;

use Exception;
use Groskampweb\ExtendedRepositories\Repository\BlockRepository;
use Groskampweb\Updater\Helper\AssetFetcher;
use Magento\Cms\Model\Block;
use Magento\Cms\Model\BlockFactory;

class CreateBlock
{
    /** @var BlockFactory */
    private $blockFactory;
    /** @var BlockRepository */
    private $blockRepository;
    /** @var AssetFetcher */
    private $assetFetcher;

    /**
     * CreateNewCustomerBlock constructor.
     * @param BlockFactory $blockFactory
     * @param BlockRepository $blockRepository
     * @param AssetFetcher $assetFetcher
     */
    public function __construct(
        BlockFactory $blockFactory,
        BlockRepository $blockRepository,
        AssetFetcher $assetFetcher
    ) {
        $this->blockFactory = $blockFactory;
        $this->blockRepository = $blockRepository;
        $this->assetFetcher = $assetFetcher;
    }

    /**
     * @param string $assetName
     * @param string $blockTitle
     * @param string $blockIdentifier
     * @param int $storeId
     * @throws Exception
     */
    public function createBlock(string $assetName, string $blockTitle, string $blockIdentifier, int $storeId = 0): void
    {
        if (!empty($this->blockRepository->getByIdentifier($blockIdentifier))) {
            return;
        }

        $blockHtml = $this->assetFetcher->getAssetHtml($assetName);
        /** @var Block $block */
        $block = $this->blockFactory->create();
        $block->setTitle($blockTitle);
        $block->setIdentifier($blockIdentifier);
        $block->setContent($blockHtml);
        $block->setStoreId($storeId);

        //TODO: log possible exceptions.
        $this->blockRepository->save($block);
    }
}
