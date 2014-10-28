<?php

/**
 * Benutzer form base class.
 *
 * @method Benutzer getObject() Returns the current form's model object
 *
 * @package    legos2
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseBenutzerForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                   => new sfWidgetFormInputHidden(),
      'login'                => new sfWidgetFormInputText(),
      'passwort'             => new sfWidgetFormInputText(),
      'salt_string'          => new sfWidgetFormInputText(),
      'passwort_salted'      => new sfWidgetFormInputText(),
      'name'                 => new sfWidgetFormInputText(),
      'beschreibung'         => new sfWidgetFormInputText(),
      'last_login'           => new sfWidgetFormInputText(),
      'login_count'          => new sfWidgetFormInputText(),
      'benutzer_gruppe_list' => new sfWidgetFormPropelChoice(array('multiple' => true, 'model' => 'Gruppe')),
      'benutzer_modul_list'  => new sfWidgetFormPropelChoice(array('multiple' => true, 'model' => 'Modul')),
    ));

    $this->setValidators(array(
      'id'                   => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'login'                => new sfValidatorString(array('max_length' => 255)),
      'passwort'             => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'salt_string'          => new sfValidatorString(array('max_length' => 275, 'required' => false)),
      'passwort_salted'      => new sfValidatorString(array('max_length' => 64, 'required' => false)),
      'name'                 => new sfValidatorString(array('max_length' => 255)),
      'beschreibung'         => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'last_login'           => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'login_count'          => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'benutzer_gruppe_list' => new sfValidatorPropelChoice(array('multiple' => true, 'model' => 'Gruppe', 'required' => false)),
      'benutzer_modul_list'  => new sfValidatorPropelChoice(array('multiple' => true, 'model' => 'Modul', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('benutzer[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Benutzer';
  }


  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['benutzer_gruppe_list']))
    {
      $values = array();
      foreach ($this->object->getBenutzer_Gruppes() as $obj)
      {
        $values[] = $obj->getGruppeId();
      }

      $this->setDefault('benutzer_gruppe_list', $values);
    }

    if (isset($this->widgetSchema['benutzer_modul_list']))
    {
      $values = array();
      foreach ($this->object->getBenutzer_Moduls() as $obj)
      {
        $values[] = $obj->getModulId();
      }

      $this->setDefault('benutzer_modul_list', $values);
    }

  }

  protected function doSave($con = null)
  {
    parent::doSave($con);

    $this->saveBenutzer_GruppeList($con);
    $this->saveBenutzer_ModulList($con);
  }

  public function saveBenutzer_GruppeList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['benutzer_gruppe_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $c = new Criteria();
    $c->add(Benutzer_GruppePeer::BENUTZER_ID, $this->object->getPrimaryKey());
    Benutzer_GruppePeer::doDelete($c, $con);

    $values = $this->getValue('benutzer_gruppe_list');
    if (is_array($values))
    {
      foreach ($values as $value)
      {
        $obj = new Benutzer_Gruppe();
        $obj->setBenutzerId($this->object->getPrimaryKey());
        $obj->setGruppeId($value);
        $obj->save();
      }
    }
  }

  public function saveBenutzer_ModulList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['benutzer_modul_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $c = new Criteria();
    $c->add(Benutzer_ModulPeer::BENUTZER_ID, $this->object->getPrimaryKey());
    Benutzer_ModulPeer::doDelete($c, $con);

    $values = $this->getValue('benutzer_modul_list');
    if (is_array($values))
    {
      foreach ($values as $value)
      {
        $obj = new Benutzer_Modul();
        $obj->setBenutzerId($this->object->getPrimaryKey());
        $obj->setModulId($value);
        $obj->save();
      }
    }
  }

}
