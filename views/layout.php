<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Arauca</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;700;900&display=swap" rel="stylesheet"> 
    <link rel="stylesheet" href="/build/css/app.css">
</head>
<body>

    <div class="contenedor-app"> 
        <div class="imagen"></div>
        
        <div class="app">
            <?php echo $contenido; ?>
        </div>
    </div>  
    
    
    <?php
        echo $script ?? '';
    ?>
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js"></script>
</body>
</html>