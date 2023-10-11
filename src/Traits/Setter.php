<?php

/**
 * Useful PHP Traits
 * Copyright (C) 2023 Sebastian Meyer <sebastian.meyer@opencultureconsulting.com>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

declare(strict_types=1);

namespace OCC\Traits;

/**
 * Writes data to inaccessible properties by using magic methods.
 *
 * @author Sebastian Meyer <sebastian.meyer@opencultureconsulting.com>
 * @package opencultureconsulting/traits
 */
trait Setter
{
    /**
     * Write data to an inaccessible property.
     *
     * @param string $property The class property to set
     * @param mixed $value The new value of the property
     *
     * @return void
     *
     * @throws \InvalidArgumentException
     */
    final public function __set(string $property, mixed $value): void
    {
        $method = '_set' . ucfirst($property);
        if (
            property_exists(get_called_class(), $property)
            && method_exists(get_called_class(), $method)
        ) {
            $this->$method($value);
        } else {
            throw new \InvalidArgumentException('Invalid property or missing setter method for property "' . get_called_class() . '->' . $property . '".');
        }
    }

    /**
     * Unset an inaccessible property.
     *
     * @param string $property The class property to unset
     *
     * @return void
     *
     * @throws \InvalidArgumentException
     */
    final public function __unset(string $property): void
    {
        try {
            $this->__set($property, null);
        } catch (\InvalidArgumentException) {}
    }
}
