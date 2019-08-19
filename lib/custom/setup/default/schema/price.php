<?php
return array(
    'table' => array(
        'mshop_price' => function ( \Doctrine\DBAL\Schema\Schema $schema ) {

            $table = $schema->getTable( 'mshop_price' );
            $table->addColumn( 'test', 'decimal', array( 'precision' => 12, 'scale' => 2 ) );
            $table->addIndex( array( 'siteid', 'domain', 'test' ), 'idx_mspri_sid_dom_test' );

            return $schema;
        },
    ),
);