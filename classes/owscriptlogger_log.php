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
            'keys' => array(
                'owscriptlogger_id',
                'level',
                'action',
                'date'
            ),
            'sort' => array( 'date' => 'asc' ),
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

}
