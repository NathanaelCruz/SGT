<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Gerador de Tickets</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href="https://use.fontawesome.com/releases/v5.0.7/css/all.css" rel="stylesheet">
    <link rel="stylesheet" href="/SGT/css/animate.css">
    <link rel="stylesheet" href="/SGT/css/app.css">
    <link href="https://fonts.googleapis.com/css?family=Red+Hat+Display&display=swap" rel="stylesheet">

</head>
<body class="wow fadeIn" data-wow-duration="0.7s">

    <div class="container">
            <?php
            
                require_once("vendor/autoload.php");

                use Slim\Slim;

                $app = new Slim();

                $app->get("/", function(){
                    require_once("pages/home.php");
                });

                $app->get("/generate", function(){
                    require_once("pages/generator.php");
                });

                $app->get("/validate", function(){
                    require_once("pages/validate.php");
                });

                $app->post("", function(){

                });


                $app->run();
            
            
            ?>
    </div>


    <!--Scripts JS-->
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/wow/1.1.2/wow.min.js" integrity="sha256-z6FznuNG1jo9PP3/jBjL6P3tvLMtSwiVAowZPOgo56U=" crossorigin="anonymous"></script>

    <script type="text/javascript" src="/SGT/js/wow.min.js"></script>
    <script type="text/javascript" src="/SGT/js/functions.js"></script>
</body>
</html>