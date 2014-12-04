
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

#-----------------------------------------------------------------------------
#-- auth_gruppe
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `auth_gruppe`;


CREATE TABLE `auth_gruppe`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(255)  NOT NULL,
	`beschreibung` VARCHAR(255),
	PRIMARY KEY (`id`)
)Engine=InnoDB COMMENT='Hier sind alle Benutzergruppen des Systems gespeichert';

#-----------------------------------------------------------------------------
#-- auth_modul
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `auth_modul`;


CREATE TABLE `auth_modul`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(255),
	PRIMARY KEY (`id`)
)Engine=InnoDB COMMENT='Hier sind alle Module von Legos aufgelistet';

#-----------------------------------------------------------------------------
#-- auth_gruppe_modul
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `auth_gruppe_modul`;


CREATE TABLE `auth_gruppe_modul`
(
	`gruppe_id` INTEGER  NOT NULL,
	`modul_id` INTEGER  NOT NULL,
	PRIMARY KEY (`gruppe_id`,`modul_id`),
	CONSTRAINT `auth_gruppe_modul_FK_1`
		FOREIGN KEY (`gruppe_id`)
		REFERENCES `auth_gruppe` (`id`),
	INDEX `auth_gruppe_modul_FI_2` (`modul_id`),
	CONSTRAINT `auth_gruppe_modul_FK_2`
		FOREIGN KEY (`modul_id`)
		REFERENCES `auth_modul` (`id`)
)Engine=InnoDB COMMENT='N x M Verbindungen von Gruppen und Modulen';

#-----------------------------------------------------------------------------
#-- auth_gruppe_werkstattkunde
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `auth_gruppe_werkstattkunde`;


CREATE TABLE `auth_gruppe_werkstattkunde`
(
	`gruppe_id` INTEGER  NOT NULL,
	`werkstattkunde_id` INTEGER  NOT NULL,
	PRIMARY KEY (`gruppe_id`,`werkstattkunde_id`),
	CONSTRAINT `auth_gruppe_werkstattkunde_FK_1`
		FOREIGN KEY (`gruppe_id`)
		REFERENCES `auth_gruppe` (`id`)
)Engine=InnoDB COMMENT='N X M Verbindungen von Gruppen und Kunden des Bereichs Werkstatt-Kunde';

#-----------------------------------------------------------------------------
#-- auth_benutzer
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `auth_benutzer`;


CREATE TABLE `auth_benutzer`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`login` VARCHAR(255)  NOT NULL,
	`passwort` VARCHAR(255) COMMENT 'Gehashtes Passwort (MD5) ohne Salt (alte Version).',
	`salt_string` VARCHAR(275) COMMENT 'Salt-String des jeweiligen Benutzers, der vor\'m Hashen an das Passwort angehängt wird.',
	`passwort_salted` VARCHAR(64) COMMENT 'Gehashtes Salt+Passwort (SHA256).',
	`name` VARCHAR(255)  NOT NULL,
	`beschreibung` VARCHAR(255),
	`last_login` VARCHAR(255) COMMENT 'Wird bei jedem Login gesetzt',
	`login_count` VARCHAR(255) COMMENT 'Wird bei jedem Login hochgezählt',
	PRIMARY KEY (`id`)
)Engine=InnoDB COMMENT='Hier sind alle Benutzer des Systems gespeichert';

#-----------------------------------------------------------------------------
#-- auth_benutzer_gruppe
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `auth_benutzer_gruppe`;


CREATE TABLE `auth_benutzer_gruppe`
(
	`gruppe_id` INTEGER  NOT NULL,
	`benutzer_id` INTEGER  NOT NULL,
	PRIMARY KEY (`gruppe_id`,`benutzer_id`),
	CONSTRAINT `auth_benutzer_gruppe_FK_1`
		FOREIGN KEY (`gruppe_id`)
		REFERENCES `auth_gruppe` (`id`),
	INDEX `auth_benutzer_gruppe_FI_2` (`benutzer_id`),
	CONSTRAINT `auth_benutzer_gruppe_FK_2`
		FOREIGN KEY (`benutzer_id`)
		REFERENCES `auth_benutzer` (`id`)
)Engine=InnoDB COMMENT='N x M Verbindungen von Benutzern und Gruppen';

#-----------------------------------------------------------------------------
#-- auth_benutzer_modul
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `auth_benutzer_modul`;


