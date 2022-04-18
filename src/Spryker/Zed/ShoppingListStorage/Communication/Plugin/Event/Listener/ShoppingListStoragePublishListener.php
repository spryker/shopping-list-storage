<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\ShoppingListStorage\Communication\Plugin\Event\Listener;

use Generated\Shared\Transfer\ShoppingListTransfer;
use Spryker\Zed\Event\Dependency\Plugin\EventBulkHandlerInterface;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * @method \Spryker\Zed\ShoppingListStorage\Business\ShoppingListStorageFacadeInterface getFacade()
 * @method \Spryker\Zed\ShoppingListStorage\Communication\ShoppingListStorageCommunicationFactory getFactory()
 * @method \Spryker\Zed\ShoppingListStorage\Persistence\ShoppingListStorageRepositoryInterface getRepository()
 * @method \Spryker\Zed\ShoppingListStorage\ShoppingListStorageConfig getConfig()
 */
class ShoppingListStoragePublishListener extends AbstractPlugin implements EventBulkHandlerInterface
{
    /**
     * {@inheritDoc}
     *  - Handles unpublish shipping list event.
     *
     * @api
     *
     * @param array<\Generated\Shared\Transfer\EventEntityTransfer> $eventEntityTransfers
     * @param string $eventName
     *
     * @return void
     */
    public function handleBulk(array $eventEntityTransfers, $eventName): void
    {
        $customerReferences = [];

        $validEventTransfers = $this->getFactory()
            ->getEventBehaviorFacade()
            ->getEventTransfersByModifiedColumns($eventEntityTransfers, [
                ShoppingListTransfer::CUSTOMER_REFERENCE,
            ]);

        foreach ($validEventTransfers as $eventTransfer) {
            /** @var string $customerReference */
            $customerReference = array_search(ShoppingListTransfer::CUSTOMER_REFERENCE, $eventTransfer->getModifiedColumns());
            $customerReferences[] = $customerReference;
        }

        $customerReferences = array_unique($customerReferences);
        $this->getFacade()->publish($customerReferences);
    }
}
