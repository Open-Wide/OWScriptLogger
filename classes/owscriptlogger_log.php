<?php

class OWScriptLogger_Log extends eZPersistentObject {

    public static function definition( ) {
        return array(
            'fields' => array(
                'owscriptlogger_id' => array(
                    'name' => 'owscriptlogger_id',
                    'datatype' => 'integer',
                    'default' => 0,
                    'required' => true
                ),
                'level' => array(
                    'name' => 'level',
                    'datatype' => 'string',
                    'default' => null,
                    'required' => true
                ),
                'action' => array(
                    'name' => 'action',
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
                'message' => array(
                    'name' => 'message',
                    'datatype' => 'text',
                    'default' => null,
                    'required' => false
                ),
            ),
            'keys' => array( ),
            'sort' => array( 'date' => 'asc' ),
            'grouping' => array( ),
            'class_name' => 'OWScriptLogger_Log',
            'name' => 'owscriptlogger_log',
            'function_attributes' => array( ),
            'set_functions' => array( )
        );
    }

    static function create( $row ) {
        $object = new self( $row );
        $object->store( );
        return $object;
    }

    static function fetchList( $conds = array(), $limit = NULL ) {
        return self::fetchObjectList( self::definition( ), null, $conds, array( 'date' => 'asc', ), $limit, true, false, null, null, null );
    }

    static function fetchActionList( $conds = array(), $limit = NULL ) {
        $actionList = self::fetchObjectList( self::definition( ), array( 'action' ), $conds, null, $limit, false, array( 'action' ), null, null, null );
        if( is_array( $actionList ) ) {
            foreach( $actionList as $key => $item ) {
                $actionList[$key] = $item['action'];
            }
        }
        return $actionList;
    }

    static function countLog( $conds = array() ) {
        return self::count( self::definition( ), $conds );
    }

    static function removeByOWScriptLoggerId( $IDList ) {
        $conds = array( 'owscriptlogger_id' => array( $IDList ) );
        return self::removeObject( self::definition( ), $conds );
    }

}
