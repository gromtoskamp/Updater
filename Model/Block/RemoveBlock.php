<?php

namespace Groskampweb\Updater\Model\Block;

use Groskampweb\ExtendedRepositories\Repository\BlockRepository;
use Magento\Framework\Exception\CouldNotDeleteException;

class RemoveBlock
{
    /** @var BlockRepository */
    private $blockRepository;

    /**
     * RemoveBlock constructor.
     * @param BlockRepository $blockRepository
     */
    public function __construct(
        BlockRepository $blockRepository
    ) {
        $this->blockRepository = $blockRepository;
    }

    /**
     * @param string $blockIdentifier
     * @throws CouldNotDeleteException
     */
    public function removeBlock(string $blockIdentifier): void
    {
        $blockInterfaces = $this->blockRepository->getByIdentifier($blockIdentifier);
        $block = reset($blockInterfaces);

        $this->blockRepository->delete($block);
    }
}