CREATE TABLE `auth_benutzer_modul`
(
	`modul_id` INTEGER  NOT NULL,
	`benutzer_id` INTEGER  NOT NULL,
	PRIMARY KEY (`modul_id`,`benutzer_id`),
	CONSTRAINT `auth_benutzer_modul_FK_1`
		FOREIGN KEY (`modul_id`)
		REFERENCES `auth_modul` (`id`),
	INDEX `auth_benutzer_modul_FI_2` (`benutzer_id`),
	CONSTRAINT `auth_benutzer_modul_FK_2`
		FOREIGN KEY (`benutzer_id`)
		REFERENCES `auth_benutzer` (`id`)
)Engine=InnoDB COMMENT='N x M Verbindungen von Benutzern und Modulen';

#-----------------------------------------------------------------------------
#-- taxibot_tractor
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `taxibot_tractor`;


CREATE TABLE `taxibot_tractor`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`tractor_id` INTEGER  NOT NULL,
	`name` VARCHAR(255) COMMENT 'Name of the tractor as given in csv-file.',
	`creation_date` TIMESTAMP NULL default CURRENT_TIMESTAMP COMMENT 'Date, when the tractor was added to the database.',
	`pcm_hours` FLOAT COMMENT 'Total time of pcm mode',
	`dcm_hours` FLOAT COMMENT 'Total time of dcm mode',
	PRIMARY KEY (`id`),
	INDEX `I_referenced_taxibot_activity_FK_1_1` (`tractor_id`)
)Engine=InnoDB COMMENT='Table of taxibot tractors';

#-----------------------------------------------------------------------------
#-- taxibot_activity
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `taxibot_activity`;


CREATE TABLE `taxibot_activity`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`csv_file_date` DATE COMMENT 'This dataset is taken from that days csv-file.',
	`tractor_id` INTEGER COMMENT 'Foreign key to the tractor-table.',
	`trip` INTEGER COMMENT 'Trip number of the flight.',
	`ac_registration` VARCHAR(255) COMMENT 'Registration code of the AC.',
	`position_from` VARCHAR(255) COMMENT 'Origin position of the aircraft.',
	`position_to` VARCHAR(255) COMMENT 'Destination position of the aircraft.',
	`departure` DATETIME COMMENT 'Timestamp when tractor departs.',
	`ready` DATETIME COMMENT 'Timestamp when tractor is ready for towing.',
	`completed` DATETIME COMMENT 'Timestamp when towing activity was completed.',
	`checked` TINYINT default 0 NOT NULL COMMENT 'True, if activity was manually checked.',
	PRIMARY KEY (`id`),
	INDEX `taxibot_activity_FI_1` (`tractor_id`),
	CONSTRAINT `taxibot_activity_FK_1`
		FOREIGN KEY (`tractor_id`)
		REFERENCES `taxibot_tractor` (`tractor_id`)
)Engine=InnoDB COMMENT='Taxibot towing activities.';

#-----------------------------------------------------------------------------
#-- taxibot_log
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `taxibot_log`;


CREATE TABLE `taxibot_log`
(
	`log_id` INTEGER  NOT NULL,
	`log_file` INTEGER COMMENT 'Log File Information',
	`tractor_id` INTEGER COMMENT 'Foreign key to the tractor-table.',
	`load` FLOAT COMMENT 'Weight',
	`date` DATETIME COMMENT 'date',
	`load_validity` TINYINT,
	`load_exceeded` TINYINT,
	PRIMARY KEY (`log_id`),
	INDEX `taxibot_log_FI_1` (`tractor_id`),
	CONSTRAINT `taxibot_log_FK_1`
		FOREIGN KEY (`tractor_id`)
		REFERENCES `taxibot_tractor` (`tractor_id`)
)Engine=InnoDB COMMENT='TaxibotLog';

#-----------------------------------------------------------------------------
#-- taxibot_table
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `taxibot_table`;


CREATE TABLE `taxibot_table`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`nlg_long_force` FLOAT COMMENT 'Measured load for the AC',
	`exceeding_amount` FLOAT COMMENT 'Load outside FATIGUE envelope',
	`aircraft_number` INTEGER COMMENT 'AC Tail number - Field No. 55',
	`tractor_id` INTEGER COMMENT 'Foreign key to the tractor-table.',
	`flight_number` VARCHAR(255) COMMENT 'Fields 60 - 67',
	`aircraft_type` INTEGER COMMENT 'mod_enum_acType',
	`time` DATETIME COMMENT 'UTC time Fields 1 - 6',
	`driver_name` VARCHAR(255) COMMENT 'From LEOS',
	`aircraft_weight` FLOAT COMMENT 'Tons Field 49',
	`aircraft_center_gravity` FLOAT COMMENT 'mac percent field 51',
	`latitude` FLOAT COMMENT 'degrees field 8',
	`longitude` FLOAT COMMENT 'degrees field 9',
	PRIMARY KEY (`id`)
)Engine=InnoDB COMMENT='TaxibotTable';

#-----------------------------------------------------------------------------
#-- taxibot_alert
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `taxibot_alert`;


