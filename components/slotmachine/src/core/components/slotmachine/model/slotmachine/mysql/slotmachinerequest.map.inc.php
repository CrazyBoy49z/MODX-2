<?php
$xpdo_meta_map['SlotmachineRequest'] = array(
    'package' => 'slotmachine',
    'version' => '1.1',
    'table' => 'slotmachine_request',
    'extends' => 'xPDOSimpleObject',
    'fields' =>
        array(
            'office' => '',
            'email' => '',
            'code' => '',
            'gift' => '',
            'active' => 1,
        ),
    'fieldMeta' =>
        array(
            'office' =>
                array(
                    'dbtype' => 'varchar',
                    'precision' => '100',
                    'phptype' => 'string',
                    'null' => false,
                ),
            'email' =>
                array(
                    'dbtype' => 'varchar',
                    'precision' => '100',
                    'phptype' => 'string',
                    'null' => false,
                ),
            'code' =>
                array(
                    'dbtype' => 'varchar',
                    'precision' => '100',
                    'phptype' => 'string',
                    'null' => false,
                ),
            'gift' =>
                array(
                    'dbtype' => 'varchar',
                    'precision' => '100',
                    'phptype' => 'string',
                    'null' => false,
                ),
            'active' =>
                array (
                    'dbtype' => 'tinyint',
                    'precision' => '1',
                    'phptype' => 'boolean',
                    'null' => true,
                    'default' => 1,
                ),
        ),
);
