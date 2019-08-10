# SGT - Sistema Gerador de Tickets

### Descrição
O SGT é um sistema rest que tem como objetivo gerar uma matriz de tickets com código de barra para serem impressos. Além da opção de gerar, há a seção de validação, que o usuário pode validar o ticket apresentado , afim de verificar se está ok para ser utilizado.

### Tecnologias & Linguagens
1. PHP: Back-End
1. HTML 5: Front-End
1. CSS 3: Front-End
1. JavaScript: Front-End
1. Jquery 1.6: Front-End
1. MySql: Banco de dados
1. Ajax: Tratamento de Requisições
1. Biblioteca GD: Tratamento de Imagem
1. Classe Barcode.inc.php: Criação de Código de Barras*
1. PDO: Comunicação com Banco de dados
1. Awesome Fonts: Front-End Icones
1. CSS Animated & WOWSlider: Front-End Animações

### Frameworks

1. Bootstrap 4.0
2. Slim Framework: Rest

### API
3. Google Fonts

### Tipo de Código de Barra
O sistema utiliza o código de barra ITF-14 na geração devido ao formato enviado e visto que é para um produto que será semelhantes.

### Funcionalidades
4. Layout Responsivo
4. Validação em camadas
4. Geração de tickets
4. UI simples e intuitiva

### Utilização
Após sua implementação, para gerar tickets devera passar os dados do formulário, sendo os campos posição, cor da borda e cor do código opcionais sendo sempre setados para um padrão de cores definido na criação do código. Após gerar, será disponibilizado as páginas de tickets com a matriz da quantidade de tickets por página na pasta imagens/tickets. Assim que forem distribuidos os tickets gerados, na área de validação basta digitar o código gerado, ou com um leitor óptico, direcionando para ao campo code do formulário, assim ativando-o.

#### Telas
<section data-markdown>
  
  ![Screen 01](https://github.com/NathanaelCruz/images_resource_projects/blob/master/Images/Screen_01.png)
  <img src="https://github.com/NathanaelCruz/images_resource_projects/blob/master/Images/Screen_02.png" width="280"/>
  <img src="https://github.com/NathanaelCruz/images_resource_projects/blob/master/Images/Screen_03.png" width="280"/>
  <img src="https://github.com/NathanaelCruz/images_resource_projects/blob/master/Images/Screen_04.png" width="280"/>
  <img src="https://github.com/NathanaelCruz/images_resource_projects/blob/master/Images/Screen_05.png" width="350"/>
  <img src="https://github.com/NathanaelCruz/images_resource_projects/blob/master/Images/Screen_06.png" width="300"/>
  <img src="https://github.com/NathanaelCruz/images_resource_projects/blob/master/Images/Screen_07.png" width="280"/>
  <img src="https://github.com/NathanaelCruz/images_resource_projects/blob/master/Images/Screen_08.png" width="280"/>
  <img src="https://github.com/NathanaelCruz/images_resource_projects/blob/master/Images/Screen_09.png" width="280"/>
  
</section>
