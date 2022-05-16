<div class="container">

	<?php echo '<br><h3>' . $phone[0]['smaFullName'] . '</h3>'; ?>
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
			foreach ($phone as $phone) {
				echo '<tr>';
				echo '<td>' . htmlspecialchars($phone['smaBrand']) . '</td>';
				echo '<td><a href="index.php?controller=phone&action=detail&id=' . htmlspecialchars($phone['idSmartphone']) .'"><span class="glyphicon glyphicon-zoom-in" aria-hidden="true">Détail</span></a></td>';
				echo '</tr>';
			}
		?>
		</table>
	</div>
</div>