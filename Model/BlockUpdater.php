<?php

namespace Groskampweb\Updater\Model;

use Exception;
use Groskampweb\Updater\Model\Block\CreateBlock;
use Groskampweb\Updater\Model\Block\RemoveBlock;
use Groskampweb\Updater\Model\Block\UpdateBlock;
use Magento\Framework\Exception\CouldNotDeleteException;

class BlockUpdater
{
    /** @var CreateBlock */
    private $createBlock;
    /** @var UpdateBlock */
    private $updateBlock;
    /** @var RemoveBlock */
    private $removeBlock;

    /**
     * BlockUpdater constructor.
     * @param CreateBlock $createBlock
     * @param UpdateBlock $updateBlock
     * @param RemoveBlock $removeBlock
     */
    public function __construct(
        CreateBlock $createBlock,
        UpdateBlock $updateBlock,
        RemoveBlock $removeBlock
    ) {
        $this->createBlock = $createBlock;
        $this->updateBlock = $updateBlock;
        $this->removeBlock = $removeBlock;
    }

    /**
     * @param string $assetName
     * @param string $title
     * @param string $identifier
     * @throws Exception
     */
    public function create(string $assetName, string $title, string $identifier): void
    {
        $this->createBlock->createBlock($assetName, $title, $identifier);
    }

    /**
     * @param string $assetName
     * @param string $identifier
     * @throws Exception
     */
    public function update(string $assetName, string $identifier): void
    {
        $this->updateBlock->updateBlockHtml($assetName, $identifier);
    }

    /**
     * @param string $identifier
     * @throws CouldNotDeleteException
     */
    public function remove(string $identifier): void
    {
        $this->removeBlock->removeBlock($identifier);
    }
}
