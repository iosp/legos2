<?php

/**
 * Benutzer filter form base class.
 *
 * @package    legos2
 * @subpackage filter
 * @author     Your name here
 */
abstract class BaseBenutzerFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'login'                => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'passwort'             => new sfWidgetFormFilterInput(),
      'salt_string'          => new sfWidgetFormFilterInput(),
      'passwort_salted'      => new sfWidgetFormFilterInput(),
      'name'                 => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'beschreibung'         => new sfWidgetFormFilterInput(),
      'last_login'           => new sfWidgetFormFilterInput(),
      'login_count'          => new sfWidgetFormFilterInput(),
      'benutzer_gruppe_list' => new sfWidgetFormPropelChoice(array('model' => 'Gruppe', 'add_empty' => true)),
      'benutzer_modul_list'  => new sfWidgetFormPropelChoice(array('model' => 'Modul', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'login'                => new sfValidatorPass(array('required' => false)),
      'passwort'             => new sfValidatorPass(array('required' => false)),
      'salt_string'          => new sfValidatorPass(array('required' => false)),
      'passwort_salted'      => new sfValidatorPass(array('required' => false)),
      'name'                 => new sfValidatorPass(array('required' => false)),
      'beschreibung'         => new sfValidatorPass(array('required' => false)),
      'last_login'           => new sfValidatorPass(array('required' => false)),
      'login_count'          => new sfValidatorPass(array('required' => false)),
      'benutzer_gruppe_list' => new sfValidatorPropelChoice(array('model' => 'Gruppe', 'required' => false)),
      'benutzer_modul_list'  => new sfValidatorPropelChoice(array('model' => 'Modul', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('benutzer_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function addBenutzer_GruppeListColumnCriteria(Criteria $criteria, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $criteria->addJoin(Benutzer_GruppePeer::BENUTZER_ID, BenutzerPeer::ID);

    $value = array_pop($values);
    $criterion = $criteria->getNewCriterion(Benutzer_GruppePeer::GRUPPE_ID, $value);

    foreach ($values as $value)
    {
      $criterion->addOr($criteria->getNewCriterion(Benutzer_GruppePeer::GRUPPE_ID, $value));
    }

    $criteria->add($criterion);
  }

  public function addBenutzer_ModulListColumnCriteria(Criteria $criteria, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $criteria->addJoin(Benutzer_ModulPeer::BENUTZER_ID, BenutzerPeer::ID);

    $value = array_pop($values);
    $criterion = $criteria->getNewCriterion(Benutzer_ModulPeer::MODUL_ID, $value);

    foreach ($values as $value)
    {
      $criterion->addOr($criteria->getNewCriterion(Benutzer_ModulPeer::MODUL_ID, $value));
    }

    $criteria->add($criterion);
  }

  public function getModelName()
  {
    return 'Benutzer';
  }

  public function getFields()
  {
    return array(
      'id'                   => 'Number',
      'login'                => 'Text',
      'passwort'             => 'Text',
      'salt_string'          => 'Text',
      'passwort_salted'      => 'Text',
      'name'                 => 'Text',
      'beschreibung'         => 'Text',
      'last_login'           => 'Text',
      'login_count'          => 'Text',
      'benutzer_gruppe_list' => 'ManyKey',
      'benutzer_modul_list'  => 'ManyKey',
    );
  }
}
