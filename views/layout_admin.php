<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Arauca</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;700;900&display=swap" rel="stylesheet"> 
    <link rel="stylesheet" href="/build/css/app.css">
</head>
<body class="body-reservas"> 
    
    <div class="contenedor-reservas" >
        <?php echo $contenido; ?>
    </div>  

    <?php
        echo $script ?? '';
    ?>
    

   <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    tinymce.init({
        selector: '#descripcion',
        menubar: false,
        plugins: 'advlist autolink lists link charmap preview',
        toolbar: 'undo redo | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat',
        width:'100%',
    });
</script>



</body>
</html>
