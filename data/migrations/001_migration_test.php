<?php

/**
 * Migrations between versions 000 and 001.
 */
class Migration001 extends sfMigration
{
  /**
   * Migrate up to version 001.
   */
  public function up()
  {
    $this->loadSql(dirname(__FILE__).'/001_migration_test.sql');
  }

  /**
   * Migrate down to version 000.
   */
  public function down()
  {
    $this->executeSQL('SET FOREIGN_KEY_CHECKS=0');
    
    $this->executeSQL('DROP TABLE auth_gruppe');
    $this->executeSQL('DROP TABLE auth_modul');
    $this->executeSQL('DROP TABLE auth_gruppe_modul');
    $this->executeSQL('DROP TABLE auth_gruppe_werkstattkunde');
    $this->executeSQL('DROP TABLE auth_benutzer');
    $this->executeSQL('DROP TABLE auth_benutzer_gruppe');
    $this->executeSQL('DROP TABLE auth_benutzer_modul');
    $this->executeSQL('DROP TABLE taxibot_tractor');
    $this->executeSQL('DROP TABLE taxibot_activity');
    $this->executeSQL('DROP TABLE taxibot_log');
    $this->executeSQL('DROP TABLE taxibot_table');
    $this->executeSQL('DROP TABLE taxibot_alert');
    $this->executeSQL('DROP TABLE taxibot_cancel');
    $this->executeSQL('DROP TABLE taxibot_vector');
    $this->executeSQL('DROP TABLE taxibot_stack');
    $this->executeSQL('DROP TABLE taxibot_trail');
    $this->executeSQL('DROP TABLE taxibot_mission');
    $this->executeSQL('DROP TABLE taxibot_exceed_event');
    $this->executeSQL('DROP TABLE aircraft');
    $this->executeSQL('DROP TABLE aircraft_type');
    $this->executeSQL('DROP TABLE taxibot_failure');
    $this->executeSQL('DROP TABLE towing_activity');
    
    $this->executeSQL('SET FOREIGN_KEY_CHECKS=1');
  }
}
