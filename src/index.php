<!DOCTYPE html>
<html>

<body>

    <form method="post" enctype="multipart/form-data">
        Carregue o arquivo para avalia&ccedil;&atilde;o:
        <input type="file" name="fileToUpload" id="fileToUpload">
        <p><br></p>
        <input type="submit" value="Carregar" name="submit">
    </form>

    <?php
    use Shuchkin\SimpleXLSX;

    ini_set('error_reporting', E_ALL);
    ini_set('display_errors', true);

    require_once __DIR__ . '/../vendor/autoload.php';

    if (isset($_FILES['fileToUpload'])) {
        if (
            $_FILES['fileToUpload']['error'] == UPLOAD_ERR_OK               //checks for errors
            && is_uploaded_file($_FILES['fileToUpload']['tmp_name'])
        ) { //checks that file is uploaded
            
            $file = $_FILES['fileToUpload']['tmp_name'];
            echo "<p>Arquivo carregado com sucesso!</p>";
            $xlsx = new SimpleXLSX($file); 
            if ($xlsx->success()) {
                echo 'Celula I10 ='.$xlsx->getCell(0, 'I10');
            
            } else {
                echo 'xlsx error: '.$xlsx->error();
            }
            
        }
    }
    ?>

</body>
</html>