CREATE TABLE `taxibot_alert`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`alert` VARCHAR(255)  NOT NULL,
	PRIMARY KEY (`id`)
)Engine=InnoDB COMMENT='TaxibotAlert';

#-----------------------------------------------------------------------------
#-- taxibot_cancel
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `taxibot_cancel`;


CREATE TABLE `taxibot_cancel`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`alert` VARCHAR(255)  NOT NULL,
	`time` DATETIME  NOT NULL COMMENT 'Time of cancel event',
	PRIMARY KEY (`id`)
)Engine=InnoDB COMMENT='TaxibotCancel';

#-----------------------------------------------------------------------------
#-- taxibot_vector
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `taxibot_vector`;


CREATE TABLE `taxibot_vector`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`utc_time` DATETIME  NOT NULL COMMENT 'UTC Date and Time',
	`mili_sec` INTEGER  NOT NULL COMMENT 'miliseconds past from last integral second',
	`utc_validity` TINYINT  NOT NULL COMMENT 'DGPS1 UTC-time status validity',
	`latitude` FLOAT  NOT NULL COMMENT 'Latitude (Inertial Sys)',
	`longitude` FLOAT  NOT NULL COMMENT 'Longitude (Inertial Sys)',
	`position_validity` TINYINT  NOT NULL COMMENT 'Position Validity',
	`velocity_north` FLOAT  NOT NULL COMMENT 'Vx (Inertial Sys)',
	`velocity_east` FLOAT  NOT NULL COMMENT 'Vy (Inertial Sys)',
	`velocity_validity` TINYINT  NOT NULL COMMENT 'Velocity Validity',
	`acceleration_north` FLOAT  NOT NULL COMMENT 'Ax (Inertial Sys)',
	`acceleration_east` FLOAT  NOT NULL COMMENT 'Ay (Inertial Sys)',
	`acceleration_z` FLOAT  NOT NULL COMMENT 'Az (Inertial Sys)',
	`azimuth` FLOAT  NOT NULL COMMENT 'Azimuth',
	`azimuth_validity` TINYINT  NOT NULL COMMENT 'Azimuth Validity',
	`mfl` VARCHAR(255)  NOT NULL COMMENT 'MFL (in DM1 format: Failures, Safety events,..); ',
	`vertical_link_front_right` FLOAT  NOT NULL COMMENT 'Vertical Link FR',
	`vertical_link_rear_left` FLOAT  NOT NULL COMMENT 'Vertical Link RL',
	`vertical_link_rear_right` FLOAT  NOT NULL COMMENT 'Vertical Link RR',
	`vertical_link_front_left` FLOAT  NOT NULL COMMENT 'Vertical Link FL',
	`lateral_link_front_right` FLOAT  NOT NULL COMMENT 'Lateral Link FR',
	`lateral_link_rear_left` FLOAT  NOT NULL COMMENT 'Lateral Link RL',
	`lateral_link_rear_right` FLOAT  NOT NULL COMMENT 'Lateral Link RR',
	`lateral_link_front_left` FLOAT  NOT NULL COMMENT 'Lateral Link FL',
	`damper_load1` VARCHAR(255)  NOT NULL COMMENT 'Damper Load #1',
	`damper_load2` VARCHAR(255)  NOT NULL COMMENT 'Damper Load #2',
	`damper_displacement` VARCHAR(255)  NOT NULL COMMENT 'Damper Displacement',
	`damper_velocity` VARCHAR(255)  NOT NULL COMMENT 'Damper Velocity',
	`vertical_link_front_right_validity` TINYINT  NOT NULL COMMENT 'Vertical Link FR Validity',
	`vertical_link_rear_left_validity` TINYINT  NOT NULL COMMENT 'Vertical Link RL Validity',
	`vertical_link_rear_right_validity` TINYINT  NOT NULL COMMENT 'Vertical Link RR Validity',
	`vertical_link_front_left_validity` TINYINT  NOT NULL COMMENT 'Vertical Link FL Validity',
	`lateral_link_front_right_validity` TINYINT  NOT NULL COMMENT 'Lateral Link FR Validity',
	`lateral_link_rear_left_validity` TINYINT  NOT NULL COMMENT 'Lateral Link RL Validity',
	`lateral_link_rear_right_validity` TINYINT  NOT NULL COMMENT 'Lateral Link RR Validity',
	`lateral_link_front_left_validity` TINYINT  NOT NULL COMMENT 'Lateral Link FL Validity',
	`damper_load1_validity` VARCHAR(255)  NOT NULL COMMENT 'Damper Load #1 Validity',
	`damper_load2_validity` VARCHAR(255)  NOT NULL COMMENT 'Damper Load #2 Validity',
	`damper_status` VARCHAR(255)  NOT NULL COMMENT 'Damper Displacement and Velocity Sensor Status',
	`gate1_position` VARCHAR(255)  NOT NULL COMMENT 'Cradle clamping load #1',
	`gate2_position` VARCHAR(255)  NOT NULL COMMENT 'Cradle clamping load #2',
	`clamping_gate_position` VARCHAR(255)  NOT NULL COMMENT 'Clamping gate position',
	`clamping_gate_pressure` VARCHAR(255)  NOT NULL COMMENT 'Clamping gate pressure',
	`aircraft_type` VARCHAR(255)  NOT NULL COMMENT 'A/C type',
	`aircraft_type_validity` VARCHAR(255)  NOT NULL COMMENT 'Aircraft     Type Validity',
	`aircraft_weight` FLOAT  NOT NULL COMMENT 'A/C weight',
	`aircraft_weight_validity` TINYINT  NOT NULL COMMENT 'A/C     weight Validity',
	`aircraft_cg` FLOAT  NOT NULL COMMENT 'A/C C.G.',
	`aircraft_cg_validity` TINYINT  NOT NULL COMMENT 'A/C C.G. Validity',
	`mission_id` INTEGER  NOT NULL COMMENT 'Mission ID',
	`mission_type` VARCHAR(255)  NOT NULL COMMENT 'Mission Type',
	`aircraft_tail_number` VARCHAR(255)  NOT NULL COMMENT 'A/C Tail No.',
	`cellulr_ip` VARCHAR(255)  NOT NULL COMMENT 'Cellular IP Addrtractor_idess - a.b.c.d (reference to Tractor ID)',
	`flight_number` VARCHAR(255)  NOT NULL COMMENT 'Flight Number',
	`wheel_angle_feedback_front_right` FLOAT  NOT NULL COMMENT 'WM Angle FR',
	`wheel_angle_feedback_front_left` FLOAT  NOT NULL COMMENT 'WM Angle FL',
	`wheel_angle_feedback_rear_right` FLOAT  NOT NULL COMMENT 'WM Angle RR',
	`wheel_angle_feedback_rear_left` FLOAT  NOT NULL COMMENT 'WM Angle RL',
	`wheel_angle_feedback_front_right_validity` TINYINT  NOT NULL COMMENT 'WM Angle FR Validity',
	`wheel_angle_feedback_front_left_validity` TINYINT  NOT NULL COMMENT 'WM Angle FL Validity',
	`wheel_angle_feedback_rear_right_validity` TINYINT  NOT NULL COMMENT 'WM Angle RR Validity',
	`wheel_angle_feedback_rear_left_validity` TINYINT  NOT NULL COMMENT 'WM Angle RL Validity',
	`pilot_command_angle` FLOAT  NOT NULL COMMENT 'Pilot command angle',
	`pilot_command_angle_validity` TINYINT  NOT NULL COMMENT 'Pilot command angle validity',
	`driving_mode` TINYINT  NOT NULL COMMENT 'Driving Mode - true: DCM, false:PCM',
	`actual_wheel_speed` FLOAT  NOT NULL COMMENT 'Actual Wheel Speed (LLC)',
	`desired_speed` FLOAT  NOT NULL COMMENT 'Desired Speed (HLC)',
	`actual_wheel_speed_validity` TINYINT  NOT NULL COMMENT 'Actual Wheel Speed Validity',
	`nlg_steering_angle` FLOAT  NOT NULL COMMENT 'NLG Steering Angle (HLC)',
	`nlg_steering_angle_validity` TINYINT  NOT NULL COMMENT 'NLG Steering Angle Validity',
	`turret_angle` FLOAT  NOT NULL COMMENT 'Turret Angle',
	`turret_angle_validity` TINYINT  NOT NULL COMMENT 'Turret Angle Validity',
	`nlg_logitudal_force` FLOAT  NOT NULL COMMENT 'NLG longitudinal force (HLC) along steer-demand axis ',
	`nlg_logitudal_force_validity` VARCHAR(255)  NOT NULL COMMENT 'NLG longitudinal force Validity (HLC)',
	`nlg_lateral_force` FLOAT  NOT NULL COMMENT 'NLG lateral force (HLC)  ',
	`nlg_logitudal_force_tug` FLOAT  NOT NULL COMMENT 'NLG longitudinal force  along tug axis (HLC)',
	`traction_demand` FLOAT  NOT NULL COMMENT 'Traction Demand',
	`pilot_break_detection_unfiltered` TINYINT  NOT NULL COMMENT 'Pilot-Break Detection (Unfiltered)',
	`pilot_break_detection_filtered` TINYINT  NOT NULL COMMENT 'Pilot-Break Detection (Filtered)',
	`pilot_break_estimation` FLOAT  NOT NULL COMMENT 'Pilot-Break Estimation',
	`is_exceeding` TINYINT  NOT NULL COMMENT 'nlg longitudal force exceeds permited value',
	`tractor_id` INTEGER COMMENT 'Foreign key to the tractor-table.',
	`total_right_engine_hours` FLOAT  NOT NULL COMMENT 'total_right_engine_hours',
	`total_left_engine_hours` FLOAT  NOT NULL COMMENT 'total left engine hours',
	`loading_step` VARCHAR(255)  NOT NULL COMMENT 'Loading Step',
	`total_fuel_used_engine_right` FLOAT  NOT NULL COMMENT 'total fuel used engine right',
	`total_fuel_used_engine_left` FLOAT COMMENT 'total fuel used engine left',
	PRIMARY KEY (`id`),
	INDEX `taxibot_vector_FI_1` (`tractor_id`),
	CONSTRAINT `taxibot_vector_FK_1`
		FOREIGN KEY (`tractor_id`)
		REFERENCES `taxibot_tractor` (`tractor_id`),
	INDEX `taxibot_vector_FI_2` (`aircraft_type`),
	CONSTRAINT `taxibot_vector_FK_2`
		FOREIGN KEY (`aircraft_type`)
		REFERENCES `aircraft_type` (`name`),
	INDEX `taxibot_vector_FI_3` (`mission_id`),
	CONSTRAINT `taxibot_vector_FK_3`
		FOREIGN KEY (`mission_id`)
		REFERENCES `taxibot_mission` (`mission_id`),
	INDEX `taxibot_vector_FI_4` (`aircraft_tail_number`),
	CONSTRAINT `taxibot_vector_FK_4`
		FOREIGN KEY (`aircraft_tail_number`)
		REFERENCES `aircraft` (`tail_number`)
)Engine=InnoDB COMMENT='TaxibotVector';

