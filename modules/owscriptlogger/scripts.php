<?php

$Module = $Params["Module"];
if( is_callable( 'eZTemplate::factory' ) ) {
    $tpl = eZTemplate::factory( );
} else {
    include_once ('kernel/common/template.php');
    $tpl = templateInit( );
}

$ScriptIdentifier = $Params['ScriptIdentifier'];

if( is_null( $ScriptIdentifier ) ) {
    $tpl->setVariable( 'script_list', OWScriptLogger_Script::fetchList( ) );
    $Result['content'] = $tpl->fetch( 'design:owscriptlogger/scripts.tpl' );
} else {
    $script = OWScriptLogger_Script::fetch( $ScriptIdentifier );
    if( $Module->isCurrentAction( 'Configure' ) && $Module->hasActionParameter( 'ParametersArray' ) ) {
        $parametersArray = $Module->actionParameter( 'ParametersArray' );
        foreach( $parametersArray as $paramIdentifier => $paramValue ) {
            if( $script->hasAttribute( $paramIdentifier ) ) {
                $script->setAttribute( $paramIdentifier, $paramValue );
            }
        }
        $script->store( );
    }
    $tpl->setVariable( 'script', $script );
    $Result['content'] = $tpl->fetch( 'design:owscriptlogger/script_details.tpl' );
}

$Result['left_menu'] = 'design:owscriptlogger/menu.tpl';
if( function_exists( 'ezi18n' ) ) {
    $Result['path'] = array(
        array( 'text' => ezi18n( 'design/admin/parts/owscriptlogger/menu', 'Script logger' ) ),
        array(
            'url' => 'owscriptlogger/logs',
            'text' => ezi18n( 'design/admin/parts/owscriptlogger/menu', 'Scripts' )
        )
    );

} else {
    $Result['path'] = array(
        array( 'text' => ezpI18n::tr( 'design/admin/parts/owscriptlogger/menu', 'Script logger' ) ),
        array(
            'url' => 'owscriptlogger/scripts',
            'text' => ezpI18n::tr( 'design/admin/parts/owscriptlogger/menu', 'Scripts' )
        )
    );

}
