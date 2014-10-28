<h1>TaxibotMissions List</h1>

<table border>
  <thead>
    <tr>
      <th>Id</th>
      <th>Mission</th>
      <th>Mission type</th>
      <th>Aircraft tail number</th>
      <th>Aircraft type</th>
      <th>Start time</th>
      <th>End time</th>
      <th>Flight number</th>
      <th>Aircraft weight</th>
      <th>Aircraft cg</th>
      <th>Tractor</th>
      <th>Driver name</th>
      <th>Cellulr ip</th>
      <th>Dcm start</th>
      <th>Pushback start</th>
      <th>Pushback end</th>
      <th>Pcm start</th>
      <th>Pcm end</th>      
      <th>Dcm end</th>
      <th>Left engine fuel dcm</th>
      <th>Right engine fuel dcm</th>
      <th>Left engine fuel pcm</th>
      <th>Right engine fuel pcm</th>
      <th>Left engine fuel pushback</th>
      <th>Right engine fuel pushback</th>
      <th>Left engine fuel maint</th>
      <th>Right engine fuel maint</th>
      <th>Left engine hours pcm</th>
      <th>Right engine hours pcm</th>
      <th>Left engine hours dcm</th>
      <th>Right engine hours dcm</th>
      <th>Left engine hours maint</th>
      <th>Right engine hours maint</th>
      <th>Blf name</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($TaxibotMissions as $TaxibotMission): ?>
    <tr>
      <td><a href="<?php echo url_for('mission_list/show?id='.$TaxibotMission->getId()) ?>"><?php echo $TaxibotMission->getId() ?></a></td>
      <td><?php echo $TaxibotMission->getMissionId() ?></td>
      <td><?php echo $TaxibotMission->getMissionType() ?></td>
      <td><?php echo $TaxibotMission->getAircraftTailNumber() ?></td>
      <td><?php echo $TaxibotMission->getAircraftType() ?></td>
      <td><?php echo $TaxibotMission->getStartTime() ?></td>
      <td><?php echo $TaxibotMission->getEndTime() ?></td>
      <td><?php echo $TaxibotMission->getFlightNumber() ?></td>
      <td><?php echo $TaxibotMission->getAircraftWeight() ?></td>
      <td><?php echo $TaxibotMission->getAircraftCg() ?></td>
      <td><?php echo $TaxibotMission->getTractorId() ?></td>
      <td><?php echo $TaxibotMission->getDriverName() ?></td>
      <td><?php echo $TaxibotMission->getCellulrIp() ?></td>
      <td><?php echo $TaxibotMission->getDcmStart() ?></td>
      <td><?php echo $TaxibotMission->getPushbackStart() ?></td>
      <td><?php echo $TaxibotMission->getPushbackEnd() ?></td>      
      <td><?php echo $TaxibotMission->getPcmStart() ?></td>
      <td><?php echo $TaxibotMission->getPcmEnd() ?></td>      
      <td><?php echo $TaxibotMission->getDcmEnd() ?></td>
      <td><?php echo $TaxibotMission->getLeftEngineFuelDcm() ?></td>
      <td><?php echo $TaxibotMission->getRightEngineFuelDcm() ?></td>
      <td><?php echo $TaxibotMission->getLeftEngineFuelPcm() ?></td>
      <td><?php echo $TaxibotMission->getRightEngineFuelPcm() ?></td>
      <td><?php echo $TaxibotMission->getLeftEngineFuelPushback() ?></td>
      <td><?php echo $TaxibotMission->getRightEngineFuelPushback() ?></td>
      <td><?php echo $TaxibotMission->getLeftEngineFuelMaint() ?></td>
      <td><?php echo $TaxibotMission->getRightEngineFuelMaint() ?></td>
      <td><?php echo $TaxibotMission->getLeftEngineHoursPcm() ?></td>
      <td><?php echo $TaxibotMission->getRightEngineHoursPcm() ?></td>
      <td><?php echo $TaxibotMission->getLeftEngineHoursDcm() ?></td>
      <td><?php echo $TaxibotMission->getRightEngineHoursDcm() ?></td>
      <td><?php echo $TaxibotMission->getLeftEngineHoursMaint() ?></td>
      <td><?php echo $TaxibotMission->getRightEngineHoursMaint() ?></td>
      <td><?php echo $TaxibotMission->getBlfName() ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

  <a href="<?php echo url_for('mission_list/new') ?>">New</a>