#-----------------------------------------------------------------------------
#-- taxibot_stack
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `taxibot_stack`;


CREATE TABLE `taxibot_stack`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`utc_time` DATETIME  NOT NULL COMMENT 'UTC Date and Time',
	`mili_sec` INTEGER  NOT NULL COMMENT 'miliseconds past from last integral second',
	`utc_validity` TINYINT  NOT NULL COMMENT 'DGPS1 UTC-time status validity',
	`latitude` FLOAT  NOT NULL COMMENT 'Latitude (Inertial Sys)',
	`longitude` FLOAT  NOT NULL COMMENT 'Longitude (Inertial Sys)',
	`position_validity` TINYINT  NOT NULL COMMENT 'Position Validity',
	`velocity_north` FLOAT  NOT NULL COMMENT 'Vx (Inertial Sys)',
	`velocity_east` FLOAT  NOT NULL COMMENT 'Vy (Inertial Sys)',
	`velocity_validity` TINYINT  NOT NULL COMMENT 'Velocity Validity',
	`acceleration_north` FLOAT  NOT NULL COMMENT 'Ax (Inertial Sys)',
	`acceleration_east` FLOAT  NOT NULL COMMENT 'Ay (Inertial Sys)',
	`acceleration_z` FLOAT  NOT NULL COMMENT 'Az (Inertial Sys)',
	`azimuth` FLOAT  NOT NULL COMMENT 'Azimuth',
	`azimuth_validity` TINYINT  NOT NULL COMMENT 'Azimuth Validity',
	`mfl` VARCHAR(255)  NOT NULL COMMENT 'MFL (in DM1 format: Failures, Safety events,..); ',
	`vertical_link_front_right` FLOAT  NOT NULL COMMENT 'Vertical Link FR',
	`vertical_link_rear_left` FLOAT  NOT NULL COMMENT 'Vertical Link RL',
	`vertical_link_rear_right` FLOAT  NOT NULL COMMENT 'Vertical Link RR',
	`vertical_link_front_left` FLOAT  NOT NULL COMMENT 'Vertical Link FL',
	`lateral_link_front_right` FLOAT  NOT NULL COMMENT 'Lateral Link FR',
	`lateral_link_rear_left` FLOAT  NOT NULL COMMENT 'Lateral Link RL',
	`lateral_link_rear_right` FLOAT  NOT NULL COMMENT 'Lateral Link RR',
	`lateral_link_front_left` FLOAT  NOT NULL COMMENT 'Lateral Link FL',
	`damper_load1` VARCHAR(255)  NOT NULL COMMENT 'Damper Load #1',
	`damper_load2` VARCHAR(255)  NOT NULL COMMENT 'Damper Load #2',
	`damper_displacement` VARCHAR(255)  NOT NULL COMMENT 'Damper Displacement',
	`damper_velocity` VARCHAR(255)  NOT NULL COMMENT 'Damper Velocity',
	`vertical_link_front_right_validity` TINYINT  NOT NULL COMMENT 'Vertical Link FR Validity',
	`vertical_link_rear_left_validity` TINYINT  NOT NULL COMMENT 'Vertical Link RL Validity',
	`vertical_link_rear_right_validity` TINYINT  NOT NULL COMMENT 'Vertical Link RR Validity',
	`vertical_link_front_left_validity` TINYINT  NOT NULL COMMENT 'Vertical Link FL Validity',
	`lateral_link_front_right_validity` TINYINT  NOT NULL COMMENT 'Lateral Link FR Validity',
	`lateral_link_rear_left_validity` TINYINT  NOT NULL COMMENT 'Lateral Link RL Validity',
	`lateral_link_rear_right_validity` TINYINT  NOT NULL COMMENT 'Lateral Link RR Validity',
	`lateral_link_front_left_validity` TINYINT  NOT NULL COMMENT 'Lateral Link FL Validity',
	`damper_load1_validity` VARCHAR(255)  NOT NULL COMMENT 'Damper Load #1 Validity',
	`damper_load2_validity` VARCHAR(255)  NOT NULL COMMENT 'Damper Load #2 Validity',
	`damper_status` VARCHAR(255)  NOT NULL COMMENT 'Damper Displacement and Velocity Sensor Status',
	`gate1_position` VARCHAR(255)  NOT NULL COMMENT 'Cradle clamping load #1',
	`gate2_position` VARCHAR(255)  NOT NULL COMMENT 'Cradle clamping load #2',
	`clamping_gate_position` VARCHAR(255)  NOT NULL COMMENT 'Clamping gate position',
	`clamping_gate_pressure` VARCHAR(255)  NOT NULL COMMENT 'Clamping gate pressure',
	`aircraft_type` VARCHAR(255)  NOT NULL COMMENT 'A/C type',
	`mission_id` INTEGER  NOT NULL COMMENT 'Mission ID',
	`aircraft_tail_number` VARCHAR(255)  NOT NULL COMMENT 'A/C Tail No.',
	`wheel_angle_feedback_front_right` FLOAT  NOT NULL COMMENT 'WM Angle FR',
	`wheel_angle_feedback_front_left` FLOAT  NOT NULL COMMENT 'WM Angle FL',
	`wheel_angle_feedback_rear_right` FLOAT  NOT NULL COMMENT 'WM Angle RR',
	`wheel_angle_feedback_rear_left` FLOAT  NOT NULL COMMENT 'WM Angle RL',
	`wheel_angle_feedback_front_right_validity` TINYINT  NOT NULL COMMENT 'WM Angle FR Validity',
	`wheel_angle_feedback_front_left_validity` TINYINT  NOT NULL COMMENT 'WM Angle FL Validity',
	`wheel_angle_feedback_rear_right_validity` TINYINT  NOT NULL COMMENT 'WM Angle RR Validity',
	`wheel_angle_feedback_rear_left_validity` TINYINT  NOT NULL COMMENT 'WM Angle RL Validity',
	`pilot_command_angle` FLOAT  NOT NULL COMMENT 'Pilot command angle',
	`pilot_command_angle_validity` TINYINT  NOT NULL COMMENT 'Pilot command angle validity',
	`driving_mode` TINYINT  NOT NULL COMMENT 'Driving Mode - true: DCM, false:PCM',
	`actual_wheel_speed` FLOAT  NOT NULL COMMENT 'Actual Wheel Speed (LLC)',
	`desired_speed` FLOAT  NOT NULL COMMENT 'Desired Speed (HLC)',
	`actual_wheel_speed_validity` TINYINT  NOT NULL COMMENT 'Actual Wheel Speed Validity',
	`nlg_steering_angle` FLOAT  NOT NULL COMMENT 'NLG Steering Angle (HLC)',
	`nlg_steering_angle_validity` TINYINT  NOT NULL COMMENT 'NLG Steering Angle Validity',
	`turret_angle` FLOAT  NOT NULL COMMENT 'Turret Angle',
	`turret_angle_validity` TINYINT  NOT NULL COMMENT 'Turret Angle Validity',
	`nlg_logitudal_force` FLOAT  NOT NULL COMMENT 'NLG longitudinal force (HLC) - THE CRITICAL FIELD !!!',
	`nlg_logitudal_force_validity` VARCHAR(255)  NOT NULL COMMENT 'NLG longitudinal force Validity (HLC)',
	`traction_demand` FLOAT  NOT NULL COMMENT 'Traction Demand',
	`pilot_break_detection_unfiltered` TINYINT  NOT NULL COMMENT 'Pilot-Break Detection (Unfiltered)',
	`pilot_break_detection_filtered` TINYINT  NOT NULL COMMENT 'Pilot-Break Detection (Filtered)',
	`pilot_break_estimation` FLOAT  NOT NULL COMMENT 'Pilot-Break Estimation',
	`is_exceeding` TINYINT  NOT NULL COMMENT 'nlg longitudal force exceeds permited value',
	PRIMARY KEY (`id`),
	INDEX `taxibot_stack_FI_1` (`aircraft_type`),
	CONSTRAINT `taxibot_stack_FK_1`
		FOREIGN KEY (`aircraft_type`)
		REFERENCES `aircraft_type` (`name`),
	INDEX `taxibot_stack_FI_2` (`mission_id`),
	CONSTRAINT `taxibot_stack_FK_2`
		FOREIGN KEY (`mission_id`)
		REFERENCES `taxibot_mission` (`mission_id`),
	INDEX `taxibot_stack_FI_3` (`aircraft_tail_number`),
	CONSTRAINT `taxibot_stack_FK_3`
		FOREIGN KEY (`aircraft_tail_number`)
		REFERENCES `aircraft` (`tail_number`)
)Engine=InnoDB COMMENT='TaxibotStack';

