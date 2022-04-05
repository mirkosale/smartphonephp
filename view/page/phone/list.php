<div class="container">

	<h3>Liste des smartphones</h3>
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
				echo '<td>' . htmlspecialchars($phone['smaName']) . '</td>';
				echo '<td>' . htmlspecialchars($phone['smaBard']) . '</td>';
				echo '<td><a href="index.php?controller=phone&action=detail&id=' . htmlspecialchars($phone['idPhone']) .'"><span class="glyphicon glyphicon-zoom-in" aria-hidden="true"></span></a></td>';
				echo '</tr>';
			}
		?>
		</table>
	</div>
</div>