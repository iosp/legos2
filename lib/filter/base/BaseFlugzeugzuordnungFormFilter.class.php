<?php

/**
 * Flugzeugzuordnung filter form base class.
 *
 * @package    legos2
 * @subpackage filter
 * @author     Your name here
 */
abstract class BaseFlugzeugzuordnungFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'flugzeugregistrierung' => new sfWidgetFormFilterInput(),
      'airline_id'            => new sfWidgetFormFilterInput(),
      'flugzeugtyp_id'        => new sfWidgetFormFilterInput(),
      'von'                   => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
    ));

    $this->setValidators(array(
      'flugzeugregistrierung' => new sfValidatorPass(array('required' => false)),
      'airline_id'            => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'flugzeugtyp_id'        => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'von'                   => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
    ));

    $this->widgetSchema->setNameFormat('flugzeugzuordnung_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Flugzeugzuordnung';
  }

  public function getFields()
  {
    return array(
      'id'                    => 'Number',
      'flugzeugregistrierung' => 'Text',
      'airline_id'            => 'Number',
      'flugzeugtyp_id'        => 'Number',
      'von'                   => 'Date',
    );
  }
}
