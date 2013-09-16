<?php

class OWScriptLogger extends eZPersistentObject {
    const NOTICELOG = 'notice';
    const ERRORLOG = 'error';
    const WARNINGLOG = 'warning';

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
        $logger = new OWScriptLogger( $logIdentifier );
        $logger->store( );
        $GLOBALS['OWScriptLoggerInstance'] = $logger;
        OWScriptLogger::$_timer = new ezcDebugTimer( );
        OWScriptLogger::$_timer->startTimer( $logger->attribute( 'identifier' ), 'OWScriptLogger' );
    }

    public static function logMessage( $msg, $action = 'undefined', $bPrintMsg = true, $logType = self::NOTICELOG ) {
        try {
            $logger = self::instance( );
        } catch( Exceoption $e ) {
            self::writeError( $e->getMessage( ), 'log_message' );
            return FALSE;
        }
        $trans = eZCharTransform::instance( );
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
        } catch( Exceoption $e ) {
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
                    'default' => 0,
                    'required' => true
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
                    'datatype' => 'float',
                    'default' => null,
                    'required' => false
                ),
                'memory_usage_peak' => array(
                    'name' => 'memory_usage_peak',
                    'datatype' => 'float',
                    'default' => null,
                    'required' => false
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

    public function __destruct( ) {
        if( OWScriptLogger::$_timer instanceof ezcDebugTimer ) {
            $this->setAttribute( 'memory_usage_peak', memory_get_peak_usage( ) );
            $this->setAttribute( 'memory_usage', memory_get_usage( ) );
            OWScriptLogger::$_timer->stopTimer( $this->attribute( 'identifier' ) );
            $timeData = OWScriptLogger::$_timer->getTimeData( );
            $this->setAttribute( 'runtime', $timeData[0]->elapsedTime );
            $this->store( );
        }
    }

    public function getLogs( ) {
        return OWScriptLogger_Log::fetchList( array( 'owscriptlogger_id' => $this->attribute( 'id' ) ) );
    }

    public function getActions( ) {
        return OWScriptLogger_Log::fetchActionList( array( 'owscriptlogger_id' => $this->attribute( 'id' ) ) );
    }

    static function fetchList( $conds = array(), $limit = NULL ) {
        return self::fetchObjectList( self::definition( ), null, $conds, array( 'date' => 'asc', ), $limit, true, false, null, null, null );
    }

    static function fetch( $id ) {
        $conds = array( 'id' => $id );
        return self::fetchObject( self::definition( ), null, $conds, array( 'date' => 'asc', ) );
    }

    static function fetchIdentifierList( $conds = array(), $limit = NULL ) {
        $identifierList = self::fetchObjectList( self::definition( ), array( 'identifier' ), $conds, null, $limit, false, array( 'identifier' ), null, null, null );
        if( is_array( $identifierList ) ) {
            array_walk( $identifierList, function( &$item, $key ) {
                $item = $item['identifier'];
            } );
            return $identifierList;
        }
    }

    static function removeList( $IDList ) {
        OWScriptLogger_Log::removeByOWScriptLoggerId( $IDList );
        $conds = array( 'id' => array( $IDList ) );
        return self::removeObject( self::definition( ), $conds );
    }

}
