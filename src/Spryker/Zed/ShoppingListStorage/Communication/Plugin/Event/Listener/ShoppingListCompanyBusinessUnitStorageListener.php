<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\ShoppingListStorage\Communication\Plugin\Event\Listener;

use Orm\Zed\ShoppingList\Persistence\Map\SpyShoppingListCompanyBusinessUnitTableMap;
use Spryker\Zed\Event\Dependency\Plugin\EventBulkHandlerInterface;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * @method \Spryker\Zed\ShoppingListStorage\Business\ShoppingListStorageFacadeInterface getFacade()
 * @method \Spryker\Zed\ShoppingListStorage\Communication\ShoppingListStorageCommunicationFactory getFactory()
 * @method \Spryker\Zed\ShoppingListStorage\ShoppingListStorageConfig getConfig()
 */
class ShoppingListCompanyBusinessUnitStorageListener extends AbstractPlugin implements EventBulkHandlerInterface
{
    /**
     * {@inheritDoc}
     *  - Handles shipping list to company business unit relation create and update events.
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
        $companyBusinessUnitIds = $this->getFactory()
            ->getEventBehaviorFacade()
            ->getEventTransferForeignKeys($eventEntityTransfers, SpyShoppingListCompanyBusinessUnitTableMap::COL_FK_COMPANY_BUSINESS_UNIT);

        $customerReferences = $this->getFactory()
            ->getCompanyBusinessUnitFacade()
            ->getCustomerReferencesByCompanyBusinessUnitIds($companyBusinessUnitIds);

        $this->getFacade()->publish($customerReferences);
    }
}
