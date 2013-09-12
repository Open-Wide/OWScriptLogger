<?php

$Module = array( 'name' => 'OW Script Logger' );

$ViewList = array( );
$ViewList['logs'] = array(
    'script' => 'logs.php',
    'functions' => array( 'read' ),
    'default_navigation_part' => 'owscriptlogger',
    'ui_context' => 'view',
    'params' => array( 'LoggerID' ),
    'single_post_actions' => array( 'Delete' => 'Delete' ),
    'post_action_parameters' => array( 'Delete' => array( 'DeleteIDArray' => 'DeleteIDArray' ) )
);

$ViewList['graphs'] = array(
    'script' => 'graphs.php',
    'functions' => array( 'read' ),
    'default_navigation_part' => 'owmigration',
    'default_navigation_part' => 'owscriptlogger',
    'ui_context' => 'view',
    'params' => array( 'LoggerID' ),
);

$FunctionList['read'] = array( );
?>
