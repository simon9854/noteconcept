<?php
//Menu de l'utilisateur
echo "<nav id='menuUsers'>
			<ul id='ulUsers'>
				<li class='listeU'><a href='profil.php?m=".$_SESSION ['id']."&amp;action=consulter'><img src='src/image-menu/user.png' alt='icone_profil' class='icone_menu_user'>Mon profil<div class='notifications'></div></a></li>
				<li class='listeU'><a href='profil.php?m=".$_SESSION ['id']."&amp;action=modif'><img src='src/image-menu/user.png' alt='icone_Modifier_profil' class='icone_menu_user'>Modifier le profil<div class='notifications'></div></a></li>
				<li class='listeU'><a href=''><img src='src/image-menu/calendar-disabled.png' alt='icone_calendrier' height='20' width='20' class='icone_menu_user'>Calendrier<div class='notification'></div></a></li>
				<li class='listeU'><a href=''><img src='src/image-menu/user.png' alt='icone_groupe_privée' class='icone_menu_user'>Groupes privées<div class='notification'>10</div></a></li>
				<li class='listeU'><a href=''><img src='src/image-menu/user.png' alt='icone_mes_documents' class='icone_menu_user'>Mes Documents<div class='notification'></div></a></li>
			</ul>		
		</nav>"
?>