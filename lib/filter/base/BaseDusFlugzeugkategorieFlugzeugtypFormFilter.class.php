<?php

/**
 * DusFlugzeugkategorieFlugzeugtyp filter form base class.
 *
 * @package    legos2
 * @subpackage filter
 * @author     Your name here
 */
abstract class BaseDusFlugzeugkategorieFlugzeugtypFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'flugzeugtyp_id' => new sfWidgetFormFilterInput(),
      'gueltig_von'    => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'cat'            => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'flugzeugtyp_id' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'gueltig_von'    => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'cat'            => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('dus_flugzeugkategorie_flugzeugtyp_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'DusFlugzeugkategorieFlugzeugtyp';
  }

  public function getFields()
  {
    return array(
      'id'             => 'Number',
      'flugzeugtyp_id' => 'Number',
      'gueltig_von'    => 'Date',
      'cat'            => 'Number',
    );
  }
}
