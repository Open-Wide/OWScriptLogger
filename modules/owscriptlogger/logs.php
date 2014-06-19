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
    $tpl->setVariable( 'logger_list', OWScriptLogger::fetchList( array(), 'desc' ) );
    $tpl->setVariable( 'logger_identifer_list', OWScriptLogger::fetchIdentifierList( ) );
    $Result['content'] = $tpl->fetch( 'design:owscriptlogger/logs.tpl' );
} else {
    $tpl->setVariable( 'logger', OWScriptLogger::fetch( $LoggerID ) );
    $Result['content'] = $tpl->fetch( 'design:owscriptlogger/log_details.tpl' );
}

$Result['left_menu'] = 'design:owscriptlogger/menu.tpl';
if( function_exists( 'ezi18n' ) ) {
    $Result['path'] = array(
        array( 'text' => ezi18n( 'design/admin/parts/owscriptlogger/menu', 'Script logger' ) ),
        array(
            'url' => 'owscriptlogger/logs',
            'text' => ezi18n( 'design/admin/parts/owscriptlogger/menu', 'Logs' )
        )
    );

} else {
    $Result['path'] = array(
        array( 'text' => ezpI18n::tr( 'design/admin/parts/owscriptlogger/menu', 'Script logger' ) ),
        array(
            'url' => 'owscriptlogger/logs',
            'text' => ezpI18n::tr( 'design/admin/parts/owscriptlogger/menu', 'Logs' )
        )
    );

}
