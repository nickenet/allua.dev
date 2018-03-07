<?

error_reporting ( E_ALL ^ E_NOTICE );
@ini_set ( 'display_errors', true );
@ini_set ( 'html_errors', false );
ini_set ('error_reporting', E_ALL & ~E_NOTICE);
srand ((double) microtime() * 10000000);


// Including configuration file
include ( ".././conf/config.php" );
$def_mainlocation_pda = $def_mainlocation.'/'.$def_pda;

// Including memberships
require_once ( ".././conf/memberships.php" );

// Including functions
include ( ".././includes/functions.php" );

// Including mysql class
include ( ".././includes/$def_dbtype.php" );

// Connecting to the database
include ( ".././connect.php" );

// Including functions for users
include ( "./inc/functions.php" );

// Including functions
include ( ".././includes/sqlfunctions.php" );

$lang = $def_language;
include ( ".././lang/language.$lang.php" );

// Including functions for users
include ( "./help/help.php" );

// Including configuration file for user panel
include ( "./config_users.php" );

?>