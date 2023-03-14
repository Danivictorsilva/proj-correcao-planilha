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
            $sheet = 3;
            if ($xlsx->success()) {
                $array = [
                    0 => $xlsx->getCell($sheet, 'D11'),
                    1 => $xlsx->getCell($sheet, 'D12'),
                    2 => $xlsx->getCell($sheet, 'D13'),
                    3 => $xlsx->getCell($sheet, 'D14'),
                    4 => $xlsx->getCell($sheet, 'H5'),
                    5 => $xlsx->getCell($sheet, 'H6'),
                    6 => $xlsx->getCell($sheet, 'I5'),
                    7 => $xlsx->getCell($sheet, 'I6'),
                    8 => $xlsx->getCell($sheet, 'J5'),
                    9 => $xlsx->getCell($sheet, 'J6'),
                    10 => $xlsx->getCell($sheet, 'K5'),
                    11 => $xlsx->getCell($sheet, 'K6'),
                    12 => $xlsx->getCell($sheet, 'L5'),
                    13 => $xlsx->getCell($sheet, 'L6'),
                    14 => $xlsx->getCell($sheet, 'J111'),
                    15 => $xlsx->getCell($sheet, 'L111'),
                ];

                foreach ($array as $valor) {
                    if($valor !== "Correto") {
                        echo "<br>";
                        echo $valor;
                        echo "</br>";
                    }
                };
                echo "<br>";
                echo 'Resultado final = '.$xlsx->getCell($sheet, 'Q7');
                echo "</br>";
            
            } else {
                echo 'xlsx error: '.$xlsx->error();
            }
            
        }
    }
    ?>

</body>
</html>