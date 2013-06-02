About
===
MediaWiki extension to allow restricting page creation per namespace.

Configuration
===

Set minimum permissions required for creating pages in each namespace.
If multiple permisison are listed, a user needs to have all of them
to create pages in that namespace, along with 'createpage' and
(if a talk page) 'createtalk'.

Default is no per-namespace create restrictions, although NS_MEDIAWIKI
is restricted via the 'editinterface' permission.

Restrict creating pages in the main namespace to registered users

    $wgNamespaceCreateProtection = array( NS_MAIN => 'createmain' );

    $wgGroupPermissions['*']['createmain'] = false;
    $wgGroupPermissions['user']['createmain'] = true;

Alternatively, per namespace protection can be an array of permissions

    $wgNamespaceCreateProtection = array( NS_MAIN => array( 'createmain', 'human' ) );