#-----------------------------------------------------------------------------
#-- taxibot_trail
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `taxibot_trail`;


CREATE TABLE `taxibot_trail`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`latitude` VARCHAR(20)  NOT NULL COMMENT 'Latitude (Inertial Sys)',
	`longitude` VARCHAR(20)  NOT NULL COMMENT 'Longitude (Inertial Sys)',
	`time` DATETIME  NOT NULL,
	`mission_id` INTEGER  NOT NULL COMMENT 'Mission ID',
	PRIMARY KEY (`id`),
	INDEX `taxibot_trail_FI_1` (`mission_id`),
	CONSTRAINT `taxibot_trail_FK_1`
		FOREIGN KEY (`mission_id`)
		REFERENCES `taxibot_mission` (`id`)
)Engine=InnoDB COMMENT='TaxibotTrail';

#-----------------------------------------------------------------------------
#-- taxibot_mission
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `taxibot_mission`;


CREATE TABLE `taxibot_mission`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`mission_id` INTEGER  NOT NULL,
	`mission_type` VARCHAR(255)  NOT NULL COMMENT 'Mission Type',
	`aircraft_tail_number` VARCHAR(255)  NOT NULL COMMENT 'Tail Number',
	`aircraft_type` VARCHAR(255)  NOT NULL COMMENT 'Aircraft Type',
	`start_time` DATETIME  NOT NULL,
	`end_time` DATETIME  NOT NULL,
	`flight_number` VARCHAR(255)  NOT NULL COMMENT 'Flight Number',
	`aircraft_weight` FLOAT  NOT NULL COMMENT 'A/C weight',
	`aircraft_cg` FLOAT  NOT NULL COMMENT 'A/C C.G.',
	`tractor_id` INTEGER  NOT NULL COMMENT 'Foreign key to the tractor-table.',
	`driver_name` VARCHAR(255)  NOT NULL COMMENT 'Flight Number',
	`cellulr_ip` VARCHAR(255)  NOT NULL COMMENT 'Cellular IP Address -  a.b.c.d (reference to Tractor ID)',
	`pcm_start` DATETIME  NOT NULL,
	`pcm_end` DATETIME  NOT NULL,
	`dcm_start` DATETIME  NOT NULL,
	`dcm_end` DATETIME  NOT NULL,
	`pushback_start` DATETIME  NOT NULL,
	`pushback_end` DATETIME  NOT NULL,
	`left_engine_fuel_dcm` FLOAT  NOT NULL,
	`right_engine_fuel_dcm` FLOAT  NOT NULL,
	`left_engine_fuel_pcm` FLOAT  NOT NULL,
	`right_engine_fuel_pcm` FLOAT  NOT NULL,
	`left_engine_fuel_pushback` FLOAT  NOT NULL,
	`right_engine_fuel_pushback` FLOAT  NOT NULL,
	`left_engine_fuel_maint` FLOAT  NOT NULL,
	`right_engine_fuel_maint` FLOAT  NOT NULL,
	`left_engine_hours_pcm` FLOAT  NOT NULL,
	`right_engine_hours_pcm` FLOAT  NOT NULL,
	`left_engine_hours_dcm` FLOAT  NOT NULL,
	`right_engine_hours_dcm` FLOAT  NOT NULL,
	`left_engine_hours_maint` FLOAT  NOT NULL,
	`right_engine_hours_maint` FLOAT  NOT NULL,
	`blf_name` VARCHAR(255),
	`join_after_mission_id` INTEGER,
	`operational_scenario` INTEGER,
	PRIMARY KEY (`id`),
	INDEX `I_referenced_taxibot_vector_FK_3_1` (`mission_id`),
	INDEX `taxibot_mission_FI_1` (`tractor_id`),
	CONSTRAINT `taxibot_mission_FK_1`
		FOREIGN KEY (`tractor_id`)
		REFERENCES `taxibot_tractor` (`tractor_id`)
)Engine=InnoDB COMMENT='TaxibotMission';

