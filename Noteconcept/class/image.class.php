<?php 

class Image{

	public $_name;
	private $_path;
	private $_type;
	private $_EXTENSION_VALIDE = array( 'jpg' , 'jpeg' , 'gif' , 'png' );
	private $_msgError = "";

	const MAXSIZE = 100024;
	const MAXWIDTH = 800;
	const MAXHEIGHT = 600;
	const IMG_DEST = 'src/image-avatar/mini.';
	const IMG_DEFAULT = 'src/image-avatar/default.png';

	public function __construct(){}
	public function __Photo($name, $type, $size, $tmp){
		//ordre important !!
		$this->setName($name);
		$this->_path = $tmp;
		$this->setSize($size);
		$this->setType($type);
		$this->setWidth();
	}
	

	public function name(){ return $this->_name;}
	public function path(){return $this->_path;}
	public function type(){return $this->_type;}
	public function error(){return $this->_msgError;}
	public function setName($name){
		$this->_name = $name;
	}
	
	public function setWidth(){
		$image_sizes = getimagesize($this->_path);
		if ($image_sizes[0] > self::MAXWIDTH OR $image_sizes[1] >self::MAXHEIGHT) {
			$this->redim(200, 200);
		}
	}
	
	public function setType($type){
	$extension_upload = strtolower(  substr(  strrchr($this->_name, '.')  ,1)  );
		if ( !in_array($extension_upload, $this->_EXTENSION_VALIDE)) {
			$this->_msgError .= "Extension incorrecte";
		}
		else{ $this->_type = $extension_upload;}
	}

	public function setSize($size){
		if ($size > self::MAXSIZE){
			$this->_msgError .= "Le fichier est trop gros";
		}
		else return $this->_size = $size;
	}
	
	public function rename($name){
		$this->_name = str_replace(' ', '', $name).".".$this->_type;		
	}

	public function move_img($destination){
		$destination = $destination.$this->_name;
		if($resultat = move_uploaded_file($this->_path, $destination)){
			$this->_path = $destination;
			return true;
		}else return false;
	}

	public function redim($W_max, $H_max){
	$condition = 0;
		if (file_exists($this->_path.$this->_name) && ($W_max!=0 || $H_max!=0)) {
		
			// recuperation des dimensions de l image Src
				$img_size = getimagesize($this->_path.$this->_name);
				$W_Src = $img_size[0]; // largeur
				$H_Src = $img_size[1]; // hauteur

			// -------------------------------------------------------------
			// condition de redimensionnement et dimensions de l image finale
			// -------------------------------------------------------------

			// A- LARGEUR ET HAUTEUR maxi fixes

			if ($W_max != 0 && $H_max != 0) {
				$ratiox = $W_Src / $W_max; // ratio en largeur
				$ratioy = $H_Src / $H_max; // ratio en hauteur
				$ratio = max($ratiox,$ratioy); // le plus grand
				$W = $W_Src/$ratio;
				$H = $H_Src/$ratio;   
				$condition = ($W_Src>$W) || ($W_Src>$H); // 1 si vrai (true)
			}      
			// -------------------------------------------------------------

			// B- HAUTEUR maxi fixe
			if ($W_max == 0 && $H_max != 0) {
				$H = $H_max;
				$W = $H * ($W_Src / $H_Src);
				$condition = $H_Src > $H_max; // 1 si vrai (true)
			}
			// -------------------------------------------------------------
			// C- LARGEUR maxi fixe
			if ($W_max != 0 && $H_max == 0) {
				$W = $W_max;
				$H = $W * ($H_Src / $W_Src);         
				$condition = $W_Src > $W_max; // 1 si vrai (true)
			}
			// -------------------------------------------------------------
			// on REDIMENSIONNE si la condition est vraie
			// -------------------------------------------------------------
			// Par defaut : 
			// Si l'image Source est plus petite que les dimensions indiquees :
			// PAS de redimensionnement.
			// Mais on peut "forcer" le redimensionnement en ajoutant ici :
			// $condition = 1;
					
			if ($condition == 1) {

			// creation de la ressource-image "Src" en fonction de l extension
				switch($extension) {
					case 'jpg':
					case 'jpeg':
						$Ress_Src = imagecreatefromjpeg($this->_path.$this->name);
						break;
					case 'png':
						$Ress_Src = imagecreatefrompng($this->_path.$this->name);
						break;
				}
				// ----------------------------------------------------------
				// creation d une ressource-image "Dst" aux dimensions finales
				// fond noir (par defaut)
					switch($extension) {
						case 'jpg':
						case 'jpeg':
							$Ress_Dst = imagecreatetruecolor($W,$H);
							break;
						case 'png':
							$Ress_Dst = imagecreatetruecolor($W,$H);
					// fond transparent (pour les png avec transparence)
							imagesavealpha($Ress_Dst, true);
							$trans_color = imagecolorallocatealpha($Ress_Dst, 0, 0, 0, 127);
							imagefill($Ress_Dst, 0, 0, $trans_color);
							break;
					}
 
				// ----------------------------------------------------------
				// REDIMENSIONNEMENT (copie, redimensionne, re-echantillonne)
				imagecopyresampled($Ress_Dst, $Ress_Src, 0, 0, 0, 0, $W, $H, $W_Src, $H_Src); 
				// ----------------------------------------------------------
				// ENREGISTREMENT dans le repertoire (avec la fonction appropriee)
				switch ($extension) { 
					case 'jpg':
					case 'jpeg':
						imagejpeg ($Ress_Dst, $rep_Dst.self::IMG_DEST);
						break;
					case 'png':
						imagepng ($Ress_Dst, $rep_Dst.self::IMG_DEST);
						break;
					}
 
					// ----------------------------------------------------------
					// liberation des ressources-image
					imagedestroy ($Ress_Src);
					imagedestroy ($Ress_Dst);
				}  
			}
	}
}

?>

