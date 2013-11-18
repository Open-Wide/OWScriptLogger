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
$ViewList['scripts'] = array(
    'script' => 'scripts.php',
    'functions' => array( 'configure' ),
    'default_navigation_part' => 'owscriptlogger',
    'ui_context' => 'view',
    'params' => array( 'ScriptIdentifier' ),
    'single_post_actions' => array( 'Configure' => 'Configure' ),
    'post_action_parameters' => array( 'Configure' => array( 'ParametersArray' => 'ParametersArray' ) )
);

$FunctionList['read'] = array( );
$FunctionList['configure'] = array( );
?>