#-----------------------------------------------------------------------------
#-- taxibot_exceed_event
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `taxibot_exceed_event`;


CREATE TABLE `taxibot_exceed_event`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`exceed_type` VARCHAR(255)  NOT NULL COMMENT 'Event Type',
	`start_time` DATETIME  NOT NULL COMMENT 'Event Start Time',
	`end_time` DATETIME  NOT NULL COMMENT 'Event End Time',
	`duration` TIME COMMENT 'Event Duration',
	`mission_id` INTEGER  NOT NULL COMMENT 'Mission ID',
	`latitude` VARCHAR(20)  NOT NULL COMMENT 'Latitude (Inertial Sys)',
	`longitude` VARCHAR(20)  NOT NULL COMMENT 'Longitude (Inertial Sys)',
	PRIMARY KEY (`id`),
	INDEX `taxibot_exceed_event_FI_1` (`mission_id`),
	CONSTRAINT `taxibot_exceed_event_FK_1`
		FOREIGN KEY (`mission_id`)
		REFERENCES `taxibot_mission` (`id`)
)Engine=InnoDB COMMENT='TaxibotExceedEvent';

#-----------------------------------------------------------------------------
#-- aircraft
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `aircraft`;


CREATE TABLE `aircraft`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`tail_number` VARCHAR(255)  NOT NULL COMMENT 'Tail Number',
	`type` VARCHAR(255)  NOT NULL COMMENT 'Aircraft Type',
	PRIMARY KEY (`id`),
	INDEX `I_referenced_taxibot_vector_FK_4_1` (`tail_number`),
	INDEX `aircraft_FI_1` (`type`),
	CONSTRAINT `aircraft_FK_1`
		FOREIGN KEY (`type`)
		REFERENCES `aircraft_type` (`name`)
)Engine=InnoDB COMMENT='Aircraft';

