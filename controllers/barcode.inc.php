<?php 
/**
  @author: Raj Trivedi (India), 2009-10-14 
  @modify: Taylor Lopes (Brazil), 2012-04-06
  @modification-unique: Nathanael Cruz Alves (Brazil), 2019-08-07
*/
class barCodeGenrator {

	private $file;
	private $into;
	private $rotate_cod;
	private $h_mold_cod;
	private $w_mold_cod;
	private $w_code;
	private $h_code;
	private $c_code;
	private $digitArray = array(0=>"00110",1=>"10001",2=>"01001",3=>"11000",4=>"00101",5=>"10100",6=>"01100",7=>"00011",8=>"10010",9=>"01010");

	function __construct($value, $w_mold, $h_mold, $into=1, $filename = 'barcode.jpg', $width_bar=300, $height_bar=65, $show_codebar=false, $position=1, $code_color=1) { 	 
		
		$this->w_code = $width_bar;
		$this->h_code = $height_bar;
		$this->c_code = $code_color;
		$this->w_mold_cod = $w_mold;
		$this->h_mold_cod = $h_mold;
		$this->rotate_cod = $position;
		$lower = 1 ; $hight = 50;     

		$this->into = $into;
		$this->file = $filename;

		for($count1=9;$count1>=0;$count1--){ 
			for($count2=9;$count2>=0;$count2--){   
				$count = ($count1 * 10) + $count2 ; 
				$text = "" ; 
				for($i=1;$i<6;$i++){ 
					$text .=  substr($this->digitArray[$count1],($i-1),1) . substr($this->digitArray[$count2],($i-1),1); 
				} 
				$this->digitArray[$count] = $text; 
			} 
		} 
    
 
		$height_bar_max = $height_bar;
		$width_bar_max  = $width_bar;
      
		$img 		= imagecreate($width_bar_max,$height_bar_max);  
		if ($show_codebar) {
			$height_bar -= 25;
		} 
            
		$cl_black = imagecolorallocate($img, 0, 0, 0); 
		$cl_white = imagecolorallocate($img, 255, 255, 255); 
	
		#imagefilledrectangle($img, 0, 0, $lower*95+1000, $hight+300, $cl_white); 
		imagefilledrectangle($img, 0, 0, $width_bar_max, $height_bar_max, $cl_white);
		imagefilledrectangle($img, 5,5,5,$height_bar,$cl_black); 
		imagefilledrectangle($img, 6,5,6,$height_bar,$cl_white); 
		imagefilledrectangle($img, 7,5,7,$height_bar,$cl_black); 
		imagefilledrectangle($img, 8,5,8,$height_bar,$cl_white); 

		$thin = 1 ; 
		
		if(substr_count(strtoupper($_SERVER['SERVER_SOFTWARE']),"WIN32")){
			$wide = 3;
		} else {
			$wide = 2.72;
		}
		$pos   = 9 ; 
		$text = $value ; 

		if((strlen($text) % 2) <> 0){ 
			$text = "0" . $text; 
		} 
  
 
		while (strlen($text) > 0) { 
			$i = round($this->JSK_left($text,2)); 
			$text = $this->JSK_right($text,strlen($text)-2); 
			
			$f = $this->digitArray[$i]; 
		
			for($i=1;$i<11;$i+=2){ 

				if (substr($f,($i-1),1) == "0") { 
					$f1 = $thin ; 
				}else{ 
					$f1 = $wide ; 
				} 

				imagefilledrectangle($img, $pos,5,$pos-1+$f1,$height_bar,$cl_black)  ; 
				$pos = $pos + $f1 ;   
			
				if (substr($f,$i,1) == "0") { 
					$f2 = $thin ; 
				}else{ 
					$f2 = $wide ; 
				} 

				imagefilledrectangle($img, $pos,5,$pos-1+$f2,$height_bar,$cl_white)  ; 
				$pos = $pos + $f2 ;   
			} 
		}

		imagefilledrectangle($img, $pos,5,$pos-1+$wide,$height_bar,$cl_black); 
		$pos=$pos+$wide; 
		
		imagefilledrectangle($img, $pos,5,$pos-1+$thin,$height_bar,$cl_white); 
		$pos=$pos+$thin; 
		
		
		imagefilledrectangle($img, $pos,5,$pos-1+$thin,$height_bar,$cl_black); 
		$pos=$pos+$thin; 
	
		if ($show_codebar) {
			imagestring($img, 5, 0, $height_bar+5, " ".$value, imagecolorallocate($img, 0, 0, 0));
		} 
		
		$this->put_img($img);
	} 
	
