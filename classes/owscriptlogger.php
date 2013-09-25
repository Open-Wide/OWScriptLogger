<?php

$isPcntl = function_exists( 'pcntl_signal' );
if( $isPcntl ) {
    declare( ticks = 1 );
    function OWScriptLoggerSignalHandler( $signal ) {
        try {
            $logger = OWScriptLogger::instance( );
        } catch( Exception $e ) {
            return FALSE;
        }
        switch( $signal ) {
            case SIGTERM :
            case SIGINT :
                $logger->logNotice( 'Process stoped', 'signal' );
                $logger->storeExtraInfo( );
                $logger->setAttribute( 'status', OWScriptLogger::STOPED_STATUS );
                $logger->store( );
                posix_kill( posix_getpid( ), SIGKILL );
        }
    }

    pcntl_signal( SIGTERM, 'OWScriptLoggerSignalHandler' );
    pcntl_signal( SIGINT, 'OWScriptLoggerSignalHandler' );
}

function OWScriptLoggerFatalError( ) {
    try {
        $logger = OWScriptLogger::instance( );
    } catch( Exception $e ) {
        return FALSE;
    }
    if( $logger->attribute( 'status' ) == OWScriptLogger::RUNNING_STATUS ) {
        $error = error_get_last( );
        if( $error && $error['message'] ) {
            $message = $error['message'] . PHP_EOL . $error['file'] . ' on line ' . $error['line'];
        } else {
            $message = "Unknown error";
        }
        $logger->logError( $message, 'fatal_error' );
        $logger->storeExtraInfo( );
        $logger->setAttribute( 'status', OWScriptLogger::ERROR_STATUS );
        $logger->store( );
    }
}

function OWScriptLoggerExceptionHandler( Exception $e ) {
    try {
        $logger = OWScriptLogger::instance( );
    } catch( Exception $e ) {
        return FALSE;
    }
    $logger->logError( $e->getMessage( ) . PHP_EOL . $e->getTraceAsString( ), 'exception' );
    $logger->storeExtraInfo( );
    $logger->setAttribute( 'status', OWScriptLogger::ERROR_STATUS );
    $logger->store( );
}

function OWScriptLoggerCleanupHandler( ) {
    $db = eZDB::instance( );
    if( $db->errorNumber( ) > 0 ) {
        $logger->logError( 'A DB transaction error occurred : #' . $db->errorNumber( ) . ' - "' . $db->errorMessage( ) . '"', 'fatal_error' );
        $logger->storeExtraInfo( );
        $logger->setAttribute( 'status', OWScriptLogger::ERROR_STATUS );
        $logger->store( );
    }
}

class OWScriptLogger extends eZPersistentObject {
    const NOTICELOG = 'notice';
    const ERRORLOG = 'error';
    const WARNINGLOG = 'warning';

    const RUNNING_STATUS = 'running';
    const FINISHED_STATUS = 'finished';
    const ERROR_STATUS = 'error';
    const STOPED_STATUS = 'manually_stoped';

    protected $_errorLogFile = 'owscriptlogger-error.log';
    protected $_warningLogFile = 'owscriptlogger-warning.log';
    protected $_noticeLogFile = 'owscriptlogger-notice.log';
    protected static $_timer;

    protected static $cli;

    static function instance( ) {
        if( !isset( $GLOBALS['OWScriptLoggerInstance'] ) || !($GLOBALS['OWScriptLoggerInstance'] instanceof OWScriptLogger) ) {
            throw new Exception( "OWScriptLogger instance not found. Call startLog() method before starting to log messages." );
        }
        return $GLOBALS['OWScriptLoggerInstance'];
    }

    public static function startLog( $logIdentifier ) {
        $trans = eZCharTransform::instance( );
        $logIdentifier = strtolower( preg_replace( '/([A-Z])/', '_$1', $logIdentifier ) );
        $logIdentifier = $trans->transformByGroup( $logIdentifier, 'identifier' );
        $logger = new OWScriptLogger( $logIdentifier );
        $logger->store( );
        eZExecution::addFatalErrorHandler( 'OWScriptLoggerFatalError' );
        eZExecution::addCleanupHandler( 'OWScriptLoggerCleanupHandler' );
        set_exception_handler( 'OWScriptLoggerExceptionHandler' );
        $GLOBALS['OWScriptLoggerInstance'] = $logger;
        OWScriptLogger::$_timer = new ezcDebugTimer( );
        OWScriptLogger::$_timer->startTimer( $logger->attribute( 'identifier' ), 'OWScriptLogger' );
    }

