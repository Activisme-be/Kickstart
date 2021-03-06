<?php

use Phinx\Migration\AbstractMigration;

class SessionTable extends AbstractMigration
{
    /**
     * Add the migration.
     */
    public function up() 
    {
        $this->execute("CREATE TABLE IF NOT EXISTS `ci_sessions` (
            `id` varchar(128) NOT NULL,
            `ip_address` varchar(45) NOT NULL,
            `timestamp` int(10) unsigned DEFAULT 0 NOT NULL,
            `data` blob NOT NULL,
            KEY `ci_sessions_timestamp` (`timestamp`)
        )");

        $this->execute("ALTER TABLE ci_sessions ADD PRIMARY KEY (id, ip_address)");
    }

    /**
     * Reverse the migration.
     */
    public function down() 
    {
        $this->dropTable('ci_sessions');
    }
}