#-----------------------------------------------------------------------------
#-- aircraft_type
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `aircraft_type`;


CREATE TABLE `aircraft_type`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(255)  NOT NULL COMMENT 'Name',
	`hlc_id` INTEGER  NOT NULL,
	`long_fatigue_limit_value` FLOAT  NOT NULL,
	`long_static_limit_value` FLOAT  NOT NULL COMMENT 'longitudal static limit (kn)',
	`lat_static_limit_value` FLOAT  NOT NULL COMMENT 'lateral static limit (kn)',
	PRIMARY KEY (`id`),
	INDEX `I_referenced_taxibot_vector_FK_2_1` (`name`)
)Engine=InnoDB COMMENT='AircraftType';

#-----------------------------------------------------------------------------
#-- taxibot_failure
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `taxibot_failure`;


CREATE TABLE `taxibot_failure`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(255)  NOT NULL COMMENT 'Name',
	`dates` VARCHAR(255)  NOT NULL,
	`taxibot_number` INTEGER  NOT NULL,
	`failure_family` VARCHAR(255)  NOT NULL,
	`mode_of_operation` VARCHAR(255)  NOT NULL,
	`mission` INTEGER  NOT NULL,
	PRIMARY KEY (`id`),
	INDEX `taxibot_failure_FI_1` (`mission`),
	CONSTRAINT `taxibot_failure_FK_1`
		FOREIGN KEY (`mission`)
		REFERENCES `taxibot_mission` (`id`)
)Engine=InnoDB COMMENT='TaxibotFailure';

#-----------------------------------------------------------------------------
#-- towing_activity
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `towing_activity`;


CREATE TABLE `towing_activity`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`order_id` VARCHAR(255) COMMENT 'The RTC order ID from the towing. With timestamp the virtual primary key',
	`timestamp` DATETIME COMMENT 'Set from the Client. With order ID the virtual primary key',
	`tractor_id` INTEGER,
	`driver_id` VARCHAR(255) COMMENT 'ID of the driver',
	`engine_temperature` INTEGER,
	`tire_pressure` INTEGER,
	PRIMARY KEY (`id`),
	INDEX `towing_activity_FI_1` (`tractor_id`),
	CONSTRAINT `towing_activity_FK_1`
		FOREIGN KEY (`tractor_id`)
		REFERENCES `taxibot_tractor` (`tractor_id`)
)Engine=InnoDB COMMENT='Table for a client to read or write data.';

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
