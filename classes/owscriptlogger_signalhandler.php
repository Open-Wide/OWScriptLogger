<?php

$isPcntl = function_exists( 'pcntl_signal' );
if ( $isPcntl ) {
	declare( ticks = 1 );

	function OWScriptLoggerSignalHandler( $signal ) {
		try {
			$logger = OWScriptLogger::instance();
		} catch ( Exception $e ) {
			return FALSE;
		}
		$ini = eZINI::instance( 'owscriptlogger.ini' );
		if ( $ini->hasVariable( 'AdditionalSignalHandler', 'Callback' ) ) {
			foreach ( $ini->variable( 'AdditionalSignalHandler', 'Callback' ) as $callback => $filepath ) {
				if ( file_exists( $filepath ) ) {
					require_once $filepath;
					if ( function_exists( $callback ) ) {
						call_user_func( $callback, $signal );
					}
				}
			}
		}
		switch ( $signal ) {
			case SIGTERM :
			case SIGINT :
				$logger->logNotice( 'Process stoped', 'signal' );
				if ( OWScriptLogger::$_storeObjectInDB ) {
					$logger->storeExtraInfo();
					$logger->setAttribute( 'status', OWScriptLogger::STOPED_STATUS );
					$logger->store();
				}
				posix_kill( posix_getpid(), SIGKILL );
		}
	}

	pcntl_signal( SIGTERM, 'OWScriptLoggerSignalHandler' );
	pcntl_signal( SIGINT, 'OWScriptLoggerSignalHandler' );
}

function OWScriptLoggerFatalError() {
	try {
		$logger = OWScriptLogger::instance();
	} catch ( Exception $e ) {
		return FALSE;
	}
	if ( $logger->attribute( 'status' ) == OWScriptLogger::RUNNING_STATUS ) {
		$error = error_get_last();
		if ( $error && $error['message'] ) {
			$message = $error['message'] . PHP_EOL . $error['file'] . ' on line ' . $error['line'];
		} else {
			$message = "Unknown error";
		}
		$logger->logError( $message, 'fatal_error' );
		$logger->sendFatalErrorMessage( $message );
		if ( OWScriptLogger::$_storeObjectInDB ) {
			$logger->storeExtraInfo();
			$logger->setAttribute( 'status', OWScriptLogger::ERROR_STATUS );
			$logger->store();
		}
	}
}

function OWScriptLoggerExceptionHandler( Exception $e ) {
	try {
		$logger = OWScriptLogger::instance();
	} catch ( Exception $e ) {
		return FALSE;
	}
	$logger->logError( $e->getMessage() . PHP_EOL . $e->getTraceAsString(), 'exception' );
	if ( OWScriptLogger::$_storeObjectInDB ) {
		$logger->storeExtraInfo();
		$logger->setAttribute( 'status', OWScriptLogger::ERROR_STATUS );
		$logger->store();
	}
}

function OWScriptLoggerCleanupHandler() {
	$db = eZDB::instance();
	if ( $db->errorNumber() > 0 ) {
		try {
			$logger = OWScriptLogger::instance();
		} catch ( Exception $e ) {
			return FALSE;
		}
		$message = 'A DB transaction error occurred : #' . $db->errorNumber() . ' - "' . $db->errorMessage() . '"';
		$logger->logError( $message, 'fatal_error' );
		$logger->sendFatalErrorMessage( $message );
		if ( OWScriptLogger::$_storeObjectInDB ) {
			$logger->storeExtraInfo();
			$logger->setAttribute( 'status', OWScriptLogger::ERROR_STATUS );
			$logger->store();
		}
	}
}

function OWScriptLoggerNoticeError($errno, $errstr, $errfile, $errline) {
    OWScriptLogger::logWarning("PHP Notice: $errstr in $errfile on line $errline", 'php_notice');
}

function OWScriptLoggerWarningError($errno, $errstr, $errfile, $errline) {
    OWScriptLogger::logWarning("PHP Warning: $errstr in $errfile on line $errline", 'php_warning');
}
