<h1>Cancel Flights</h1>

<table border="1">
  <thead>
    <tr>
      <th>Cancel Time</th>
      <th>Cancel Data</th>           
    </tr>
  </thead>
  <tbody>
    <?php foreach ($cancels as $cancel): ?>
    <tr>      
      <td><?php echo $cancel->getTime() ?></td>     
      <td><?php echo $cancel->getAlert() ?></td>      
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

