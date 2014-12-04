<?php

/**
 * Migrations between versions 001 and 002.
 */
class Migration002 extends sfMigration
{
  /**
   * Migrate up to version 002.
   */
  public function up()
  {
  	$this->executeSQL("ALTER TABLE taxibot_mission ADD COLUMN `test` INTEGER default 0 NOT NULL");
  }

  /**
   * Migrate down to version 001.
   */
  public function down()
  {
  	 $this->executeSQL("ALTER TABLE taxibot_mission DROP COLUMN `test`");
  }
}
