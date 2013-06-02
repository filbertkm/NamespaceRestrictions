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
 * @ingroup NamespaceRestrictions
 *
 * @licence GNU GPL v2+
 * @author Katie Filbert < aude.wiki@gmail.com >
 */

if ( !defined( 'MEDIAWIKI' ) ) {
    die( 'Not a valid entry point.' );
}

define( 'NAMESPACE_RESTRICTIONS_VERSION', '0.1' );

$wgExtensionCredits['other'][] = array(
    'path' => __DIR__,
    'name' => 'Namespace Restrictions',
    'version' => NAMESPACE_RESTRICTIONS_VERSION,
    'author' => 'Katie Filbert',
    'url' => 'https://www.mediawiki.org/wiki/Extension:NamespaceRestrictions',
    'descriptionmsg' => 'namespacerestrictions-desc'
);

$wgExtensionMessagesFiles['NamespaceRestrictions'] = __DIR__ . '/NamespaceRestrictions.i18n.php';

$wgAutoloadClasses['NamespaceRestrictionsHooks'] = __DIR__ . '/NamespaceRestrictions.hooks.php';

$wgAutoloadClasses['UserPermissionChecker'] = __DIR__ . '/includes/UserPermissionChecker.php';

$wgHooks['RegisterUnitTests'][]			= 'NamespaceRestrictionsHooks::onRegisterUnitTests';
$wgHooks['TitleQuickPermissions'][]		= 'NamespaceRestrictionsHooks::onTitleQuickPermissions';

/**
 * Set minimum permissions required for creating pages in each namespace.
 * If multiple permisison are listed, a user needs to have all of them
 * to create pages in that namespace, along with 'createpage' and
 * (if a talk page) 'createtalk'.
 *
 * Default is no per-namespace create restrictions, although NS_MEDIAWIKI
 * is restricted via the 'editinterface' permission.
 *
 * @par Example:
 * Restrict creating pages in the main namespace to registered users
 * @code
 *    $wgNamespaceCreateProtection = array( NS_MAIN => 'createmain' );
 *
 *    $wgGroupPermissions['*']['createmain'] = false;
 *    $wgGroupPermissions['user']['createmain'] = true;
 * @endcode
 *
 * @par Example:
 * Alternatively, per namespace protection can be an array of permissions
 * @code
 *    $wgNamespaceCreateProtection = array( NS_MAIN => array( 'createmain', 'human' ) );
 * @endcode
 */
if ( !isset( $wgNamespaceCreateProtection ) ) {
	$wgNamespaceCreateProtection = array();
}
