<?php

$Module = $Params["Module"];
if( is_callable( 'eZTemplate::factory' ) ) {
    $tpl = eZTemplate::factory( );
} else {
    include_once ('kernel/common/template.php');
    $tpl = templateInit( );
}

$LoggerID = $Params['LoggerID'];

if( is_null( $LoggerID ) ) {
    if( $Module->isCurrentAction( 'Delete' ) && $Module->hasActionParameter( 'DeleteIDArray' ) ) {
        $deleteIDArray = $Module->actionParameter( 'DeleteIDArray' );
        OWScriptLogger::removeList( $deleteIDArray );
    }
    $tpl->setVariable( 'logger_list', OWScriptLogger::fetchList( ) );
    $tpl->setVariable( 'logger_identifer_list', OWScriptLogger::fetchIdentifierList( ) );
    $Result['content'] = $tpl->fetch( 'design:owscriptlogger/logs.tpl' );
} else {
    $tpl->setVariable( 'logger', OWScriptLogger::fetch( $LoggerID ) );
    $Result['content'] = $tpl->fetch( 'design:owscriptlogger/log_details.tpl' );
}

$Result['left_menu'] = 'design:owscriptlogger/menu.tpl';
if( function_exists( 'ezi18n' ) ) {
    $Result['path'] = array( array(
            'url' => 'owscriptlogger/logs',
            'text' => ezi18n( 'owscriptlogger/logs', 'Logs' )
        ) );

} else {
    $Result['path'] = array( array(
            'url' => 'owscriptlogger/logs',
            'text' => ezpI18n::tr( 'owscriptlogger/logs', 'Logs' )
        ) );

}
