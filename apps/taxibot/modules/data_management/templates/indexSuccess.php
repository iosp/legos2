<style>
.cub {
	padding: 3px;
	float: left;
	background: gainsboro;
	width: 300px;
	height: 375px;
	margin: 0 40px;
	width: 300px;
}

.title-cub {
	font-size: 15px;	
	color: white;
	font-weight: bold;
	background-color: #FFBA17;
}

.content-cub {
	padding: 20px;
}

.internal-cubs {
	margin-bottom: 25px;
}

table,th,td {
	border: 1px solid black;
	border-collapse: collapse;
	padding: 3px;
}

.internal-cub-title {
	text-align: center;
	color: white;
	background: #4a4a4a;
}

.first-cell {
	background: gray;
	color: #FFBA17;
}

.rects {
	font-size: 13px;
}
</style>


<h1>Data Management</h1>
<br />

<div class="rects">

	<div id="uploadCub" class="cub">
		<div class="title-cub">Upload data from Taxibot to Legos</div>
		<div class="content-cub"></div>
	</div>

	<div id="exportCub" class="cub">
		<div class="title-cub">Export DATABASE to archive</div>
		<div class="content-cub"></div>
	</div>

	<div id="settingCub" class="cub">
		<div class="title-cub">Setting</div>
		<div class="content-cub">
			<div class="internal-cubs">
				<table style="width: 100%" border="1">
					<tr class="internal-cub-title">
						<td colspan="2">Limit Exceed Definitions</td>
					</tr>
					<tr>
						<td colspan="2">Fatigue:</td>
					</tr>					 
					<tr>
						<td class="first-cell">Long Boeing</td>
						<td><?php echo $boeing->getLongFatigueLimitValue(); ?></td>
					</tr>
					<tr>
						<td class="first-cell">Long Airbus</td>
						<td><?php echo $airbus->getLongFatigueLimitValue(); ?></td>
					</tr>
					<tr>
						<td colspan="2">Safe:</td>
					</tr>
					<tr>
						<td class="first-cell">Lat Boeing</td>
						<td><?php  echo $boeing->getLatStaticLimitValue(); ?></td>
					</tr>
					<tr>
						<td class="first-cell">Lat Airbus</td>
						<td><?php echo  $airbus->getLatStaticLimitValue(); ?></td>
					</tr>
					<tr>
						<td class="first-cell">Long Boeing</td>
						<td><?php echo  $boeing->getLongStaticLimitValue(); ?></td>
					</tr>
					<tr>
						<td class="first-cell">Long Airbus</td>
						<td><?php echo  $airbus->getLongStaticLimitValue(); ?></td>
					</tr>
				</table>
			</div>
			<div class="internal-cubs">

				<table style="width: 100%" border="1">
					<tr class="internal-cub-title">
						<td colspan="2">Versions</td>
					</tr>
					<tr>
						<td class="first-cell">AC Data</td>
						<td>XXXXXXX</td>
					</tr>
					<tr>
						<td class="first-cell">Air field data</td>
						<td>XXXXXXX</td>
					</tr>
					<tr>
						<td class="first-cell">Application</td>
						<td>1.1.2</td>
					</tr>
				</table>
			</div>
		</div>
	</div>
</div>