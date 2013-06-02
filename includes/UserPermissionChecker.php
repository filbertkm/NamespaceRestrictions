<?php
/**
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.
 * http://www.gnu.org/copyleft/gpl.html
 *
 * @since 0.1
 *
 * @file
 * @ingroup NamespaceRestriction
 *
 * @licence GNU GPL v2+
 * @author Katie Filbert < aude.wiki@gmail.com >
 */

class UserPermissionChecker {

	protected $namespaceCreateProtection;

	public function __construct( array $namespaceCreateProtection ) {
		$this->namespaceCreateProtection = $namespaceCreateProtection;
	}

	public function canCreateTitle( User $user, Title $title ) {
		if (
			( $title->isTalkPage() && !$user->isAllowed( 'createtalk' ) ) ||
			( !$title->isTalkPage() && !$user->isAllowed( 'createpage' ) )
		) {
			return false;
		}

		$ns = $title->getNamespace();

		if ( array_key_exists( $ns, $this->namespaceCreateProtection ) ) {
			$nsPermission = $this->namespaceCreateProtection[$ns];

			if ( is_array( $nsPermission ) ) {
				foreach( $nsPermission as $permission ) {
					if ( !$user->isAllowed( $permission ) ) {
						return false;
					}
				}
			} else if ( is_string( $nsPermission ) && !$user->isAllowed( $nsPermission ) )  {
				return false;
			}
		}

		return true;
	}

}
