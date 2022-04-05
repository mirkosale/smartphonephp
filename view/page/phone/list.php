<div class="container">

	<h2>Liste des clients</h2>
	<div class="row">
		<table class=" table table-striped">
		<tr>
			<th>Numéro</th>
			<th>Nom</th>
			<th>Prénom</th>
			<th>Téléphone</th>
			<th></th>
		</tr>
		<?php
		    // Affichage de chaque client
			foreach ($customers as $customer) {
				echo '<tr>';
				echo '<td>' . htmlspecialchars($phone['idContact']) . '</td>';
				echo '<td>' . htmlspecialchars($phone['conLastName']) . '</td>';
				echo '<td>' . htmlspecialchars($phone['conFirstName']) . '</td>';
				echo '<td>' . htmlspecialchars($phone['conPhone']) . '</td>';
				echo '<td><a href="index.php?controller=customer&action=detail&id=' . htmlspecialchars($phone['idSmartphone']) .'"><span class="glyphicon glyphicon-zoom-in" aria-hidden="true"></span></a></td>';
				echo '</tr>';
			}
		?>
		</table>
	</div>
</div>