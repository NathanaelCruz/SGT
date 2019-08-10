
<div class="wow fadeInUpBig text-center" id="container_form">

    <h1>Gerar Tickets</h1>
    <br>
    <div class="img_box" ontouchstart="this.classList.toggle('hover');">
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
    <form id="frm_generate" name="frm_generate" method="POST" action="" enctype="multipart/form-data">
        <div class="form-group">
            
            <label for="file" class="btn btn-outline-info">Escolha a Arte</label>
            <input type="file" class="form-control" id="file" name="file">
            <p id="pathFile"></p>
            <small id="helpFile" class="form-text text-muted">Escolha uma arte para o gerar a frente do ticket.</small>

        </div>

        <div class="form-group">
            <label for="dpi">Resolução</label>
            <input type="number" class="form-control" id="dpi" name="dpi" placeholder="Digite o DPI da imagem" required>
            <small id="helpdpi" class="form-text text-muted">Caso não saiba digite 300 (padrão).</small>
        </div>

        <div class="form-group">
            
            <label for="event_name">Nome do Evento</label>
            <input type="text" class="form-control" id="event_name" name="event_name" placeholder="Digite o nome do Evento" required>
            <small id="helpName" class="form-text text-muted">Digite o nome do evento, festividade ou atividade.</small>

        </div>
        <div class="form-group">
            <label for="qtd">Quantidade</label>
            <input type="number" class="form-control" id="qtd" name="qtd" placeholder="Digite a Quantidade" required>
            <small id="helpQtd" class="form-text text-muted">Defina quantos tickets serão produzidos.</small>
        </div>
        <div id="w_h_paper" class="row col-12">

            <label for="paper">Dimensões da Folha</label>
            <div class="form-group col-6">
                <input type="text" class="form-control" id="w_paper" name="w_paper" placeholder="Largura (cm)" required>
            </div>
            <div class="form-group col-6">
                <input type="text" class="form-control" id="h_paper" name="h_paper" placeholder="Altura (cm) " required>
            </div>
            <div class="col-12">
                <small id="helpQtd" class="form-text text-muted">Defina a largura (cm) e a altura (cm) da área da folha para impresão.</small>
            </div>
        </div>
        <br>
        <div class="form-group col-12">
            <label for="p_code">Posição Código</label>
            <select class="form-control" id="p_code" name="p_code">
                <option value="1">Esquerda</option>
                <option value="2">Direita</option>
            </select>
            <small id="helpPCod" class="form-text text-muted">Escolha em qual lado o código de barras aparecerá.</small>
            <div class="code_preview_position border border-secondary">
                <div id="p_selected_left">Code</div>
            </div>
            <div class="code_preview_position border border-secondary">
                <div id="p_selected_right">Code</div>
            </div>
        </div>
        <div class="form-group col-12">
            <label for="c_border">Cor da Borda de Corte</label>
            <select class="form-control" id="c_border" name="c_border">
                <option value="1">Cinza Escuro</option>
                <option value="2">Cinza Claro</option>
            </select>
            <small id="helpCBorder" class="form-text text-muted">Escolha uma cor para a borda de corte.</small>
            <div id="color_preview_border">
                <div class="preview_border_img_diagonal"></div>
            </div>
        </div>
        <div class="form-group col-12">
            <label for="c_code">Cor do Código</label>
            <select class="form-control" id="c_code" name="c_code">
                <option value="1">Preto</option>
                <option value="2">Azul Escuro</option>
                <option value="3">Marrom</option>
                <option value="4">Verde Escuro</option>
            </select>
            <small id="helpPCod" class="form-text text-muted">Escolha uma cor para o código de barras.</small>
            <div id="color_preview_code">
                <h5>Código de Barras</h5>
            </div>
        </div>
        <div id="box_btn_flex" class="form-group col-12 col-md-12">
            <input type="button" class="btn btn-outline-success col-12 col-md-5" id="btn_generate" value="Gerar">
            <input type="button" class="btn btn-outline-danger col-12 col-md-5" onClick="retorno();" value="Cancelar">
        </div>
    </form>
    <div class="errors_box border border-warning bg-warning">
        <p class="text-dark text-uppercase"></p>
    </div>
    <div class="box_ok border border-success">
        <p class="text-success text-uppercase"></p>
    </div>
    <p id="load_text_bar" class="text-center"></p>
    <div class="progress">
        <div id="loadBar" class="progress-bar bg-success" role="progressbar" style="width: 0%; display: none;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
    </div>
</div>

</div>