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
            $_FILES['fileToUpload']['error'] == UPLOAD_ERR_OK
            && is_uploaded_file($_FILES['fileToUpload']['tmp_name'])
        ) {

            $file = $_FILES['fileToUpload']['tmp_name'];
            echo "<p>Arquivo carregado com sucesso!</p>";
            $xlsx = new SimpleXLSX($file);
            if ($xlsx->success()) {
                $sheet = 2;
                $result = 0;
                $i = 0;
                foreach ($xlsx->rows($sheet) as $r) {
                    if ($i === 0) {
                        $i++;
                        continue;
                    }

                    $result = $result + $r[1];

                    $msg = '';
                    if ($r[1] === 1) {
                        $msg = $r[2];
                    } else {
                        $msg = $r[3];
                    }
                    echo "<br>";
                    echo '<b>' . $r[0] . ': </b>' . $msg;
                    echo "</br>";

                    $i++;
                };
                echo "<br>";
                echo '<b>Resultado percentual: </b>' . number_format($result / ($i - 1) * 100, 1) . '%';
                echo "</br>";
            } else {
                echo 'xlsx error: ' . $xlsx->error();
            }
        }
    }
    ?>

</body>

</html>