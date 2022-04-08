<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\ShoppingListStorage\Persistence;

use Generated\Shared\Transfer\FilterTransfer;
use Orm\Zed\ShoppingList\Persistence\Map\SpyShoppingListTableMap;
use Orm\Zed\ShoppingList\Persistence\SpyShoppingListQuery;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\Collection\ObjectCollection;
use Spryker\Zed\Kernel\Persistence\AbstractRepository;

/**
 * @method \Spryker\Zed\ShoppingListStorage\Persistence\ShoppingListStoragePersistenceFactory getFactory()
 */
class ShoppingListStorageRepository extends AbstractRepository implements ShoppingListStorageRepositoryInterface
{
    /**
     * @var string
     */
    protected const COMPANY_USER_CUSTOMER_ALIAS = 'companyUserCustomer';

    /**
     * @var string
     */
    protected const COMPANY_BUSINESS_UNIT_CUSTOMER_ALIAS = 'companyBusinessUnitCustomer';

    /**
     * @var string
     */
    protected const CUSTOMER_REFERENCE_FIELD = 'customer_reference';

    /**
     * @var string
     */
    protected const COMPANY_USER_REFERENCES_NAME = 'companyUserReferences';

    /**
     * @var string
     */
    protected const COMPANY_BUSINESS_UNIT_REFERENCES_NAME = 'companyBusinessUnitReferences';

    /**
     * @var string
     */
    protected const COMPANY_BUSINESS_UNIT_COMPANY_USER_ALIAS = 'companyBusinessUnitCompanyUser';

    /**
     * @module ShoppingList
     *
     * @param array<int> $shoppingListIds
     *
     * @return array<string>
     */
    public function getCustomerReferencesByShoppingListIds(array $shoppingListIds): array
    {
        $shoppingListQuery = $this->getFactory()
            ->getShoppingListPropelQuery();
        $this->addCompanyUserCustomerReferences($shoppingListQuery);
        $this->addCompanyBusinessUnitCustomerReferences($shoppingListQuery);
        $customerReferencesArray = $shoppingListQuery->filterByIdShoppingList_In($shoppingListIds)
            ->select([SpyShoppingListTableMap::COL_CUSTOMER_REFERENCE])
            ->find()
            ->toArray();

        $result = [];
        foreach ($customerReferencesArray as $item) {
            $result = array_merge($result, array_filter(array_values($item)));
        }
        $result = array_unique($result);

        return $result;
    }

    /**
     * @param array $customerReferences
     *
     * @return \Propel\Runtime\Collection\ObjectCollection<\Orm\Zed\ShoppingListStorage\Persistence\SpyShoppingListCustomerStorage>
     */
    public function findShoppingListCustomerStorageEntitiesByCustomerReferences(array $customerReferences): ObjectCollection
    {
        return $this->getFactory()
            ->createShoppingListCustomerStoragePropelQuery()
            ->filterByCustomerReference_In($customerReferences)
            ->find();
    }

    /**
     * @param array<string> $customerReferences
     *
     * @return \Propel\Runtime\Collection\ObjectCollection<\Orm\Zed\ShoppingList\Persistence\SpyShoppingList>
     */
    public function findShoppingListEntitiesByCustomerReferences(array $customerReferences): ObjectCollection
    {
        return $this->getFactory()
            ->getShoppingListPropelQuery()
            ->filterByCustomerReference_In($customerReferences)
            ->find();
    }

    /**
     * @param array $shoppingListCustomerStorageIds
     *
     * @return \Propel\Runtime\Collection\ObjectCollection<\Orm\Zed\ShoppingListStorage\Persistence\SpyShoppingListCustomerStorage>
     */
    public function findShoppingListCustomerStorageEntitiesByIds(array $shoppingListCustomerStorageIds): ObjectCollection
    {
        return $this->getFactory()
            ->createShoppingListCustomerStoragePropelQuery()
            ->filterByIdShoppingListCustomerStorage_In($shoppingListCustomerStorageIds)
            ->find();
    }

    /**
     * @param \Generated\Shared\Transfer\FilterTransfer $filterTransfer
     * @param array<int> $shoppingListCustomerStorageEntityIds
     *
     * @return array<\Generated\Shared\Transfer\SpyShoppingListCustomerStorageEntityTransfer>
     */
    public function findFilteredShoppingListCustomerStorageEntities(FilterTransfer $filterTransfer, array $shoppingListCustomerStorageEntityIds = []): array
    {
        $query = $this->getFactory()->createShoppingListCustomerStoragePropelQuery();

        if ($shoppingListCustomerStorageEntityIds) {
            $query->filterByIdShoppingListCustomerStorage_In($shoppingListCustomerStorageEntityIds);
        }

        return $this->buildQueryFromCriteria($query, $filterTransfer)->find();
    }

    /**
     * @param \Orm\Zed\ShoppingList\Persistence\SpyShoppingListQuery $shoppingListQuery
     *
     * @return void
     */
    protected function addCompanyUserCustomerReferences(SpyShoppingListQuery $shoppingListQuery): void
    {
        $shoppingListQuery
            ->useSpyShoppingListCompanyUserQuery(null, Criteria::LEFT_JOIN)
                ->useSpyCompanyUserQuery(null, Criteria::LEFT_JOIN)
                    ->joinCustomer(static::COMPANY_USER_CUSTOMER_ALIAS, Criteria::LEFT_JOIN)
                    ->withColumn(static::COMPANY_USER_CUSTOMER_ALIAS . '.' . static::CUSTOMER_REFERENCE_FIELD, static::COMPANY_USER_REFERENCES_NAME)
                ->endUse()
            ->endUse();
    }

    /**
     * @param \Orm\Zed\ShoppingList\Persistence\SpyShoppingListQuery $shoppingListQuery
     *
     * @return void
     */
    protected function addCompanyBusinessUnitCustomerReferences(SpyShoppingListQuery $shoppingListQuery): void
    {
        $shoppingListQuery
            ->useSpyShoppingListCompanyBusinessUnitQuery(null, Criteria::LEFT_JOIN)
                ->useSpyCompanyBusinessUnitQuery(null, Criteria::LEFT_JOIN)
                    ->useCompanyUserQuery(static::COMPANY_BUSINESS_UNIT_COMPANY_USER_ALIAS, Criteria::LEFT_JOIN)
                        ->joinCustomer(static::COMPANY_BUSINESS_UNIT_CUSTOMER_ALIAS, Criteria::LEFT_JOIN)
                        ->withColumn(static::COMPANY_BUSINESS_UNIT_CUSTOMER_ALIAS . '.' . static::CUSTOMER_REFERENCE_FIELD, static::COMPANY_BUSINESS_UNIT_REFERENCES_NAME)
                    ->endUse()
                ->endUse()
            ->endUse();
    }
}
