<?php$manager = new ManagerMember($db);$lienjavascript = "./src/javascript/";if(!isset($_SESSION['id'])){	$_SESSION['id'] = -1;}	// script permettant la connection du membre	if(isset($_POST['do'])){		$_SESSION["id"] = $manager->connect($_POST['loginName'], $_POST['pass']);	}	if(isset($_POST['deconnection'])){			session_destroy();		header("location: ./index.php");	}?>
<script src="<?php echo $lienjavascript;?>jquery.js" type="text/javascript"></script>
<script src="<?php echo $lienjavascript;?>jquery.tipsy.js" type="text/javascript"></script>
<nav id="menu">
	<ul id="menu-ul">
		<li><a href='index.php'><img src='src/image-menu/network.png' width='40px' height='40px' align='left' class='img-menu'>Accueil</a></li>
		<li><a href='forum.php'><img src='src/image-menu/personnes.png' width='40px' height='40px' align='left' class='img-menu'>Forum</a></li>
		<li><a href='contact.php'><img src='src/image-menu/telephone.png' width='40px' height='40px' align='left' class='img-menu'>Contact</a></li>
		<li><a href='new.php'><img src='src/image-menu/info.png' width='40px' height='40px' align='left' class='img-menu'>+ Info</a></li>
	</ul>
	<ul id="menu-ul2">
		
		<?php if ($_SESSION ['id'] == -1){  ?>		<li><span class='text-connect'><a href='form.member.php'>Inscription</a></span></li>
		<li><a href='#' class="signin"><img src='src/image-menu/toggle_down_light.png' width='25px' height='20px' id='img_connect' align='left'><span class='text-connect'>Login 
		</span></a></li> 
		<fieldset id="signin_menu">
						<form method="post" id="signin" action="#">
							<p>							<label for="loginName"><b>Login :</b></label>
							<input id="loginName" name="loginName" value="" title="Pseudo" tabindex="4" type="text">
							</p>
							<p>
							<label for="password"><b>Mot de passe :</b></label>
							<input id="pass" name="pass" value="" title="Mot de passe" tabindex="5" type="password">
							</p>
							<p class="remember">
							<input id="signin_submit" value="Se connecter" name="do" tabindex="6" type="submit">
							<br><input id="remember" name="se souvenir" value="1" tabindex="7" type="checkbox">
							<label for="remember">se souvenir</label>
							</p>
							<p class="forgot"> <a href="#" id="resend_password_link"><b>Mot de passe oublié?</b></a> </p>
							</p>
						</form>
				  </fieldset>
				  <?php }else{					  	$perso = $manager->getId($_SESSION["id"]);				  	?>				
				<li><img src='images/interfaces/toggle_down_light.png' width='25px' height='20px' id='img_connect' align='left'><a href="index.php" class="signin"><span>Profil <span></a></li>
					  <fieldset id="signin_menu">
						<form method="post" id="signin" action="#">
						<img src='<?php echo "src/image-avatar/".$perso->avatar(); ?>' width='50px' height='50px' align='left'>
						<label for="loginName">pseudo : </label><br>
						  <a href="<?php echo'./includes/voirprofil.php?m='.$perso->id().'&amp;action=consulter';?>"><strong>profil de <?php echo $perso->pseudo();?><strong></a>
						  </p>
						  <p class="remember">
							<input id="signin_submit" value="se deconnecter" name="deconnection" tabindex="6" type="submit">
						</form>
					  </fieldset>
	<?PHP } ?>
	</ul>
</nav><?php 	if($manager->message() != ""){		echo $manager->getMessage();	}?>
<script src="javascripts/jquery.js" type="text/javascript"></script>
<script type="text/javascript">
        $(document).ready(function() {
            $(".signin").click(function(e) {          
				e.preventDefault();
                $("fieldset#signin_menu").toggle();
				$(".signin").toggleClass("menu-open");
            });
			$("fieldset#signin_menu").mouseup(function() {
				return false
			});
			$(document).mouseup(function(e) {
				if($(e.target).parent("a.signin").length==0) {
					$(".signin").removeClass("menu-open");
					$("fieldset#signin_menu").hide();
				}
			});			
        });
</script>
<script src="javascripts/jquery.tipsy.js" type="text/javascript"></script>
<script type='text/javascript'>
    $(function() {
	  $('#forgot_username_link').tipsy({gravity: 'w'});   
    });
 </script>