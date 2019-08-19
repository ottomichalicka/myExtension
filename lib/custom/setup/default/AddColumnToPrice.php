<?php
namespace Aimeos\MW\Setup\Task;

class AddColumnToPrice extends TablesCreateMShop
{
    /**
     * Returns the list of task names which this task depends on.
     *
     * @return string[] List of task names
     */
    public function getPreDependencies()
    {
        return array( 'TablesCreateMShop' );
    }

    /**
     * Returns the list of task names which depends on this task.
     *
     * @return string[] List of task names
     */
    public function getPostDependencies()
    {
    }

    /**
     * Updates the schema and migrates the data
     */
    public function migrate()
    {

        $this->msg( 'Creating SUBSCRIPTIONS tables', 0 );
        $this->status( '' );
        //die;
        $ds = DIRECTORY_SEPARATOR;
        $files = array( 'db-price' => __DIR__ . $ds .'default'. $ds . 'schema'. $ds . 'price.php' );

        $this->setupSchema( $files );
    }

    /**
     * Undo all schema changes and migrate data back
     */
    public function rollback()
    {
    }

    /**
     * Cleans up old data required for roll back
     */
    public function clean()
    {
    }
}