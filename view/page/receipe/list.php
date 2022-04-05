<div class="container">

	<h2>Liste des recettes</h2>
	<div class="row">
		<table class=" table table-striped">
		<tr>
			<th>Titre</th>
			<th>Catégorie</th>
			<th></th>
		</tr>
		<?php
		    // Affichage de chaque recette
			foreach ($receipes as $receipe) {
				echo '<tr>';
				echo '<td>' . htmlspecialchars($receipe['recName']) . '</td>';
				echo '<td>' . htmlspecialchars($receipe['recCategory']) . '</td>';
				echo '<td><a href="index.php?controller=receipe&action=detail&id=' . htmlspecialchars($receipe['idReceipe']) .'"><span class="glyphicon glyphicon-zoom-in" aria-hidden="true"></span></a></td>';
				echo '</tr>';
			}
		?>
		</table>
	</div>
</div>