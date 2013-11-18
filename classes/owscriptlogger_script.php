<?php

class OWScriptLogger_Script extends eZPersistentObject {

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
                'database_log_level' => array(
                    'name' => 'database_log_level',
                    'datatype' => 'string',
                    'default' => 'notice',
                    'required' => true
                ),
                'fatal_error_recipients' => array(
                    'name' => 'fatal_error_recipients',
                    'datatype' => 'text',
                    'default' => null,
                    'required' => false
                ),
                'max_age_error' => array(
                    'name' => 'max_age_error',
                    'datatype' => 'integer',
                ),
                'max_age_finished' => array(
                    'name' => 'max_age_finished',
                    'datatype' => 'integer',
                ),
                'max_age_manually_stoped' => array(
                    'name' => 'max_age_manually_stoped',
                    'datatype' => 'integer',
                ),
            ),
            'increment_key' => 'id',
            'keys' => array( 'identifier' ),
            'sort' => array( 'identifier' => 'asc' ),
            'grouping' => array( ),
            'class_name' => 'OWScriptLogger_Script',
            'name' => 'owscriptlogger_script',
            'function_attributes' => array( ),
            'set_functions' => array( )
        );
    }

    static function findOrCreate( $identifier ) {
        $object = self::fetch( $identifier );
        if( !$object instanceof self ) {
            $object = self::create( $identifier );
        }
        return $object;
    }

    static function create( $row_or_identifier ) {
        $row = array(
            'id' => NULL,
            'identifier' => NULL
        );
        if( is_string( $row_or_identifier ) ) {
            $row['identifier'] = $row_or_identifier;
        }
        $object = new self( $row );
        $object->store( );
        return $object;
    }

    static function fetch( $id_or_identifier ) {
        if( is_numeric( $id_or_identifier ) ) {
            $conds = array( 'id' => $id_or_identifier );
        } else {
            $conds = array( 'identifier' => $id_or_identifier );
        }
        return self::fetchObject( self::definition( ), null, $conds );
    }

    static function fetchList( $conds = array(), $limit = NULL ) {
        return self::fetchObjectList( self::definition( ), null, $conds, array( 'identifier' => 'asc', ), $limit, true, false, null, null, null );
    }

}
