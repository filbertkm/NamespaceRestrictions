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

class NamespaceRestrictionHooks {

	/**
	 * Hook to add PHPUnit test cases.
	 * @see https://www.mediawiki.org/wiki/Manual:Hooks/UnitTestsList
	 *
	 * @since 0.1
	 *
	 * @param array $files
	 *
	 * @return bool
	 */
	public static function onRegisterUnitTests( array &$files ) {
		$testFiles = array(
			'UserPermissionChecker',
		);

		foreach ( $testFiles as $file ) {
			$files[] = __DIR__ . '/tests/phpunit/' . $file . 'Test.php';
		}

		return true;
	}

	/**
	 * @since 0.1
	 *
	 * @param Title $title
	 * @param User $user
	 * @param string $action
	 * @param array $errors
	 * @param boolean $doExpensiveQueries
	 * @param boolean $short
	 *
	 * @return boolean
	 */
	public static function onTitleQuickPermissions( $title, $user, $action, $errors, $doExpensiveQueries, $short ) {
		global $wgNamespaceCreateProtection;

		$userPermissionChecker = new UserPermissionChecker( $wgNamespaceCreateProtection );

		if ( $action === 'create' ) {
			if ( !$userPermissionChecker->canCreateTitle( $user, $title ) ) {
				$errors[] = $user->isAnon() ? array( 'nocreatetext' ) : array( 'nocreate-loggedin' );
			}
		}

		return true;
	}

}
