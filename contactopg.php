<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <title>Contacto</title>
    <link rel="stylesheet" href="css/contacto.css">
    <link rel="stylesheet" href="css/style.css">
    
</head>
<header>
    <nav>
        <div class="logo-container">
            <div class="logo">
                <img src="img/imagen.png" alt="Logo">
            </div>
        </div>
        <ul class="right-menu">
            <li><a href="#inicio">Inicio</a></li>
            <li><a href="#informacion">/  Información</a></li>
            <li><a href="#contacto">/ Contacto</a></li>
            <li><a href="#historial">/ Historial</a></li>
            <li><a href="#creadores">/ Creadores</a></li>
        </ul>
    </nav>
</header>
<body>

<div class="contenedor1">
    <div class="form-container">
       <br> <h2>Contactanos</h2><br><br>

        <form id="form" action="" method="post" autocomplete="off" >

            <div class="form-content">
                <label for="name">Nombre</label>
                <input type="text" id="name" name="name" placeholder="Nombre">
            </div>

            <div class="form-content">
                <label for="email">Correo</label>
                <input type="email" id="email" name="email" placeholder="Correo">
            </div>

            <div class="form-content">
                <label for="direction">Direccion</label>
                <input type="text" id="direction" name="direction" placeholder="Direccion">
            </div>

            <div class="form-content">
                <label for="phone">Telefono</label>
                <input type="tel" id="phone" name="phone" placeholder="Telefono">
            </div>

            <label for="message">Mensaje</label>
            <textarea name="message" id="message" cols="30" rows="10" placeholder="Mensaje"></textarea>

            <input class="btn" type="submit" name="contact" value= "Enviar Mensaje">


        </form>

    </div>
    </div>   
    
        <script src="js/contacto.js" ></script>

    <?php
        include("api/contacto.php")
    ?>

</body>
</html>