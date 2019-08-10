<?php


require_once('barcode.inc.php'); // Requisita o gerador de código de barras
require_once('db_conn.php'); // Requisita a conexão com banco de dados
require_once('validation_ticket_generate.php');// Requisita a validação dos campos do ticket

if($error_field){ // Valida se há algum erro

    $results = array(
        "error" => true,
        "error_field"=> $error_field,
    ); //Se sim seta a mensagem de error

}else{

    
    $w_paper_pixel = (($w_paper_formated / 2.5) * $dpi); //Largura máxima da folha em pixels
    $h_paper_pixel = (($h_paper_formated / 2.5) * $dpi); //Altura máxima da folha em pixels

    $margem_mold = ((0.3 / 2.5) * $dpi) * 2; //Define a margem de cada elemento dentro do modelo

    $w_ticket_ready = $w_file + $margem_mold + ((2 / 2.5) * $dpi); //Define o comprimento do ticket somando o comprimento da arte + comprimento do código + bordas
    $h_ticket_ready = $h_file + $margem_mold; //Define a altura do ticket somente a altura da arte (visto que o código também possuira o mesmo tamanho) com a bordas

    $num_col = floor($w_paper_pixel/$w_ticket_ready);//Calcula a quantidade de colunas
    $num_row = floor($h_paper_pixel/$h_ticket_ready);//Calcula a quantidade de linhas

    $remaining_qtd = $qtd;

    $h_init = 0; //Seta a posição da coluna
    $w_init = 0; //Seta a posição da linha

    $total_tickets_per_page = $num_col * $num_row; //Total de tickets por página

    $qtd_pages_total = ceil($qtd / $total_tickets_per_page); //Total de páginas a serem feitas

    $name_art_model = md5(uniqid()) . "." . $ext;//Gera o nome com 32 digitos da foto + extensão da foto

    $art = $file["tmp_name"];//Pega o valor temporario da imagem

    $path_file_art = $_SERVER["DOCUMENT_ROOT"] . DIRECTORY_SEPARATOR . "SGT" . DIRECTORY_SEPARATOR . "images" . DIRECTORY_SEPARATOR . "model_tickets" . DIRECTORY_SEPARATOR . $name_art_model; //Define o path com o nome da imagem gerada


    //Realiza a inserção do ticket que será gerado
    $ticket_princ = $conn->prepare("INSERT INTO tbl_models_tickets (event_name, img_event, qtd, height_paper, width_paper, pos_code, color_code, dpi) VALUES (:event_name, :img_event, :qtd, :height_paper, :width_paper, :pos_code, :color_code, :dpi)");

    $ticket_princ->execute(array(

        ":event_name"=>$event_name,
        ":img_event"=>$name_art_model,
        ":qtd"=>$qtd,
        ":height_paper"=>$h_paper_formated,
        ":width_paper"=>$w_paper_formated,
        ":pos_code"=>$p_code,
        ":color_code"=>$c_code,
        ":dpi"=>$dpi

    ));

    //Valida a url para realizar o create no sistem

    if($ext == 'jpg' || $ext == 'jpeg'){
        $image_art = imagecreatefromjpeg($art);
        imagejpeg($image_art, $path_file_art, 100);
    }
    elseif($ext == 'png'){
        $image_art = imagecreatefrompng($art);
        imagepng($image_art, $path_file_art, 100);
    }
    elseif($ext == 'gif'){
        $image_art = imagecreatefromgif($art);
        imagegif($image_art, $path_file_art, 100);
    }
    else{
        $image_art = imagecreatefrombmp($art);
        imagebmp($image_art, $path_file_art, 100);
    }

    $arr_validate_number = array("A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z","a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z");
    $code_init_event = utf8_decode(substr($event_name, 0, 1));

    $code_init_p1 = array_search($code_init_event, $arr_validate_number); 
    $code_init_p2 = rand(0, 9);
    $code_init_p3 = rand(0, 9);
    $code_init_p1_f = null;

    if(strlen($code_init_p1) == 1){
        $code_init_p1_f = "0" . $code_init_p1;
    }else{
        $code_init_p1_f = $code_init_p1;
    }

    if($code_init_p1 == null || $code_init_p1 == "" || $code_init_p1 == false){
        $code_init_p1 = 47;
    }

    $code_init = $code_init_p1_f . $code_init_p2 . $code_init_p3;

    $ultimate_ticket_model_i = $conn->lastInsertId(); //Recupera o ultimo ID salvo no BD para ser utilizado dentro do loop

    for ($p=1; $p <= $qtd_pages_total; $p++) { //Loop da quantidade de folhas

        $list_codebar = array();//Seta a variavel que irá conter a lista de codes salvos para exclusão posterior
        $list_ticket_only = array();//Seta a variavel que irá conter a lista de tickets a parte salvos para exclusão posterior


        $new_paper = imagecreatetruecolor($w_paper_pixel, $h_paper_pixel);//cria a folha de acordo com as especificações

        $bg_new_paper = imagecolorallocate($new_paper, 255, 255, 255);//define a cor da folha
        imagefill($new_paper, 0, 0, $bg_new_paper);// aplica o background-color na imagem criada

        list($image_width, $image_height, $type, $attribute) = getimagesize($path_file_art); //Pega os atributos da arte
        
        for ($r=1; $r <= $num_row; $r++) { //Loop da quantidade de linhas
            
            if($remaining_qtd <= 0){//Valida se tem ainda algum ticket a ser impresso, senão sai do loop
                break;
            }

            for ($c=1; $c <= $num_col; $c++) { //Loop da quantidade de colunas
                
                if($remaining_qtd <= 0){//Valida se tem ainda algum ticket a ser impresso, senão sai do loop
                    break;
                }


                $serial_code_bar = $code_init . rand(1000000000, 9999999999);//Gera o code com a primeira letra do evento + numero da pagina + numero da linha + numero da coluna + numero de dez digitos aleatorios

                $width_code_default = ((2 / 2.5) * $dpi);//Define a largura do lugar onde terá o ticket

                new barCodeGenrator($serial_code_bar, $width_code_default, $image_height, 1,$serial_code_bar.'.jpg', 170, 100, true, $p_code, $c_code); //Passa as especificações para gerar o código de barras

                $cod_str_ready = $_SERVER["DOCUMENT_ROOT"] . DIRECTORY_SEPARATOR . "SGT" . DIRECTORY_SEPARATOR . "images" . DIRECTORY_SEPARATOR . "tmp_tickets" . DIRECTORY_SEPARATOR . "tmp_code_only" . DIRECTORY_SEPARATOR . "tmp_only_mold_code". DIRECTORY_SEPARATOR . $serial_code_bar . ".jpg";
                //gerar esta variavel cod_str_ready com o path e código
                
                list($code_width, $code_height, $type_cod, $attribute_cod) = getimagesize($cod_str_ready); //Pega os atributos da arte

                array_push($list_codebar, $serial_code_bar . ".jpg");//Realiza a inclusão do code no array

                //Pegar valor do ticket + o code e salvar no bd
                $ticket = $conn->prepare("INSERT INTO tbl_tickets (id_model_ticket, code_ticket, status_ticket) VALUES (:id_model_ticket, :code_ticket, :status_ticket)");

                $ticket->execute(array(
            
                    ":id_model_ticket" => $ultimate_ticket_model_i,
                    ":code_ticket" => $serial_code_bar,
                    ":status_ticket" => 0
            
                ));

                $mold = imagecreatetruecolor($w_ticket_ready, $h_ticket_ready);//cria o molde para o tickete de acordo com as especificações passadas

                $r_border = ($c_border == 1) ? 88 : 220;//Seta o red do rgb para borda
                $g_border = ($c_border == 1) ? 88 : 220;//Seta o green do rgb para borda
                $b_border = ($c_border == 1) ? 88 : 220;//Seta o blue do rgb para borda

                $bg_mold = imagecolorallocate($mold, $r_border, $g_border, $b_border);//define a cor da moldura que será utilizada para emular bordas
                imagefill($mold, 0, 0, $bg_mold);// aplica o background-color na imagem de moldura criada

                if ($p_code == 2) { //Se a posição for igual a 2 quer dizer que o processo de criação deve começar com a arte e depois o código


                    imagecopyresampled($mold, $image_art, $margem_mold/2, $margem_mold/2, 0, 0, $image_width, $image_height, $image_width, $image_height);//cola a imagem criada da arte no molde, de acordo com metade da margem na altura, porém na largura é adicionar a largura do código + a metada da margem para posicionar certo

                    $cod_generator = imagecreatefromjpeg($cod_str_ready);//cria no sistema a imagem do código de barras

                    imagecopyresampled($mold, $cod_generator, ($margem_mold/2)+$image_width, $margem_mold/2, 0, 0, $code_width, $code_height, $code_width, $code_height);//cola a imagem criada do código no molde, de acorddo com metade da margem definida (15, 15) tanto altura como largura


                }else{// Senão a criação deve começar com o código depois a arte

                    $cod_generator = imagecreatefromjpeg($cod_str_ready);//cria no sistema a imagem do código de barras

                    imagecopyresampled($mold, $cod_generator, $margem_mold/2, $margem_mold/2, 0, 0, $code_width, $code_height, $code_width, $code_height);//cola a imagem criada do código no molde, de acorddo com metade da margem definida (15, 15) tanto altura como largura

                    imagecopyresampled($mold, $image_art, ($margem_mold/2)+$code_width, $margem_mold/2, 0, 0, $image_width, $image_height, $image_width, $image_height);//cola a imagem criada da arte no molde, de acordo com metade da margem na altura, porém na largura é adicionar a largura do código + a metada da margem para posicionar certo

                }

                $name_model_ready = $c . $r . ".jpg";//Cria o nome do ticket temporário
                array_push($list_ticket_only, $name_model_ready); //Realiza a adição do ticket (nome) no array

                $mold_ready = $_SERVER["DOCUMENT_ROOT"] . DIRECTORY_SEPARATOR . "SGT" . DIRECTORY_SEPARATOR . "images" . DIRECTORY_SEPARATOR . "tmp_tickets" . DIRECTORY_SEPARATOR . "tmp_tickets_only" . DIRECTORY_SEPARATOR . $name_model_ready; //Aqui é gerado o nome da moldura para ser salva, ideal é ter uma pasta temporaria

                imagejpeg($mold, $mold_ready, 100); // Gera a imagem da moldura na pasta

                $ticket_only_ready = imagecreatefromjpeg($mold_ready); //Aqui é gerado no sistema a moldura que acabou de ser criada, isso por que se for tentar adicionar uma tela criada pela GD dentro de outra tela ela não entende e gera branca

                imagecopyresampled($new_paper, $ticket_only_ready, $w_init, $h_init, 0, 0, $w_ticket_ready, $h_ticket_ready, $w_ticket_ready, $h_ticket_ready);//add o cartão na área de transferencia, a folha

                $w_init = $c * $w_ticket_ready; //Seta onde começara a coluna

                $remaining_qtd -= 1;//Reduz um da quantidade pois já foi adicionado um novo ticket

            }

            $h_init = $r * $h_ticket_ready;//Seta onde começara a linha
            $w_init = 0;//Seta onde começara a coluna em 0 por ser uma nova linha

        }

        //Seta os valores para iniciar da posição X, Y
        $w_init = 0;
        $h_init = 0;

        $name_page = $p . time() . ".jpg";//Seta nome da página
        $path_page_generate = $_SERVER["DOCUMENT_ROOT"] . DIRECTORY_SEPARATOR . "SGT" . DIRECTORY_SEPARATOR . "images" . DIRECTORY_SEPARATOR . "tickets" . DIRECTORY_SEPARATOR . $name_page;//Seta path do caminho que o arquivo percorrerá

        imagejpeg($new_paper, $path_page_generate, 100); //gera a folha com os tickets
        imagedestroy($new_paper);

        $path_code_mold = $_SERVER["DOCUMENT_ROOT"] . DIRECTORY_SEPARATOR . "SGT" . DIRECTORY_SEPARATOR . "images" . DIRECTORY_SEPARATOR . "tmp_tickets" . DIRECTORY_SEPARATOR . "tmp_code_only" . DIRECTORY_SEPARATOR . "tmp_only_mold_code". DIRECTORY_SEPARATOR;

        $path_code_only = $_SERVER["DOCUMENT_ROOT"] . DIRECTORY_SEPARATOR . "SGT" . DIRECTORY_SEPARATOR . "images" . DIRECTORY_SEPARATOR . "tmp_tickets" . DIRECTORY_SEPARATOR . "tmp_code_only" . DIRECTORY_SEPARATOR ;

        $path_ticket_only = $_SERVER["DOCUMENT_ROOT"] . DIRECTORY_SEPARATOR . "SGT" . DIRECTORY_SEPARATOR . "images" . DIRECTORY_SEPARATOR . "tmp_tickets"  . DIRECTORY_SEPARATOR . "tmp_tickets_only" . DIRECTORY_SEPARATOR;

        //Loop para apagar as imagens temporárias geradas para criar a página
        foreach ($list_codebar as $key => $value) {
            unlink($path_code_mold . $value);
        }
        foreach ($list_codebar as $key => $value) {
            unlink($path_code_only . $value);
        }
        foreach ($list_ticket_only as $key => $value) {
            unlink($path_ticket_only . $value);
        }

    }

    imagedestroy($image_art);//Depois de criar as páginas destruido a imagem do sistema

    $results = array(
        "success" => true,
        "msg"=>"Gerado " . $qtd_pages_total . " páginas de tickets"
    ); //Seta o results para envio no Json

}

echo json_encode($results);

?>