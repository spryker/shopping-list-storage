<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\ShoppingListStorage\Dependency\Facade;

use Generated\Shared\Transfer\CompanyBusinessUnitTransfer;

interface ShoppingListStorageToCompanyBusinessUnitFacadeInterface
{
    /**
     * Specification:
     * - Finds a company business unit by CompanyBusinessUnitTransfer::idCompanyBusinessUnit in the transfer
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\CompanyBusinessUnitTransfer $companyBusinessUnitTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyBusinessUnitTransfer
     */
    public function getCompanyBusinessUnitById($companyBusinessUnitTransfer);

    /**
     * Specification:
     * - Return CompanyUserTransfer[] by CompanyBusinessUnitTransfer::idCompanyBusinessUnit in the transfer
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\CompanyBusinessUnitTransfer $companyBusinessUnitTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyUserTransfer[]
     */
    public function getCompanyUserCollection(CompanyBusinessUnitTransfer $companyBusinessUnitTransfer): array;
}