    public static function logMessage( $msg, $action = 'undefined', $bPrintMsg = true, $logType = self::NOTICELOG ) {
        try {
            $logger = self::instance( );
        } catch( Exception $e ) {
            self::writeError( $e->getMessage( ), 'log_message' );
            return FALSE;
        }
        $trans = eZCharTransform::instance( );
        $action = strtolower( preg_replace( '/([A-Z])/', '_$1', $action ) );
        $action = $trans->transformByGroup( $action, 'identifier' );
        switch( $logType ) {
            case self::ERRORLOG :
                $logFile = $logger->_errorLogFile;
                if( $bPrintMsg ) {
                    self::writeError( $msg, $action );
                }
                break;

            case self::WARNINGLOG :
                $logFile = $logger->_warningLogFile;
                if( $bPrintMsg ) {
                    self::writeWarning( $msg, $action );
                }
                break;

            case self::NOTICELOG :
            default :
                $logFile = $logger->_noticeLogFile;
                if( $bPrintMsg ) {
                    self::writeNotice( $msg, $action );
                }
                break;
        }
        $row = array(
            'owscriptlogger_id' => $logger->attribute( 'id' ),
            'date' => date( 'Y-m-d H:i:s' ),
            'level' => $logType,
            'action' => $action,
            'message' => $msg
        );
        OWScriptLogger_Log::create( $row );

        eZLog::write( $msg, $logFile );
    }

    public static function logNotice( $msg, $action = 'undefined', $bPrintMsg = true ) {
        self::logMessage( $msg, $action, $bPrintMsg, self::NOTICELOG );
    }

    public static function logWarning( $msg, $action = 'undefined', $bPrintMsg = true ) {
        self::logMessage( $msg, $action, $bPrintMsg, self::WARNINGLOG );
    }

    public static function logError( $msg, $action = 'undefined', $bPrintMsg = true ) {
        self::logMessage( $msg, $action, $bPrintMsg, self::ERRORLOG );
    }

    public static function writeMessage( $msg, $action = 'undefined', $logType = self::NOTICELOG ) {
        try {
            $logger = self::instance( );
            $label = $logger->attribute( 'identifier' );
        } catch( Exception $e ) {
            $label = 'OWScriptLogger';
        }
        self::$cli = eZCLI::instance( );
        $isWebOutput = self::$cli->isWebOutput( );
        $msg = $action . '::' . $msg;
        switch( $logType ) {
            case self::ERRORLOG :
                if( !$isWebOutput ) {
                    self::$cli->error( $msg );
                } else {
                    eZDebug::writeError( $msg, $label );
                }
                break;

            case self::WARNINGLOG :
                if( !$isWebOutput ) {
                    self::$cli->warning( $msg );
                } else {
                    eZDebug::writeWarning( $msg, $label );
                }
                break;

            case self::NOTICELOG :
            default :
                if( !$isWebOutput ) {
                    self::$cli->notice( $msg );
                } else {
                    eZDebug::writeNotice( $msg, $label );
                }
                break;
        }
    }

    public static function writeError( $msg, $action = 'undefined' ) {
        self::writeMessage( $msg, $action, self::ERRORLOG );
    }

    public static function writeWarning( $msg, $action = 'undefined' ) {
        self::writeMessage( $msg, $action, self::WARNINGLOG );
    }

    public static function writeNotice( $msg, $action = 'undefined' ) {
        self::writeMessage( $msg, $action, self::NOTICELOG );
    }

    /* eZPersistentObject methods */

    public static function definition( ) {
        return array(
            'fields' => array(
                'id' => array(
                    'name' => 'id',
                    'datatype' => 'integer',
                ),
                'identifier' => array(
                    'name' => 'identifier',
                    'datatype' => 'string',
                    'default' => null,
                    'required' => true
                ),
                'date' => array(
                    'name' => 'date',
                    'datatype' => 'string',
                    'default' => null,
                    'required' => true
                ),
                'runtime' => array(
                    'name' => 'runtime',
                    'datatype' => 'float',
                    'default' => null,
                    'required' => false
                ),
                'memory_usage' => array(
                    'name' => 'memory_usage',
                    'datatype' => 'integer',
                    'default' => null,
                    'required' => false
                ),
                'memory_usage_peak' => array(
                    'name' => 'memory_usage_peak',
                    'datatype' => 'integer',
                    'default' => null,
                    'required' => false
                ),
                'notice_count' => array(
                    'name' => 'notice_count',
                    'datatype' => 'integer',
                    'default' => 0,
                    'required' => false
                ),
                'warning_count' => array(
                    'name' => 'warning_count',
                    'datatype' => 'integer',
                    'default' => 0,
                    'required' => false
                ),
                'error_count' => array(
                    'name' => 'error_count',
                    'datatype' => 'integer',
                    'default' => 0,
                    'required' => false
                ),
                'status' => array(
                    'name' => 'status',
                    'datatype' => 'string',
                    'default' => self::RUNNING_STATUS,
                    'required' => true
                ),
            ),
            'keys' => array(
                'identifier',
                'date'
            ),
            'increment_key' => 'id',
            'sort' => array( 'date' => 'asc' ),
            'grouping' => array( ),
            'class_name' => 'OWScriptLogger',
            'name' => 'owscriptlogger',
            'function_attributes' => array(
                'logs' => 'getLogs',
                'actions' => 'getActions'
            ),
            'set_functions' => array( )
        );
    }

