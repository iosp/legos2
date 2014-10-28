<?php

/**
 * Hilfe filter form base class.
 *
 * @package    legos2
 * @subpackage filter
 * @author     Your name here
 */
abstract class BaseHilfeFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'seite'  => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'titel'  => new sfWidgetFormFilterInput(),
      'inhalt' => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'seite'  => new sfValidatorPass(array('required' => false)),
      'titel'  => new sfValidatorPass(array('required' => false)),
      'inhalt' => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('hilfe_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Hilfe';
  }

  public function getFields()
  {
    return array(
      'id'     => 'Number',
      'seite'  => 'Text',
      'titel'  => 'Text',
      'inhalt' => 'Text',
    );
  }
}
