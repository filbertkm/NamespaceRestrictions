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

class UserPermissionCheckerTest extends MediaWikiTestCase {

	public function setUp() {
		parent::setUp();

		$permissions = array(
			'pagecreator' => array(
				'createpage' => true,
				'createtalk' => true
			),
			'helppagecreators' => array(
				'createhelp' => true
			),
			'nohelptalk' => array(
				'createhelptalk' => false
			)
		);

		$this->setMwGlobals( array(
			'wgGroupPermissions' => $permissions
		) );
	}

	public function testCanCreateNamespaceTitle() {
		$namespaceCreateProtection = array(
			NS_HELP => 'createhelp'
		);

		$userPermissionChecker = new UserPermissionChecker( $namespaceCreateProtection );

		$help = Title::newFromText( 'Help:Stroopwafels' );

		$user = new User();
		$user->addGroup( 'pagecreator' );

		$this->assertFalse(
			$userPermissionChecker->canCreateTitle( $user, $help ),
			'User does not have createhelp rights, cannot create help page.'
		);

		$user->addGroup( 'helppagecreators' );

		$this->assertTrue(
			$userPermissionChecker->canCreateTitle( $user, $help ),
			'User has createhelp rights and can create help page.'
		 );

		$user->removeGroup( 'helppagecreators' );
	}

	public function testDenyCreateNamespaceTitle() {
		$namespaceCreateProtection = array(
			NS_HELP_TALK => 'createhelptalk'
		);

		$userPermissionChecker = new UserPermissionChecker( $namespaceCreateProtection );

		$helpTalk = Title::newFromText( 'Help_talk:Stroopwafels' );

		$user = new User();
		$user->addGroup( 'pagecreator' );
		$user->addGroup( 'nohelptalk' );

		$this->assertFalse(
			$userPermissionChecker->canCreateTitle( $user, $helpTalk ),
			'User is in nohelptalk group and cannot create help talk pages.'
		);

		$user->removeGroup( 'nohelptalk' );
	}

}