	function JSK_left($input,$comp){ 
		return substr($input,0,$comp); 
	} 
	
	function JSK_right($input,$comp){ 
		return substr($input,strlen($input)-$comp,$comp); 
	} 

	function put_img($image,$file='test.jpg'){
		
		if($this->rotate_cod == 1){
			$rt_code = -90;
		}else{
			$rt_code = 90;
		}

		if($this->c_code == 2){
			$r_c = 0;
			$g_c = 30;
			$b_c = 107;
		}elseif($this->c_code == 3){
			$r_c = 61;
			$g_c = 26;
			$b_c = 0;
		}elseif($this->c_code == 4){
			$r_c = 21;
			$g_c = 70;
			$b_c = 0;
		}else{
			$r_c = 0;
			$g_c = 0;
			$b_c = 0;
		}

		$path_correct = $_SERVER["DOCUMENT_ROOT"] . DIRECTORY_SEPARATOR . "SGT" . DIRECTORY_SEPARATOR . "images" . DIRECTORY_SEPARATOR . "tmp_tickets" . DIRECTORY_SEPARATOR . "tmp_code_only" . DIRECTORY_SEPARATOR;

		if($this->into){

			$rotation = imagerotate($image, $rt_code, 0);
			imagefilter($rotation, IMG_FILTER_COLORIZE, $r_c, $g_c, $b_c);
			imagejpeg($rotation, $path_correct . $this->file, 100);

		} else {
			header("Content-type: image/jpeg");
			$rotation = imagerotate($image, $rt_code, 0);
			imagefilter($rotation, IMG_FILTER_COLORIZE, $r_c, $g_c, $b_c);
			imagejpeg($rotation, $path_correct . $this->file, 100);
		}

		$img_code_creator = '<img src="' . $_SERVER["DOCUMENT_ROOT"]. DIRECTORY_SEPARATOR . '"SGT"' . DIRECTORY_SEPARATOR . '"images"' . DIRECTORY_SEPARATOR . '"tmp_tickets"' . DIRECTORY_SEPARATOR . '"tmp_tickets_only"' . DIRECTORY_SEPARATOR . $this->file.'" />'; 

		$image_code_ok = imagecreatefromjpeg($path_correct . $this->file);
		$new_mold = imagecreatetruecolor($this->w_mold_cod, $this->h_mold_cod);//cria a folha de acordo com as especificações

		$bg = imagecolorallocate($new_mold, 255, 255, 255);//define a cor da folha
		imagefill($new_mold, 0, 0, $bg);
		
		$x = round(($this->w_mold_cod - $this->h_code) / 2);
		$y = round(($this->h_mold_cod - $this->w_code) / 2); 

		imagecopyresampled($new_mold, $image_code_ok, $x, $y, 0, 0, $this->h_code, $this->w_code, $this->h_code, $this->w_code);//cola a imagem criada da arte no molde, de acordo com metade da margem na altura, porém na largura é adicionar a largura do código + a metada da margem para posicionar certo

		$mold_ready = $path_correct . "tmp_only_mold_code". DIRECTORY_SEPARATOR . $this->file; //Aqui é gerado o nome da moldura para ser salva, ideal é ter uma pasta temporaria

		imagejpeg($new_mold, $mold_ready, 100); // Gera a imagem da moldura na pasta
			
		imagedestroy($rotation);
		imagedestroy($new_mold);

	}
}

?>