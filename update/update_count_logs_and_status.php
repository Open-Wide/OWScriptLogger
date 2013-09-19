<?php

require 'autoload.php';

$logs = OWScriptLogger::fetchList( );
foreach( $logs as $log ) {
    $log->setAttribute( 'notice_count', $log->countNotice( ) );
    $log->setAttribute( 'warning_count', $log->countWarning( ) );
    $log->setAttribute( 'error_count', $log->countError( ) );
    $log->setAttribute( 'status', OWScriptLogger::FINISHED_STATUS );
    $log->store( );
}
?>
