<?php

//Arquivo de validação da entrada de dados

$extensions = array("jpg", "jpeg", "png", "gif", "bmp"); //Cria o array com as extensões aceitas

$file = ($_FILES["file"]['error'] == 4) ? '' : $_FILES["file"]; //Seta o valor da variavel caso não venha nenhuma imagem no input file

/* Setando variaveis de error, largura e altura do arquivo e extensão do arquivo */
$error_field = false;
$w_file = false;
$h_file = false;
$ext = false;

/* Começo da validação */
if($file != ''){

    //Pega a extenão do arquivo file
    $ext = explode(".", $file["name"]);
    $ext = end($ext);

    //Verifica se é uma extensão aceita
    if(in_array(strtolower($ext), $extensions)){

        $info = getimagesize($file["tmp_name"]);
        $w_file = $info[0];
        $h_file = $info[1];

    }else{

        $error_field = "A foto deve ser do formato Jpg, png, gif ou bmp.";

    }

    if(((filesize($file["tmp_name"]) * 0.001) * 0.001) > 5){//Valida o tamanho da imagem

        $error_field = "A imagem deve ser menor que 5 MB.";

    }

}else{

    $error_field = "Escolha a arte para o ticket.";

}

if(!isset($_POST) || empty($_POST)){ //Se todos os campos estiverem vazios

    $error_field = "Todos os campos estão vazios.";

}

foreach ( $_POST as $key => $value ) { 
    
	// Loop que verifica se tem algum valor nulo
	if ( empty ( $value ) ) {

        $error_field = 'Existem campos em branco ou com zero.';
        
    }

}

/* Realizado a captura dos dados enviados, retirando espaços em branco e tirando qualquer tag enviada, em alguns casos convertendo para float ou para int e outros com codificação UTF */

$event_name = utf8_decode(trim( strip_tags( $_POST["event_name"] ) ));
$qtd = trim( strip_tags( $_POST["qtd"] ) );
$w_paper = trim( strip_tags( $_POST["w_paper"] ) );
$h_paper = trim( strip_tags( $_POST["h_paper"] ) );
$p_code = trim( strip_tags( $_POST["p_code"] ) );
$c_code = trim( strip_tags( $_POST["c_code"] ) );
$w_paper_formated = floatval(str_replace(",", ".", $w_paper));
$h_paper_formated = floatval(str_replace(",", ".", $h_paper));
$dpi = intval(trim( strip_tags( $_POST["dpi"] ) ));
$c_border = intval(trim( strip_tags( $_POST["c_border"] ) ));

//Validação do formato dos campos

if ( ! isset( $event_name ) && !$error_field ) {
    
    $error_field = 'O campo Nome do Evento deve ser preenchido.';

}

if (strlen( $event_name ) > 200 ) {

    $error_field = 'O campo Nome do Evento pode ter até 200 caracteres.';
    
}

if ( ( ! isset( $qtd ) || ! preg_match('/^[1-9][0-9]*$/', $qtd) ) && !$error_field ) {
    
    $error_field = 'A quantidade deve ser um numero inteiro acima de zero.';
    
}

if ( ( ! isset( $dpi ) || ! preg_match('/^[1-9][0-9]*$/', $dpi) ) && !$error_field ) {
    
    $error_field = 'A resolução deve ser numérico.';
    
}

if ( strlen($dpi) > 3 && !$error_field ) {
    
    $error_field = 'A resolução deve de até três digitos.';
    
}

if ( ( ! isset( $w_paper ) || ! preg_match('/^[0-9]+([.,][0-9]{1,2})?$/', $w_paper) ) && !$error_field ) {
    
    $error_field = 'O comprimento devem ter o formato (XX,XX).';

}

if(((($w_paper_formated / 2.5) * $dpi) < ($w_file + ((0.3 / 2.5) * $dpi) + ((2 / 2.5) * $dpi))) && !$error_field){

    $error_field = 'O comprimento da folha deve ser maior que o cartão.';

}


if ( ( ! isset( $h_paper ) || ! preg_match('/^[0-9]+([.,][0-9]{1,2})?$/', $h_paper) ) && !$error_field ) {
    
    $error_field = 'A altura devem ter o formato (XX,XX).';

}

if(((($h_paper_formated / 2.5) * $dpi) < ($h_file + ((0.3 / 2.5) * $dpi))) && !$error_field){

    $error_field = 'A altura da folha deve ser maior que o cartão.';

}

/* Nos casos de position code, color e border code sempre será setado para o padrão caso o usuário digite um valor incompativel com as opções */
if(! isset($p_code) || ($p_code > 2 || $p_code < 1)){

    $p_code = 1;

}

if(! isset($c_code) || ($c_code > 4 || $c_code < 1)){

    $c_code = 1;

}

if(! isset($c_border) || ($c_border > 2 || $c_border < 1)){

    $c_border = 1;

}


?>