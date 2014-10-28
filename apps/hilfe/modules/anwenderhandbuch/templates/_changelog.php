<?php
$inhalts_array = array (
		"2012-03-12" => "Inititiale Erstellung" 
);
?>

<?php $i=0; ?>
<table class="normal">
	<thead>
		<tr>
			<th>Datum</th>
			<th>Änderung</th>
		</tr>
	</thead>
	<?php
	
foreach ( $inhalts_array as $datum => $inhalt ) {
		$zeilentyp = (($i % 2) == 0) ? "gerade" : "ungerade";
		echo '<tr class="' . $zeilentyp . ' clickable_highlighting">';
		echo "<td>" . $datum . "</td>";
		echo "<td>" . $inhalt . "</td>";
		echo "</tr>";
		$i ++;
	}
	?>
	<tfoot>
	</tfoot>
</table>
