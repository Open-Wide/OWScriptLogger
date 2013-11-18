<?php

$Module = $Params["Module"];
include_once ('kernel/common/template.php');
$tpl = templateInit( );

$ScriptIdentifier = $Params['ScriptIdentifier'];

if( is_null( $ScriptIdentifier ) ) {
    if( $Module->isCurrentAction( 'Configure' ) && $Module->hasActionParameter( 'ParametersArray' ) ) {
        // store script configuration
    }
    $tpl->setVariable( 'script_list', OWScriptLogger_Script::fetchList( ) );
    $Result['content'] = $tpl->fetch( 'design:owscriptlogger/scripts.tpl' );
} else {
    $tpl->setVariable( 'script', OWScriptLogger_Script::fetch( $ScriptIdentifier ) );
    $Result['content'] = $tpl->fetch( 'design:owscriptlogger/script_details.tpl' );
}

$Result['left_menu'] = 'design:owscriptlogger/menu.tpl';
if( function_exists( 'ezi18n' ) ) {
    $Result['path'] = array( array(
            'url' => 'owscriptlogger/logs',
            'text' => ezi18n( 'owscriptlogger/scripts', 'Scripts' )
        ) );

} else {
    $Result['path'] = array( array(
            'url' => 'owscriptlogger/scripts',
            'text' => ezpI18n::tr( 'owscriptlogger/scripts', 'Scripts' )
        ) );

}
