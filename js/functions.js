var flip = 0;

function addNameFile(valor){
    var filename = document.getElementById("pathFile");
    filename.innerHTML=valor;
}

function addImageDiv(input){
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        
        reader.onload = function(e) {

            $('#artTicket').attr('src', "");
            $('#artTicket').attr('src', e.target.result);
            
        }
        
        reader.readAsDataURL(input.files[0]);
    }

}

function retorno(){
    window.location = "/SGT/";
}

$(document).ready(function(){

    $('#file').change(function() {
        addNameFile(this.value);
        addImageDiv(this);
        $('.img_box .flipper').css('transform', 'rotateY(180deg)'); 
        $('.img_box.hover .flipper').css('transform', 'rotateY(180deg)'); 
    });

    $('#p_code').click(function(){

        if (this.value == 1) {

            $('#p_selected_right').parents('.code_preview_position').fadeOut(200);
            $('#p_selected_left').parents('.code_preview_position').delay(600).fadeIn(400);

        }else{

            $('#p_selected_left').parents('.code_preview_position').fadeOut(200);
            $('#p_selected_right').parents('.code_preview_position').delay(600).fadeIn(400);

        }

    });

    $('#c_border').click(function(){
        if (this.value == 1) {
            $('#color_preview_border').fadeOut(200);
            $('#color_preview_border').delay(600).fadeIn(400);
            $('#color_preview_border').css({
                'border': '3px solid rgb(88,88,88)'
            });
        }else{
            $('#color_preview_border').fadeOut(200);
            $('#color_preview_border').delay(600).fadeIn(400);
            $('#color_preview_border').css({
                'border': '3px solid rgb(220,220,220)'
            });
        }
    });

    $('#c_code').click(function(){
        if (this.value == 2) {
            $('#color_preview_code').fadeOut(200);
            $('#color_preview_code').delay(400).fadeIn(200);
            $('#color_preview_code h5').css({
                'background-color': '#001e6b',
                '-webkit-background-clip': 'text',
                '-webkit-text-fill-color': 'transparent'
            });
        }else if(this.value == 3){
            $('#color_preview_code').fadeOut(200);
            $('#color_preview_code').delay(400).fadeIn(200);
            $('#color_preview_code h5').css({
                'background-color': '#3d1a00',
                '-webkit-background-clip': 'text',
                '-webkit-text-fill-color': 'transparent'
            }); 
        }else if(this.value == 4){
            $('#color_preview_code').fadeOut(200);
            $('#color_preview_code').delay(400).fadeIn(200);
            $('#color_preview_code h5').css({
                'background-color': '#154600',
                '-webkit-background-clip': 'text',
                '-webkit-text-fill-color': 'transparent'
            }); 
        }else{
            $('#color_preview_code').fadeOut(200);
            $('#color_preview_code').delay(400).fadeIn(200);
            $('#color_preview_code h5').css({
                'background-color': '#000000',
                '-webkit-background-clip': 'text',
                '-webkit-text-fill-color': 'transparent'
            }); 
        }
    });

    $('#btn_generate').click(function() {

        $.ajax({
            url: 'controllers/generate_ticket.php',
            method: 'post',
            beforeSend: function(){

                $('#loadBar').fadeIn(200);
                $("#load_text_bar").append("Gerando Arquivos");
                $("#frm_generate").fadeOut(200);

            },
            xhr: function() {
                var xhr = new window.XMLHttpRequest();//Instaciar XMLHttp
                xhr.upload.addEventListener("progress", function(evt) {
                    if (evt.lengthComputable) {
                        var percentComplete = (evt.loaded / evt.total) * 100;//Pega o percentual completo

                        $(".progress-bar").css('width', percentComplete + "%"); //Cresce barar de progresso
                        $(".progress-bar").attr('aria-valuenow', percentComplete);
                        $(".box_ok").fadeOut(400);
                        $(".errors_box").fadeOut(400);
                    }
               }, false);
               return xhr;
            },
            data: new FormData($('#frm_generate')[0]),
            cache: false,
            contentType: false,
            processData: false,
            success: function(results){

                var data_results = jQuery.parseJSON(results);

                $('#loadBar').fadeOut(200);
                $("#load_text_bar").fadeOut(200);
                $("#frm_generate").fadeIn(200);

                if(typeof(data_results.error) != "undefined"){

                    $(".box_ok").fadeOut(400);
                    $(".errors_box p").html("");
                    $(".errors_box p").append("<i class='fas fa-exclamation-circle'></i> " + data_results.error_field);
                    $(".errors_box").fadeIn(400);

                }
                else if(typeof(data_results.success) != "undefined"){

                    $(".errors_box").fadeOut(400);
                    $(".box_ok p").html("");
                    $(".box_ok p").append("<i class='fas fa-check-double'></i> " + data_results.msg);
                    $(".box_ok").fadeIn(400);
                }

            },
            error: function(request, status, erro){
                alert("Problema ocorrido: " + status + "\nDescição: " + erro);
            }
        });// Fim do ajax
        return false;
    }); 


    $('#btn_verify').click(function() {

        var code_v = $('#code_v').val();

        $.ajax({
            url: 'controllers/validate_ticket.php',
            method: 'post',
            data: {'code':code_v},
            success: function(results){

                var data_results = jQuery.parseJSON(results);

                $("#validate_ticket_msg h4").html("");

                if(typeof(data_results.error) != "undefined"){
                    
                    $('#validate_ticket_msg').removeClass("border-info");
                    $('#validate_ticket_msg').addClass("border-danger");

                    if(flip != 0){
                        
                        $('.img_box_validate .flipper').css('transform', 'rotateY(0deg)'); 
                        $('.img_box_validate.hover .flipper').css('transform', 'rotateY(0deg)'); 
                    }

                    $("#validate_ticket_msg #msg_failed").append("<i class='fas fa-times-circle'></i> " + data_results.msg);

                    flip = 0;


                }
                else if(typeof(data_results.success) != "undefined"){

                    $('#validate_ticket_msg').removeClass("border-danger");
                    $('#validate_ticket_msg').addClass("border-info");

                    if(flip == 0){

                        $('.img_box_validate .flipper .back img').attr("src", "images/model_tickets/" + data_results.msg.img_event);
                        $('.img_box_validate .flipper').css('transform', 'rotateY(180deg)'); 
                        $('.img_box_validate.hover .flipper').css('transform', 'rotateY(180deg)'); 

                    }
                    
                    if(flip > 0){
                        $('.img_box_validate .flipper').css('transform', 'rotateY(0deg)'); 
                        $('.img_box_validate.hover .flipper').css('transform', 'rotateY(0deg)'); 
                        $('.img_box_validate .flipper .back img').removeAttr("src");
                        $('.img_box_validate .flipper .back img').attr("src", "images/model_tickets/" + data_results.msg.img_event);
                        $('.img_box_validate .flipper').css('transform', 'rotateY(-180deg)'); 
                        $('.img_box_validate.hover .flipper').css('transform', 'rotateY(-180deg)'); 

                    }

                    $("#validate_ticket_msg #msg_ok").append("<i class='fas fa-check-circle'></i> Ticket <span>" + data_results.msg.code_ticket + "</span> OK!<br> Ativado com Sucesso.");

                    flip += 1;

                }

                $('#validate_ticket_msg').css({
                    'display': 'flex'
                });

            },
            error: function(request, status, erro){
                alert("Problema ocorrido: " + status + "\nDescição: " + erro);
            }
        });// Fim do ajax
        return false;
    }); 

});