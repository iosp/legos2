<?php

/**
 * accumulative_data actions.
 *
 * @package    legos2
 * @subpackage accumulative_data
 * @author     Your name here
 */
class accumulative_dataActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $this->TaxibotMissions = TaxibotMissionPeer::doSelect(new Criteria());
  }

  public function executeShow(sfWebRequest $request)
  {
    $this->TaxibotMission = TaxibotMissionPeer::retrieveByPk($request->getParameter('id'));
    $this->forward404Unless($this->TaxibotMission);
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new TaxibotMissionForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new TaxibotMissionForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($TaxibotMission = TaxibotMissionPeer::retrieveByPk($request->getParameter('id')), sprintf('Object TaxibotMission does not exist (%s).', $request->getParameter('id')));
    $this->form = new TaxibotMissionForm($TaxibotMission);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($TaxibotMission = TaxibotMissionPeer::retrieveByPk($request->getParameter('id')), sprintf('Object TaxibotMission does not exist (%s).', $request->getParameter('id')));
    $this->form = new TaxibotMissionForm($TaxibotMission);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($TaxibotMission = TaxibotMissionPeer::retrieveByPk($request->getParameter('id')), sprintf('Object TaxibotMission does not exist (%s).', $request->getParameter('id')));
    $TaxibotMission->delete();

    $this->redirect('accumulative_data/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $TaxibotMission = $form->save();

      $this->redirect('accumulative_data/edit?id='.$TaxibotMission->getId());
    }
  }
}
