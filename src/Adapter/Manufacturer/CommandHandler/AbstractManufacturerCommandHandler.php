<?php
/**
 * 2007-2019 PrestaShop and Contributors
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/OSL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to https://www.prestashop.com for more information.
 *
 * @author    PrestaShop SA <contact@prestashop.com>
 * @copyright 2007-2019 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/OSL-3.0 Open Software License (OSL 3.0)
 * International Registered Trademark & Property of PrestaShop SA
 */

namespace PrestaShop\PrestaShop\Adapter\Manufacturer\CommandHandler;

use Manufacturer;
use PrestaShop\PrestaShop\Adapter\Manufacturer\AbstractManufacturerHandler;
use PrestaShop\PrestaShop\Core\Domain\Manufacturer\Exception\ManufacturerException;
use PrestaShop\PrestaShop\Core\Domain\Manufacturer\Exception\ManufacturerNotFoundException;
use PrestaShop\PrestaShop\Core\Domain\Manufacturer\ValueObject\ManufacturerId;
use PrestaShopException;

/**
 * Provides reusable methods for manufacturer command handlers
 */
abstract class AbstractManufacturerCommandHandler extends AbstractManufacturerHandler
{
    /**
     * Gets legacy Manufacturer
     *
     * @param ManufacturerId $manufacturerId
     *
     * @return Manufacturer
     *
     * @throws ManufacturerNotFoundException
     */
    protected function getManufacturer(ManufacturerId $manufacturerId)
    {
        $manufacturer = new Manufacturer($manufacturerId->getValue());
        $this->assertManufacturerWasFound($manufacturerId, $manufacturer);

        return $manufacturer;
    }

    /**
     * Deletes legacy Manufacturer
     *
     * @param Manufacturer $manufacturer
     *
     * @return bool
     *
     * @throws ManufacturerException
     */
    protected function deleteManufacturer(Manufacturer $manufacturer)
    {
        try {
            return $manufacturer->delete();
        } catch (PrestaShopException $e) {
            throw new ManufacturerException(sprintf(
                'An error occurred when deleting Manufacturer object with id "%s".',
                $manufacturer->id
            ));
        }
    }

    /**
     * Toggles legacy manufacturer status
     *
     * @param Manufacturer $manufacturer
     * @param bool $newStatus
     *
     * @return bool
     *
     * @throws ManufacturerException
     */
    protected function toggleManufacturerStatus(Manufacturer $manufacturer, $newStatus)
    {
        $manufacturer->active = $newStatus;

        try {
            return $manufacturer->save();
        } catch (PrestaShopException $e) {
            throw new ManufacturerException(sprintf(
                'An error occurred when updating manufacturer status with id "%s"',
                $manufacturer->id
            ));
        }
    }
}
