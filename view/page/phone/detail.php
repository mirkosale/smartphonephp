<div class="container">

	<?php echo '<br><h3>' . $phone[0]['smaFullName'] . '</h3>'; ?>
	<div class="row">
		<?php
			echo '<p>Constructeur : '  . $phone[0]['smaBrand'] . '</p>';
			echo '<p>Date de sortie : '  . $phone[0]['smaReleaseDate'] . '</p>';
			echo "<p>OS : " . $os[0]['osName'];
			echo '<p>Taille de l\'écran : '  . $phone[0]['smaDisplaySize'] . ' pouces</p>';
			echo '<p>Nombre de coeurs du processeur : '  . $phone[0]['smaCPUCores'] . '</p>';
			echo '<p>Vitesse du processeur : '  . $phone[0]['smaCPUClockSpeed'] . ' MHz</p>';
			echo '<p>Constructeur : '  . $phone[0]['smaBrand'] . '</p>';
			echo '<p>Quantité de RAM : '  . $phone[0]['smaRAM'] . ' GB</p>';
			echo '<p>Quantité de stockage : '  . $phone[0]['smaStorage'] . ' GB</p>';
			echo '<p>Quantité de batterie : '  . $phone[0]['smaBatteryCapacity'] . ' mAh</p>';
			echo '<p>Durée de la batterie (benchmark) : '  . $phone[0]['smaLastedTime'] . ' </p>';

			echo '<h3>Evolution des prix </h3>';

			foreach ($prices as $price)
			{
				echo '<p>' . $price['priDate'] . ' : ' . $price['priAmount'] . '</p>'; 
			}
		?>

		<a href="index.php?controller=phone&action=list">Retour à la page de liste</a>
	</div>
</div>