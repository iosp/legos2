<?php

/**
 * TaxibotStack form base class.
 *
 * @method TaxibotStack getObject() Returns the current form's model object
 *
 * @package    legos2
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseTaxibotStackForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                                        => new sfWidgetFormInputHidden(),
      'utc_time'                                  => new sfWidgetFormDateTime(),
      'mili_sec'                                  => new sfWidgetFormInputText(),
      'utc_validity'                              => new sfWidgetFormInputCheckbox(),
      'latitude'                                  => new sfWidgetFormInputText(),
      'longitude'                                 => new sfWidgetFormInputText(),
      'position_validity'                         => new sfWidgetFormInputCheckbox(),
      'velocity_north'                            => new sfWidgetFormInputText(),
      'velocity_east'                             => new sfWidgetFormInputText(),
      'velocity_validity'                         => new sfWidgetFormInputCheckbox(),
      'acceleration_north'                        => new sfWidgetFormInputText(),
      'acceleration_east'                         => new sfWidgetFormInputText(),
      'acceleration_z'                            => new sfWidgetFormInputText(),
      'azimuth'                                   => new sfWidgetFormInputText(),
      'azimuth_validity'                          => new sfWidgetFormInputCheckbox(),
      'mfl'                                       => new sfWidgetFormInputText(),
      'vertical_link_front_right'                 => new sfWidgetFormInputText(),
      'vertical_link_rear_left'                   => new sfWidgetFormInputText(),
      'vertical_link_rear_right'                  => new sfWidgetFormInputText(),
      'vertical_link_front_left'                  => new sfWidgetFormInputText(),
      'lateral_link_front_right'                  => new sfWidgetFormInputText(),
      'lateral_link_rear_left'                    => new sfWidgetFormInputText(),
      'lateral_link_rear_right'                   => new sfWidgetFormInputText(),
      'lateral_link_front_left'                   => new sfWidgetFormInputText(),
      'damper_load1'                              => new sfWidgetFormInputText(),
      'damper_load2'                              => new sfWidgetFormInputText(),
      'damper_displacement'                       => new sfWidgetFormInputText(),
      'damper_velocity'                           => new sfWidgetFormInputText(),
      'vertical_link_front_right_validity'        => new sfWidgetFormInputCheckbox(),
      'vertical_link_rear_left_validity'          => new sfWidgetFormInputCheckbox(),
      'vertical_link_rear_right_validity'         => new sfWidgetFormInputCheckbox(),
      'vertical_link_front_left_validity'         => new sfWidgetFormInputCheckbox(),
      'lateral_link_front_right_validity'         => new sfWidgetFormInputCheckbox(),
      'lateral_link_rear_left_validity'           => new sfWidgetFormInputCheckbox(),
      'lateral_link_rear_right_validity'          => new sfWidgetFormInputCheckbox(),
      'lateral_link_front_left_validity'          => new sfWidgetFormInputCheckbox(),
      'damper_load1_validity'                     => new sfWidgetFormInputText(),
      'damper_load2_validity'                     => new sfWidgetFormInputText(),
      'damper_status'                             => new sfWidgetFormInputText(),
      'gate1_position'                            => new sfWidgetFormInputText(),
      'gate2_position'                            => new sfWidgetFormInputText(),
      'clamping_gate_position'                    => new sfWidgetFormInputText(),
      'clamping_gate_pressure'                    => new sfWidgetFormInputText(),
      'aircraft_type'                             => new sfWidgetFormPropelChoice(array('model' => 'AircraftType', 'add_empty' => false, 'key_method' => 'getName')),
      'mission_id'                                => new sfWidgetFormPropelChoice(array('model' => 'TaxibotMission', 'add_empty' => false, 'key_method' => 'getMissionId')),
      'aircraft_tail_number'                      => new sfWidgetFormPropelChoice(array('model' => 'Aircraft', 'add_empty' => false, 'key_method' => 'getTailNumber')),
      'wheel_angle_feedback_front_right'          => new sfWidgetFormInputText(),
      'wheel_angle_feedback_front_left'           => new sfWidgetFormInputText(),
      'wheel_angle_feedback_rear_right'           => new sfWidgetFormInputText(),
      'wheel_angle_feedback_rear_left'            => new sfWidgetFormInputText(),
      'wheel_angle_feedback_front_right_validity' => new sfWidgetFormInputCheckbox(),
      'wheel_angle_feedback_front_left_validity'  => new sfWidgetFormInputCheckbox(),
      'wheel_angle_feedback_rear_right_validity'  => new sfWidgetFormInputCheckbox(),
      'wheel_angle_feedback_rear_left_validity'   => new sfWidgetFormInputCheckbox(),
      'pilot_command_angle'                       => new sfWidgetFormInputText(),
      'pilot_command_angle_validity'              => new sfWidgetFormInputCheckbox(),
      'driving_mode'                              => new sfWidgetFormInputCheckbox(),
      'actual_wheel_speed'                        => new sfWidgetFormInputText(),
      'desired_speed'                             => new sfWidgetFormInputText(),
      'actual_wheel_speed_validity'               => new sfWidgetFormInputCheckbox(),
      'nlg_steering_angle'                        => new sfWidgetFormInputText(),
      'nlg_steering_angle_validity'               => new sfWidgetFormInputCheckbox(),
      'turret_angle'                              => new sfWidgetFormInputText(),
      'turret_angle_validity'                     => new sfWidgetFormInputCheckbox(),
      'nlg_logitudal_force'                       => new sfWidgetFormInputText(),
      'nlg_logitudal_force_validity'              => new sfWidgetFormInputText(),
      'traction_demand'                           => new sfWidgetFormInputText(),
      'pilot_break_detection_unfiltered'          => new sfWidgetFormInputCheckbox(),
      'pilot_break_detection_filtered'            => new sfWidgetFormInputCheckbox(),
      'pilot_break_estimation'                    => new sfWidgetFormInputText(),
      'is_exceeding'                              => new sfWidgetFormInputCheckbox(),
    ));

    $this->setValidators(array(
      'id'                                        => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'utc_time'                                  => new sfValidatorDateTime(),
      'mili_sec'                                  => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
      'utc_validity'                              => new sfValidatorBoolean(),
      'latitude'                                  => new sfValidatorNumber(),
      'longitude'                                 => new sfValidatorNumber(),
      'position_validity'                         => new sfValidatorBoolean(),
      'velocity_north'                            => new sfValidatorNumber(),
      'velocity_east'                             => new sfValidatorNumber(),
      'velocity_validity'                         => new sfValidatorBoolean(),
      'acceleration_north'                        => new sfValidatorNumber(),
      'acceleration_east'                         => new sfValidatorNumber(),
      'acceleration_z'                            => new sfValidatorNumber(),
      'azimuth'                                   => new sfValidatorNumber(),
      'azimuth_validity'                          => new sfValidatorBoolean(),
      'mfl'                                       => new sfValidatorString(array('max_length' => 255)),
      'vertical_link_front_right'                 => new sfValidatorNumber(),
      'vertical_link_rear_left'                   => new sfValidatorNumber(),
      'vertical_link_rear_right'                  => new sfValidatorNumber(),
      'vertical_link_front_left'                  => new sfValidatorNumber(),
      'lateral_link_front_right'                  => new sfValidatorNumber(),
      'lateral_link_rear_left'                    => new sfValidatorNumber(),
      'lateral_link_rear_right'                   => new sfValidatorNumber(),
      'lateral_link_front_left'                   => new sfValidatorNumber(),
      'damper_load1'                              => new sfValidatorString(array('max_length' => 255)),
      'damper_load2'                              => new sfValidatorString(array('max_length' => 255)),
      'damper_displacement'                       => new sfValidatorString(array('max_length' => 255)),
      'damper_velocity'                           => new sfValidatorString(array('max_length' => 255)),
      'vertical_link_front_right_validity'        => new sfValidatorBoolean(),
      'vertical_link_rear_left_validity'          => new sfValidatorBoolean(),
      'vertical_link_rear_right_validity'         => new sfValidatorBoolean(),
      'vertical_link_front_left_validity'         => new sfValidatorBoolean(),
      'lateral_link_front_right_validity'         => new sfValidatorBoolean(),
      'lateral_link_rear_left_validity'           => new sfValidatorBoolean(),
      'lateral_link_rear_right_validity'          => new sfValidatorBoolean(),
      'lateral_link_front_left_validity'          => new sfValidatorBoolean(),
      'damper_load1_validity'                     => new sfValidatorString(array('max_length' => 255)),
      'damper_load2_validity'                     => new sfValidatorString(array('max_length' => 255)),
      'damper_status'                             => new sfValidatorString(array('max_length' => 255)),
      'gate1_position'                            => new sfValidatorString(array('max_length' => 255)),
      'gate2_position'                            => new sfValidatorString(array('max_length' => 255)),
      'clamping_gate_position'                    => new sfValidatorString(array('max_length' => 255)),
      'clamping_gate_pressure'                    => new sfValidatorString(array('max_length' => 255)),
      'aircraft_type'                             => new sfValidatorPropelChoice(array('model' => 'AircraftType', 'column' => 'name')),
      'mission_id'                                => new sfValidatorPropelChoice(array('model' => 'TaxibotMission', 'column' => 'mission_id')),
      'aircraft_tail_number'                      => new sfValidatorPropelChoice(array('model' => 'Aircraft', 'column' => 'tail_number')),
      'wheel_angle_feedback_front_right'          => new sfValidatorNumber(),
      'wheel_angle_feedback_front_left'           => new sfValidatorNumber(),
      'wheel_angle_feedback_rear_right'           => new sfValidatorNumber(),
      'wheel_angle_feedback_rear_left'            => new sfValidatorNumber(),
      'wheel_angle_feedback_front_right_validity' => new sfValidatorBoolean(),
      'wheel_angle_feedback_front_left_validity'  => new sfValidatorBoolean(),
      'wheel_angle_feedback_rear_right_validity'  => new sfValidatorBoolean(),
      'wheel_angle_feedback_rear_left_validity'   => new sfValidatorBoolean(),
      'pilot_command_angle'                       => new sfValidatorNumber(),
      'pilot_command_angle_validity'              => new sfValidatorBoolean(),
      'driving_mode'                              => new sfValidatorBoolean(),
      'actual_wheel_speed'                        => new sfValidatorNumber(),
      'desired_speed'                             => new sfValidatorNumber(),
      'actual_wheel_speed_validity'               => new sfValidatorBoolean(),
      'nlg_steering_angle'                        => new sfValidatorNumber(),
      'nlg_steering_angle_validity'               => new sfValidatorBoolean(),
      'turret_angle'                              => new sfValidatorNumber(),
      'turret_angle_validity'                     => new sfValidatorBoolean(),
      'nlg_logitudal_force'                       => new sfValidatorNumber(),
      'nlg_logitudal_force_validity'              => new sfValidatorString(array('max_length' => 255)),
      'traction_demand'                           => new sfValidatorNumber(),
      'pilot_break_detection_unfiltered'          => new sfValidatorBoolean(),
      'pilot_break_detection_filtered'            => new sfValidatorBoolean(),
      'pilot_break_estimation'                    => new sfValidatorNumber(),
      'is_exceeding'                              => new sfValidatorBoolean(),
    ));

    $this->widgetSchema->setNameFormat('taxibot_stack[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'TaxibotStack';
  }


}
