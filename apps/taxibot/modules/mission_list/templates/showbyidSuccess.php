<table>
  <tbody>
    <tr>
      <th>Id:</th>
      <td><?php echo $TaxibotMission->getId() ?></td>
    </tr>
    <tr>
      <th>Mission:</th>
      <td><?php echo $TaxibotMission->getMissionId() ?></td>
    </tr>
    <tr>
      <th>Mission type:</th>
      <td><?php echo $TaxibotMission->getMissionType() ?></td>
    </tr>
    <tr>
      <th>Aircraft tail number:</th>
      <td><?php echo $TaxibotMission->getAircraftTailNumber() ?></td>
    </tr>
    <tr>
      <th>Aircraft type:</th>
      <td><?php echo $TaxibotMission->getAircraftType() ?></td>
    </tr>
    <tr>
      <th>Start time:</th>
      <td><?php echo $TaxibotMission->getStartTime() ?></td>
    </tr>
    <tr>
      <th>End time:</th>
      <td><?php echo $TaxibotMission->getEndTime() ?></td>
    </tr>
    <tr>
      <th>Flight number:</th>
      <td><?php echo $TaxibotMission->getFlightNumber() ?></td>
    </tr>
    <tr>
      <th>Aircraft weight:</th>
      <td><?php echo $TaxibotMission->getAircraftWeight() ?></td>
    </tr>
    <tr>
      <th>Aircraft cg:</th>
      <td><?php echo $TaxibotMission->getAircraftCg() ?></td>
    </tr>
    <tr>
      <th>Tractor:</th>
      <td><?php echo $TaxibotMission->getTractorId() ?></td>
    </tr>
    <tr>
      <th>Driver name:</th>
      <td><?php echo $TaxibotMission->getDriverName() ?></td>
    </tr>
    <tr>
      <th>Cellulr ip:</th>
      <td><?php echo $TaxibotMission->getCellulrIp() ?></td>
    </tr>
    <tr>
      <th>Pcm start:</th>
      <td><?php echo $TaxibotMission->getPcmStart() ?></td>
    </tr>
    <tr>
      <th>Pcm end:</th>
      <td><?php echo $TaxibotMission->getPcmEnd() ?></td>
    </tr>
    <tr>
      <th>Dcm start:</th>
      <td><?php echo $TaxibotMission->getDcmStart() ?></td>
    </tr>
    <tr>
      <th>Dcm end:</th>
      <td><?php echo $TaxibotMission->getDcmEnd() ?></td>
    </tr>
    <tr>
      <th>Pushback start:</th>
      <td><?php echo $TaxibotMission->getPushbackStart() ?></td>
    </tr>
    <tr>
      <th>Pushback end:</th>
      <td><?php echo $TaxibotMission->getPushbackEnd() ?></td>
    </tr>
    <tr>
      <th>Left engine fuel dcm:</th>
      <td><?php echo $TaxibotMission->getLeftEngineFuelDcm() ?></td>
    </tr>
    <tr>
      <th>Right engine fuel dcm:</th>
      <td><?php echo $TaxibotMission->getRightEngineFuelDcm() ?></td>
    </tr>
    <tr>
      <th>Left engine fuel pcm:</th>
      <td><?php echo $TaxibotMission->getLeftEngineFuelPcm() ?></td>
    </tr>
    <tr>
      <th>Right engine fuel pcm:</th>
      <td><?php echo $TaxibotMission->getRightEngineFuelPcm() ?></td>
    </tr>
    <tr>
      <th>Left engine fuel pushback:</th>
      <td><?php echo $TaxibotMission->getLeftEngineFuelPushback() ?></td>
    </tr>
    <tr>
      <th>Right engine fuel pushback:</th>
      <td><?php echo $TaxibotMission->getRightEngineFuelPushback() ?></td>
    </tr>
    <tr>
      <th>Left engine fuel maint:</th>
      <td><?php echo $TaxibotMission->getLeftEngineFuelMaint() ?></td>
    </tr>
    <tr>
      <th>Right engine fuel maint:</th>
      <td><?php echo $TaxibotMission->getRightEngineFuelMaint() ?></td>
    </tr>
    <tr>
      <th>Left engine hours pcm:</th>
      <td><?php echo $TaxibotMission->getLeftEngineHoursPcm() ?></td>
    </tr>
    <tr>
      <th>Right engine hours pcm:</th>
      <td><?php echo $TaxibotMission->getRightEngineHoursPcm() ?></td>
    </tr>
    <tr>
      <th>Left engine hours dcm:</th>
      <td><?php echo $TaxibotMission->getLeftEngineHoursDcm() ?></td>
    </tr>
    <tr>
      <th>Right engine hours dcm:</th>
      <td><?php echo $TaxibotMission->getRightEngineHoursDcm() ?></td>
    </tr>
    <tr>
      <th>Left engine hours maint:</th>
      <td><?php echo $TaxibotMission->getLeftEngineHoursMaint() ?></td>
    </tr>
    <tr>
      <th>Right engine hours maint:</th>
      <td><?php echo $TaxibotMission->getRightEngineHoursMaint() ?></td>
    </tr>
    <tr>
      <th>Blf name:</th>
      <td><?php echo $TaxibotMission->getBlfName() ?></td>
    </tr>
  </tbody>
</table>

<hr />

<a href="<?php echo url_for('mission_list/edit?id='.$TaxibotMission->getId()) ?>">Edit</a>
&nbsp;
<a href="<?php echo url_for('mission_list/index') ?>">List</a>
