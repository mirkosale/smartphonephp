<div class="container">
	<h3></br>Liste des smartphones<br></br></h3>
	<form action="index.php?controller=phone&action=orderOS" method="post">
	<select name="orderOs" id="orderOs">
		<option value="idOS">Choisir le constructeur</option>
		<?php
		foreach ($brands as $brand) {
			echo '<option value="' . $brand["smaBrand"] . '">' . $brand["smaBrand"] . '</option>';
		}
		?>
	</select>
	<button type="submit" name="btnSubmit" id="btnSubmit">
		Trier
	</button>
	</form>
	<hr>
	</hr>

	<div class="row">
		<table class=" table table-striped">
			<tr>
				<th>Nom</th>
				<th>Marque</th>
				<th>Téléphone</th>
				<th></th>
			</tr>
			<?php
			// Affichage de chaque téléphone
			foreach ($phones as $phone) {
				echo '<tr>';
				echo '<td>' . htmlspecialchars($phone['smaFullName']) . '</td>';
				echo '<td>' . htmlspecialchars($phone['smaBrand']) . '</td>';
				echo '<td><a href="index.php?controller=phone&action=detail&id=' . htmlspecialchars($phone['idSmartphone']) . '"><span class="glyphicon glyphicon-zoom-in" aria-hidden="true">Détail</span></a></td>';
				echo '</tr>';
			}
			?>
		</table>
	</div>
</div>
<br></br>