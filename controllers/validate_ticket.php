<?php

require_once('db_conn.php'); // Requisita a conexão com banco de dados

$error_field = null; //Setando variavel de erro
$code = isset($_POST["code"]) ? utf8_decode(trim( strip_tags( $_POST["code"] ) )) : ""; //Seta o valor do código

foreach ( $_POST as $key => $value ) { 
    
	// Loop que verifica se tem algum valor nulo
	if ( empty ( $value ) ) {

        $error_field = 'Campo code está em Branco';
        
    }

}

if ( (strlen($code) > 15 || strlen($code) < 14) && !$error_field ) { //Valida se o code passado não tem 14 caracteres
    
    $error_field = "Campo code está inválido.";

}

if($error_field){ //Se tiver erros

    $results = array(
        "error" => true,
        "msg"=>$error_field
    ); //Seta o results para envio no Json

}else{

    //Pesquisa se existe esse código no banco de dados
    $ticket_search = $conn->prepare("SELECT * FROM tbl_tickets WHERE code_ticket = :code_ticket");

    $ticket_search->execute(array(

        ":code_ticket" => $code

    ));
    
    $cont_results = $ticket_search->rowCount();

    if($cont_results != 1){
        //Se existe mais ou menos do que uma linha retorna um erro

        $results = array(
            "error" => true,
            "msg"=>"Código Inexistente."
        ); //Seta o results para envio no Json

    }else{

        //Pesquisa se existe esse código desativado no banco de dados

        $ticket_search_not_activity = $conn->prepare("SELECT tt.id, tt.code_ticket, tt.status_ticket, tm.img_event FROM tbl_tickets tt INNER JOIN tbl_models_tickets tm ON tt.id_model_ticket = tm.id WHERE tt.code_ticket = :code_ticket AND tt.status_ticket = :status_ticket");

        $ticket_search_not_activity->execute(array(

            ":code_ticket" => $code,
            ":status_ticket" => 0

        ));

        $cont_results_not_activity = $ticket_search_not_activity->rowCount();

        if($cont_results_not_activity != 1){
            //Se existe mais ou menos do que uma linha retorna um erro

            $results = array(
                "error" => true,
                "msg"=>"Código Já está ativado."
            ); //Seta o results para envio no Json

        }else{
            
            $results_ticket_ok = $ticket_search_not_activity->fetch(PDO::FETCH_ASSOC); //Gera o array para ser passado no JSON

            $restults_arr = (array) $results_ticket_ok; //Transformando o results_ticket em array

            $id = $restults_arr["id"]; //Captura o ID daquele ticket para ativas

            //Ativação
            $ticket_search_activity = $conn->prepare("UPDATE tbl_tickets SET status_ticket = :status_ticket WHERE id = :id");

            $ticket_search_activity->execute(array(

                ":id" => $id,
                ":status_ticket" => 1
                
            ));

            //Retorna o resultado succes
            $results = array(
                "success" => true,
                "msg"=>$restults_arr
            ); //Seta o results para envio no Json

        }

    }

}

echo json_encode($results);


?>