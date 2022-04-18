<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\ShoppingListStorage\Communication\Plugin\Event\Listener;

use Orm\Zed\ShoppingList\Persistence\Map\SpyShoppingListItemTableMap;
use Spryker\Zed\Event\Dependency\Plugin\EventBulkHandlerInterface;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * @method \Spryker\Zed\ShoppingListStorage\Business\ShoppingListStorageFacadeInterface getFacade()
 * @method \Spryker\Zed\ShoppingListStorage\Communication\ShoppingListStorageCommunicationFactory getFactory()
 * @method \Spryker\Zed\ShoppingListStorage\Persistence\ShoppingListStorageRepositoryInterface getRepository()
 * @method \Spryker\Zed\ShoppingListStorage\ShoppingListStorageConfig getConfig()
 */
class ShoppingListItemStorageListener extends AbstractPlugin implements EventBulkHandlerInterface
{
    /**
     * {@inheritDoc}
     *  - Handles shipping list item create and delete events.
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
        $shoppingListIds = $this->getFactory()->getEventBehaviorFacade()->getEventTransferForeignKeys($eventEntityTransfers, SpyShoppingListItemTableMap::COL_FK_SHOPPING_LIST);
        $customerReferences = $this->getRepository()->getCustomerReferencesByShoppingListIds($shoppingListIds);

        $this->getFacade()->publish($customerReferences);
    }
}
