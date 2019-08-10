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
![Screen_01](https://user-images.githubusercontent.com/40793400/62825797-cadd7180-bb87-11e9-8a0c-a21db79d9729.png)
![Screen_02](https://user-images.githubusercontent.com/40793400/62825798-cb760800-bb87-11e9-8985-05d821d3f3f6.png | width=200)
![Screen_03](https://user-images.githubusercontent.com/40793400/62825799-cb760800-bb87-11e9-9e29-ec9891634aab.png | width=200)
![Screen_04](https://user-images.githubusercontent.com/40793400/62825800-cc0e9e80-bb87-11e9-9b9e-9919049315be.png | width=200)
![Screen_05](https://user-images.githubusercontent.com/40793400/62825801-cd3fcb80-bb87-11e9-9bea-cb1367acff0b.png | width=200)
![Screen_06](https://user-images.githubusercontent.com/40793400/62825802-ce70f880-bb87-11e9-837f-beb7fbaeaf7f.png | width=200)
![Screen_07](https://user-images.githubusercontent.com/40793400/62825803-ce70f880-bb87-11e9-8160-12d660faa5ba.png | width=200)
![Screen_08](https://user-images.githubusercontent.com/40793400/62825805-cf098f00-bb87-11e9-8087-af6e3d77b1b8.png | width=200)
![Screen_09](https://user-images.githubusercontent.com/40793400/62825806-cfa22580-bb87-11e9-8f27-a9e3144b86db.png | width=200)
