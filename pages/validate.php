<div class="wow fadeInUpBig text-center" id="container_validate">

    <h1>Validar Tickets</h1>
    <br>
    <div class="img_box_validate" ontouchstart="this.classList.toggle('hover');">
        <div class="flipper">
            <div class="front">  			
                <div class="front_art_ticket_model">
                    <div class="art_model_diagonal"></div>
                </div>		
            </div>  		
            <div class="back">  				
                <img id="artTicket" />
            </div>  	

        </div>

    </div>
    <form id="frm_ticket_validate" name="frm_ticket_validate" method="POST" action="">
        <div class="form-group">
            <label for="code_v">Digite o Código</label>
            <input type="text" class="form-control" id="code_v" name="code_v" placeholder="Digite o código">
            <small id="helpCodev" class="form-text text-muted">Digite o código para validar.</small>
        </div>

        <div class="form-group col-12">
            <input type="button" id="btn_verify" class="btn btn-outline-success col-5" value="Validar">
            <input type="button" class="btn btn-outline-danger col-5" onClick="retorno();" value="Cancelar">
        </div>
    </form>

    <div id="validate_ticket_msg" class="border">
        
        <h4 id="msg_ok" class="text-info"></h4>
        <!--class="border border-info"-->
        <h4 id="msg_failed" class="text-danger"></h4>
        <!--class="border border-danger"-->
    </div>

</div>