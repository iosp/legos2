<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<form action="<?php echo url_for('mission_list/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
<?php if (!$form->getObject()->isNew()): ?>
<input type="hidden" name="sf_method" value="put" />
<?php endif; ?>
  <table>
    <tfoot>
      <tr>
        <td colspan="2">
          <?php echo $form->renderHiddenFields(false) ?>
          &nbsp;<a href="<?php echo url_for('mission_list/index') ?>">Back to list</a>
          <?php if (!$form->getObject()->isNew()): ?>
            &nbsp;<?php echo link_to('Delete', 'mission_list/delete?id='.$form->getObject()->getId(), array('method' => 'delete', 'confirm' => 'Are you sure?')) ?>
          <?php endif; ?>
          <input type="submit" value="Save" />
        </td>
      </tr>
    </tfoot>
    <tbody>
      <?php echo $form->renderGlobalErrors() ?>
      <tr>
        <th><?php echo $form['mission_id']->renderLabel() ?></th>
        <td>
          <?php echo $form['mission_id']->renderError() ?>
          <?php echo $form['mission_id'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['mission_type']->renderLabel() ?></th>
        <td>
          <?php echo $form['mission_type']->renderError() ?>
          <?php echo $form['mission_type'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['aircraft_tail_number']->renderLabel() ?></th>
        <td>
          <?php echo $form['aircraft_tail_number']->renderError() ?>
          <?php echo $form['aircraft_tail_number'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['aircraft_type']->renderLabel() ?></th>
        <td>
          <?php echo $form['aircraft_type']->renderError() ?>
          <?php echo $form['aircraft_type'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['start_time']->renderLabel() ?></th>
        <td>
          <?php echo $form['start_time']->renderError() ?>
          <?php echo $form['start_time'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['end_time']->renderLabel() ?></th>
        <td>
          <?php echo $form['end_time']->renderError() ?>
          <?php echo $form['end_time'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['flight_number']->renderLabel() ?></th>
        <td>
          <?php echo $form['flight_number']->renderError() ?>
          <?php echo $form['flight_number'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['aircraft_weight']->renderLabel() ?></th>
        <td>
          <?php echo $form['aircraft_weight']->renderError() ?>
          <?php echo $form['aircraft_weight'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['aircraft_cg']->renderLabel() ?></th>
        <td>
          <?php echo $form['aircraft_cg']->renderError() ?>
          <?php echo $form['aircraft_cg'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['tractor_id']->renderLabel() ?></th>
        <td>
          <?php echo $form['tractor_id']->renderError() ?>
          <?php echo $form['tractor_id'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['driver_name']->renderLabel() ?></th>
        <td>
          <?php echo $form['driver_name']->renderError() ?>
          <?php echo $form['driver_name'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['cellulr_ip']->renderLabel() ?></th>
        <td>
          <?php echo $form['cellulr_ip']->renderError() ?>
          <?php echo $form['cellulr_ip'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['pcm_start']->renderLabel() ?></th>
        <td>
          <?php echo $form['pcm_start']->renderError() ?>
          <?php echo $form['pcm_start'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['pcm_end']->renderLabel() ?></th>
        <td>
          <?php echo $form['pcm_end']->renderError() ?>
          <?php echo $form['pcm_end'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['dcm_start']->renderLabel() ?></th>
        <td>
          <?php echo $form['dcm_start']->renderError() ?>
          <?php echo $form['dcm_start'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['dcm_end']->renderLabel() ?></th>
        <td>
          <?php echo $form['dcm_end']->renderError() ?>
          <?php echo $form['dcm_end'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['pushback_start']->renderLabel() ?></th>
        <td>
          <?php echo $form['pushback_start']->renderError() ?>
          <?php echo $form['pushback_start'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['pushback_end']->renderLabel() ?></th>
        <td>
          <?php echo $form['pushback_end']->renderError() ?>
          <?php echo $form['pushback_end'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['left_engine_fuel_dcm']->renderLabel() ?></th>
        <td>
          <?php echo $form['left_engine_fuel_dcm']->renderError() ?>
          <?php echo $form['left_engine_fuel_dcm'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['right_engine_fuel_dcm']->renderLabel() ?></th>
        <td>
          <?php echo $form['right_engine_fuel_dcm']->renderError() ?>
          <?php echo $form['right_engine_fuel_dcm'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['left_engine_fuel_pcm']->renderLabel() ?></th>
        <td>
          <?php echo $form['left_engine_fuel_pcm']->renderError() ?>
          <?php echo $form['left_engine_fuel_pcm'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['right_engine_fuel_pcm']->renderLabel() ?></th>
        <td>
          <?php echo $form['right_engine_fuel_pcm']->renderError() ?>
          <?php echo $form['right_engine_fuel_pcm'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['left_engine_fuel_pushback']->renderLabel() ?></th>
        <td>
          <?php echo $form['left_engine_fuel_pushback']->renderError() ?>
          <?php echo $form['left_engine_fuel_pushback'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['right_engine_fuel_pushback']->renderLabel() ?></th>
        <td>
          <?php echo $form['right_engine_fuel_pushback']->renderError() ?>
          <?php echo $form['right_engine_fuel_pushback'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['left_engine_fuel_maint']->renderLabel() ?></th>
        <td>
          <?php echo $form['left_engine_fuel_maint']->renderError() ?>
          <?php echo $form['left_engine_fuel_maint'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['right_engine_fuel_maint']->renderLabel() ?></th>
        <td>
          <?php echo $form['right_engine_fuel_maint']->renderError() ?>
          <?php echo $form['right_engine_fuel_maint'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['left_engine_hours_pcm']->renderLabel() ?></th>
        <td>
          <?php echo $form['left_engine_hours_pcm']->renderError() ?>
          <?php echo $form['left_engine_hours_pcm'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['right_engine_hours_pcm']->renderLabel() ?></th>
        <td>
          <?php echo $form['right_engine_hours_pcm']->renderError() ?>
          <?php echo $form['right_engine_hours_pcm'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['left_engine_hours_dcm']->renderLabel() ?></th>
        <td>
          <?php echo $form['left_engine_hours_dcm']->renderError() ?>
          <?php echo $form['left_engine_hours_dcm'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['right_engine_hours_dcm']->renderLabel() ?></th>
        <td>
          <?php echo $form['right_engine_hours_dcm']->renderError() ?>
          <?php echo $form['right_engine_hours_dcm'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['left_engine_hours_maint']->renderLabel() ?></th>
        <td>
          <?php echo $form['left_engine_hours_maint']->renderError() ?>
          <?php echo $form['left_engine_hours_maint'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['right_engine_hours_maint']->renderLabel() ?></th>
        <td>
          <?php echo $form['right_engine_hours_maint']->renderError() ?>
          <?php echo $form['right_engine_hours_maint'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['blf_name']->renderLabel() ?></th>
        <td>
          <?php echo $form['blf_name']->renderError() ?>
          <?php echo $form['blf_name'] ?>
        </td>
      </tr>
    </tbody>
  </table>
</form>
