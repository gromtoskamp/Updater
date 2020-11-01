<?php

namespace Groskampweb\Updater\Model\Block;

use Groskampweb\ExtendedRepositories\Repository\BlockRepository;
use Groskampweb\Updater\Helper\AssetFetcher;

class UpdateBlock
{
    /** @var AssetFetcher */
    private $assetFetcher;
    /** @var BlockRepository */
    private $blockRepository;

    /**
     * UpdateBlock constructor.
     * @param AssetFetcher $assetFetcher
     * @param BlockRepository $blockRepository
     */
    public function __construct(
        AssetFetcher $assetFetcher,
        BlockRepository $blockRepository
    ) {
        $this->assetFetcher = $assetFetcher;
        $this->blockRepository = $blockRepository;
    }

    /**
     * @param $assetName
     * @param $identifier
     * @throws \Exception
     */
    public function updateBlockHtml(string $assetName, string $identifier): void
    {
        $assetHtml = $this->assetFetcher->getAssetHtml($assetName);
        $blocks = $this->blockRepository->getByIdentifier($identifier);

        $block = reset($blocks);

        $block->setContent($assetHtml);
        $this->blockRepository->save($block);
    }
}
