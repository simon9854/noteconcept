<?php
echo "<nav id='menuUsers'>
			<ul id='ulUsers'>
				<li class='listeU'><a href='profil.php?m=".$_SESSION ['id']."&amp;action=consulter'>Mon profil</a></li>
				<li class='listeU'><a href='profil.php?m=".$_SESSION ['id']."&amp;action=modif'>Modifier le profil</a></li>
				<li class='listeU'><a href=''>Calendrier</a></li>
				<li class='listeU'><a href=''>Mes groupe privée</a></li>
				<li class='listeU'><a href=''>Mes Documents</a></li>
			</ul>		
		</nav>"
?>