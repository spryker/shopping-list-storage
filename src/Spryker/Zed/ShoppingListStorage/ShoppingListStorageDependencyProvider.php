<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\ShoppingListStorage;

use Orm\Zed\ShoppingList\Persistence\SpyShoppingListItemQuery;
use Orm\Zed\ShoppingList\Persistence\SpyShoppingListQuery;
use Spryker\Zed\Kernel\AbstractBundleDependencyProvider;
use Spryker\Zed\Kernel\Container;
use Spryker\Zed\ShoppingListStorage\Dependency\Facade\ShoppingListStorageToCompanyBusinessUnitFacadeBridge;
use Spryker\Zed\ShoppingListStorage\Dependency\Facade\ShoppingListStorageToCompanyUserFacadeBridge;
use Spryker\Zed\ShoppingListStorage\Dependency\Facade\ShoppingListStorageToEventBehaviorFacadeBridge;

/**
 * @method \Spryker\Zed\ShoppingListStorage\ShoppingListStorageConfig getConfig()
 */
class ShoppingListStorageDependencyProvider extends AbstractBundleDependencyProvider
{
    /**
     * @var string
     */
    public const FACADE_EVENT_BEHAVIOR = 'FACADE_EVENT_BEHAVIOR';

    /**
     * @var string
     */
    public const PROPEL_QUERY_SHOPPING_LIST = 'PROPEL_QUERY_SHOPPING_LIST';

    /**
     * @var string
     */
    public const PROPEL_QUERY_SHOPPING_LIST_ITEM = 'PROPEL_QUERY_SHOPPING_LIST_ITEM';

    /**
     * @var string
     */
    public const FACADE_COMPANY_USER = 'FACADE_COMPANY_USER';

    /**
     * @var string
     */
    public const FACADE_COMPANY_BUSINESS_UNIT = 'FACADE_COMPANY_BUSINESS_UNIT';

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideCommunicationLayerDependencies(Container $container): Container
    {
        $container = parent::provideCommunicationLayerDependencies($container);
        $container = $this->addEventBehaviorFacade($container);
        $container = $this->addCompanyUserFacade($container);
        $container = $this->addCompanyBusinessUnitFacade($container);

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function providePersistenceLayerDependencies(Container $container): Container
    {
        $container = parent::providePersistenceLayerDependencies($container);
        $container = $this->addShoppingListPropelQuery($container);
        $container = $this->addShoppingListItemPropelQuery($container);

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addEventBehaviorFacade(Container $container): Container
    {
        $container->set(static::FACADE_EVENT_BEHAVIOR, function (Container $container) {
            return new ShoppingListStorageToEventBehaviorFacadeBridge($container->getLocator()->eventBehavior()->facade());
        });

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addCompanyUserFacade(Container $container): Container
    {
        $container->set(static::FACADE_COMPANY_USER, function (Container $container) {
            return new ShoppingListStorageToCompanyUserFacadeBridge($container->getLocator()->companyUser()->facade());
        });

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addCompanyBusinessUnitFacade(Container $container): Container
    {
        $container->set(static::FACADE_COMPANY_BUSINESS_UNIT, function (Container $container) {
            return new ShoppingListStorageToCompanyBusinessUnitFacadeBridge($container->getLocator()->companyBusinessUnit()->facade());
        });

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addShoppingListPropelQuery(Container $container): Container
    {
        $container->set(static::PROPEL_QUERY_SHOPPING_LIST, $container->factory(function () {
            return SpyShoppingListQuery::create();
        }));

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addShoppingListItemPropelQuery(Container $container): Container
    {
        $container->set(static::PROPEL_QUERY_SHOPPING_LIST_ITEM, $container->factory(function () {
            return SpyShoppingListItemQuery::create();
        }));

        return $container;
    }
}