    public function __construct( $identifier_or_row ) {
        $row = array(
            'id' => NULL,
            'date' => date( 'Y-m-d H:i:s' ),
            'runtime' => NULL,
            'memory_usage' => NULL,
            'memory_usage_peak' => NULL
        );
        if( is_array( $identifier_or_row ) ) {
            $row = array_merge( $row, $identifier_or_row );
        } else {
            $trans = eZCharTransform::instance( );
            $identifier_or_row = $trans->transformByGroup( $identifier_or_row, 'identifier' );
            $row['identifier'] = $identifier_or_row;
        }
        parent::__construct( $row );
        $identifier = $this->attribute( 'identifier' );
        if( empty( $identifier ) ) {
            throw new OWScriptLoggerException( __METHOD__ . " : Script logger identifier must be set" );
        } else {
            $trans = eZCharTransform::instance( );
            $newIdentifier = $trans->transformByGroup( $identifier, 'identifier' );
            if( $newIdentifier != $identifier ) {
                $this->setAttribute( 'identifier', $newIdentifier );
            }
            $this->_errorLogFile = $identifier . '-error.log';
            $this->_warningLogFile = $identifier . '-warning.log';
            $this->_noticeLogFile = $identifier . '-notice.log';
        }
    }

    public function storeExtraInfo( ) {
        $this->setAttribute( 'notice_count', $this->countNotice( ) );
        $this->setAttribute( 'warning_count', $this->countWarning( ) );
        $this->setAttribute( 'error_count', $this->countError( ) );
        $this->setAttribute( 'memory_usage_peak', memory_get_peak_usage( ) );
        $this->setAttribute( 'memory_usage', memory_get_usage( ) );
        OWScriptLogger::$_timer->stopTimer( $this->attribute( 'identifier' ) );
        $timeData = OWScriptLogger::$_timer->getTimeData( );
        $this->setAttribute( 'runtime', $timeData[0]->elapsedTime );
        $this->store( );
    }

    public function __destruct( ) {
        if( OWScriptLogger::$_timer instanceof ezcDebugTimer ) {
            $this->storeExtraInfo( );
            if( $this->attribute( 'status' ) == self::RUNNING_STATUS ) {
                $this->setAttribute( 'status', self::FINISHED_STATUS );
                $this->store( );
            }
        }
    }

    public function getLogs( ) {
        return OWScriptLogger_Log::fetchList( array( 'owscriptlogger_id' => $this->attribute( 'id' ) ) );
    }

    public function getActions( ) {
        return OWScriptLogger_Log::fetchActionList( array( 'owscriptlogger_id' => $this->attribute( 'id' ) ) );
    }

    public function countNotice( ) {
        return $this->countLog( self::NOTICELOG );
    }

    public function countWarning( ) {
        return $this->countLog( self::WARNINGLOG );
    }

    public function countError( ) {
        return $this->countLog( self::ERRORLOG );
    }

    public function countLog( $level ) {
        return OWScriptLogger_Log::countLog( array(
            'owscriptlogger_id' => $this->attribute( 'id' ),
            'level' => $level
        ) );
    }

    static function fetchList( $conds = array(), $limit = NULL ) {
        return self::fetchObjectList( self::definition( ), null, $conds, array( 'date' => 'asc', ), $limit, true, false, null, null, null );
    }

    static function fetch( $id ) {
        $conds = array( 'id' => $id );
        return self::fetchObject( self::definition( ), null, $conds, array( 'date' => 'asc', ) );
    }

    static function fetchByIdentiferAndDate( $identifier, $date ) {
        $conds = array(
            'identifier' => $identifier,
            'date' => $date
        );
        return self::fetchObject( self::definition( ), null, $conds, array( 'date' => 'asc', ) );
    }

    static function fetchIdentifierList( $conds = array(), $limit = NULL ) {
        $identifierList = self::fetchObjectList( self::definition( ), array( 'identifier' ), $conds, null, $limit, false, array( 'identifier' ), null, null, null );
        if( is_array( $identifierList ) ) {
            foreach( $identifierList as $key => $item ) {
                $identifierList[$key] = $item['identifier'];
            }
        }
        return $identifierList;
    }

    static function removeList( $IDList ) {
        OWScriptLogger_Log::removeByOWScriptLoggerId( $IDList );
        $conds = array( 'id' => array( $IDList ) );
        return self::removeObject( self::definition( ), $conds );
    }

}
