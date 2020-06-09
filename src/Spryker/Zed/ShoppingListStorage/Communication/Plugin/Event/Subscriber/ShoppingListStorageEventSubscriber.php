<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\ShoppingListStorage\Communication\Plugin\Event\Subscriber;

use Spryker\Zed\Event\Dependency\EventCollectionInterface;
use Spryker\Zed\Event\Dependency\Plugin\EventSubscriberInterface;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Spryker\Zed\ShoppingList\Dependency\ShoppingListEvents;
use Spryker\Zed\ShoppingListStorage\Communication\Plugin\Event\Listener\ShoppingListCompanyBusinessUnitStorageListener;
use Spryker\Zed\ShoppingListStorage\Communication\Plugin\Event\Listener\ShoppingListCompanyUserStorageListener;
use Spryker\Zed\ShoppingListStorage\Communication\Plugin\Event\Listener\ShoppingListItemStorageListener;
use Spryker\Zed\ShoppingListStorage\Communication\Plugin\Event\Listener\ShoppingListStorageListener;
use Spryker\Zed\ShoppingListStorage\Communication\Plugin\Event\Listener\ShoppingListStoragePublishListener;

/**
 * @method \Spryker\Zed\ShoppingListStorage\Business\ShoppingListStorageFacadeInterface getFacade()
 * @method \Spryker\Zed\ShoppingListStorage\Communication\ShoppingListStorageCommunicationFactory getFactory()
 * @method \Spryker\Zed\ShoppingListStorage\ShoppingListStorageConfig getConfig()
 */
class ShoppingListStorageEventSubscriber extends AbstractPlugin implements EventSubscriberInterface
{
    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Spryker\Zed\Event\Dependency\EventCollectionInterface $eventCollection
     *
     * @return \Spryker\Zed\Event\Dependency\EventCollectionInterface
     */
    public function getSubscribedEvents(EventCollectionInterface $eventCollection): EventCollectionInterface
    {
        $this->addShoppingListCreateListener($eventCollection);
        $this->addShoppingListUpdateListener($eventCollection);
        $this->addShoppingListPublishListener($eventCollection);
        $this->addShoppingListItemCreateListener($eventCollection);
        $this->addShoppingListItemDeleteListener($eventCollection);
        $this->addShoppingListCompanyUserCreateListener($eventCollection);
        $this->addShoppingListCompanyUserDeleteListener($eventCollection);
        $this->addShoppingListCompanyUserUpdateListener($eventCollection);
        $this->addShoppingListCompanyBusinessUnitCreateListener($eventCollection);
        $this->addShoppingListCompanyBusinessUnitUpdateListener($eventCollection);

        return $eventCollection;
    }

    /**
     * @param \Spryker\Zed\Event\Dependency\EventCollectionInterface $eventCollection
     *
     * @return void
     */
    protected function addShoppingListCreateListener(EventCollectionInterface $eventCollection): void
    {
        $eventCollection->addListenerQueued(ShoppingListEvents::ENTITY_SPY_SHOPPING_LIST_CREATE, new ShoppingListStorageListener(), 0, null, $this->getConfig()->getEventQueueName());
    }

    /**
     * @param \Spryker\Zed\Event\Dependency\EventCollectionInterface $eventCollection
     *
     * @return void
     */
    protected function addShoppingListUpdateListener(EventCollectionInterface $eventCollection): void
    {
        $eventCollection->addListenerQueued(ShoppingListEvents::ENTITY_SPY_SHOPPING_LIST_UPDATE, new ShoppingListStorageListener(), 0, null, $this->getConfig()->getEventQueueName());
    }

    /**
     * @param \Spryker\Zed\Event\Dependency\EventCollectionInterface $eventCollection
     *
     * @return void
     */
    protected function addShoppingListPublishListener(EventCollectionInterface $eventCollection): void
    {
        $eventCollection->addListenerQueued(ShoppingListEvents::SHOPPING_LIST_UNPUBLISH, new ShoppingListStoragePublishListener(), 0, null, $this->getConfig()->getEventQueueName());
    }

    /**
     * @param \Spryker\Zed\Event\Dependency\EventCollectionInterface $eventCollection
     *
     * @return void
     */
    protected function addShoppingListItemCreateListener(EventCollectionInterface $eventCollection): void
    {
        $eventCollection->addListenerQueued(ShoppingListEvents::ENTITY_SPY_SHOPPING_LIST_ITEM_CREATE, new ShoppingListItemStorageListener(), 0, null, $this->getConfig()->getEventQueueName());
    }

    /**
     * @param \Spryker\Zed\Event\Dependency\EventCollectionInterface $eventCollection
     *
     * @return void
     */
    protected function addShoppingListItemDeleteListener(EventCollectionInterface $eventCollection): void
    {
        $eventCollection->addListenerQueued(ShoppingListEvents::ENTITY_SPY_SHOPPING_LIST_ITEM_DELETE, new ShoppingListItemStorageListener(), 0, null, $this->getConfig()->getEventQueueName());
    }

    /**
     * @param \Spryker\Zed\Event\Dependency\EventCollectionInterface $eventCollection
     *
     * @return void
     */
    protected function addShoppingListCompanyUserUpdateListener(EventCollectionInterface $eventCollection): void
    {
        $eventCollection->addListenerQueued(ShoppingListEvents::ENTITY_SPY_SHOPPING_LIST_COMPANY_USER_UPDATE, new ShoppingListCompanyUserStorageListener(), 0, null, $this->getConfig()->getEventQueueName());
    }

    /**
     * @param \Spryker\Zed\Event\Dependency\EventCollectionInterface $eventCollection
     *
     * @return void
     */
    protected function addShoppingListCompanyUserCreateListener(EventCollectionInterface $eventCollection): void
    {
        $eventCollection->addListenerQueued(ShoppingListEvents::ENTITY_SPY_SHOPPING_LIST_COMPANY_USER_CREATE, new ShoppingListCompanyUserStorageListener(), 0, null, $this->getConfig()->getEventQueueName());
    }

    /**
     * @param \Spryker\Zed\Event\Dependency\EventCollectionInterface $eventCollection
     *
     * @return void
     */
    protected function addShoppingListCompanyUserDeleteListener(EventCollectionInterface $eventCollection): void
    {
        $eventCollection->addListenerQueued(ShoppingListEvents::ENTITY_SPY_SHOPPING_LIST_COMPANY_USER_DELETE, new ShoppingListCompanyUserStorageListener(), 0, null, $this->getConfig()->getEventQueueName());
    }

    /**
     * @param \Spryker\Zed\Event\Dependency\EventCollectionInterface $eventCollection
     *
     * @return void
     */
    protected function addShoppingListCompanyBusinessUnitCreateListener(EventCollectionInterface $eventCollection): void
    {
        $eventCollection->addListenerQueued(ShoppingListEvents::ENTITY_SPY_SHOPPING_LIST_COMPANY_BUSINESS_UNIT_CREATE, new ShoppingListCompanyBusinessUnitStorageListener(), 0, null, $this->getConfig()->getEventQueueName());
    }

    /**
     * @param \Spryker\Zed\Event\Dependency\EventCollectionInterface $eventCollection
     *
     * @return void
     */
    protected function addShoppingListCompanyBusinessUnitUpdateListener(EventCollectionInterface $eventCollection): void
    {
        $eventCollection->addListenerQueued(ShoppingListEvents::ENTITY_SPY_SHOPPING_LIST_COMPANY_BUSINESS_UNIT_UPDATE, new ShoppingListCompanyBusinessUnitStorageListener(), 0, null, $this->getConfig()->getEventQueueName());
    }
}
