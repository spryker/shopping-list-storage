<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\ShoppingListStorage\Business;

use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @api
 *
 * @method \Spryker\Zed\ShoppingListStorage\Business\ShoppingListStorageBusinessFactory getFactory()
 * @method \Spryker\Zed\ShoppingListStorage\Persistence\ShoppingListStorageRepositoryInterface getRepository()
 */
class ShoppingListStorageFacade extends AbstractFacade implements ShoppingListStorageFacadeInterface
{
    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param int[] $shoppingListIds
     *
     * @return string[]
     */
    public function getCustomerReferencesByShoppingListIds(array $shoppingListIds): array
    {
        return $this->getRepository()->getCustomerReferencesByShippingListIds($shoppingListIds);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param int[] $companyBusinessUnitIds
     *
     * @return string[]
     */
    public function getCustomerReferencesByCompanyBusinessUnitIds(array $companyBusinessUnitIds): array
    {
        return $this->getRepository()->getCustomerReferencesByCompanyBusinessUnitIds($companyBusinessUnitIds);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param int[] $companyUserIds
     *
     * @return string[]
     */
    public function getCustomerReferencesByCompanyUserIds(array $companyUserIds): array
    {
        return $this->getRepository()->getCustomerReferencesByCompanyUserIds($companyUserIds);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param array $customer_reference
     *
     * @return void
     */
    public function publish(array $customer_references): void
    {
        $this->getFactory()->createShoppingListCustomerStorageWriter()->publish($customer_references);
    }
}