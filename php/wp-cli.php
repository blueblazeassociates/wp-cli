<?php

// Can be used by plugins/themes to check if WP-CLI is running or not
define( 'WP_CLI', true );
define( 'WP_CLI_VERSION', trim( file_get_contents( WP_CLI_ROOT . '/VERSION' ) ) );
define( 'WP_CLI_START_MICROTIME', microtime( true ) );

// Set common headers, to prevent warnings from plugins
$_SERVER['SERVER_PROTOCOL'] = 'HTTP/1.0';
$_SERVER['HTTP_USER_AGENT'] = '';
$_SERVER['REQUEST_METHOD'] = 'GET';
$_SERVER['REMOTE_ADDR'] = '127.0.0.1';

include WP_CLI_ROOT . '/php/utils.php';
include WP_CLI_ROOT . '/php/dispatcher.php';

\WP_CLI\Utils\load_dependencies();

// egifford 2015_02_10: Guarding inclusion of main classes. This helps protect against loading the class twice when using Composer autoloading.
// egifford 2015_02_10: Moving inclusion of main classes after the call to load_dependencies. These classes will probably be loaded there.
if ( ! class_exists( 'WP_CLI' ) ) {
  include WP_CLI_ROOT . '/php/class-wp-cli.php';
}

if ( ! class_exists( 'WP_CLI_Command' ) ) {
  include WP_CLI_ROOT . '/php/class-wp-cli-command.php';
}

WP_CLI::get_runner()->start();
