<?php
    use Shuchkin\SimpleXLSX;

?>

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

    function Avaliar($file)
    {
        $header = array(1 => "x1 (água)", 2 => "r (kg/m3)", 3 => "v (m3/kg)", 4 => "v (m3/mol) x 106", 5 => "Dvmis (m3/mol) x 106", 6 => "Modelo", 7 => "", 8 => "     parcial molar (m³/mol) x 106", 9 => "     parcial molar (m³/mol) x 106", 10 => "v (m3/mol) calculado x 106", 11 => "p (kg/m3) calculado");
        $erros = array();

        $xlsx = new SimpleXLSX($file); // try...catch
        if ($xlsx->success()) {
            $lin = 0;
            foreach ($xlsx->rows() as $r) {
                $lin = $lin + 1;
                $col = 0;
                foreach ($r as $cell) {
                    if ($lin == 2 && $col > 0 && $col < 12) {
                        if ($header[$col] != $cell) {
                            array_push($erros, "A ordem das colunas foi alterada ou a planilha foi modificada. Era esperado <strong>'" . $header[$col] . "'</strong> na posi&ccedil;&atilde;o <strong>" . chr($col + 65) . ($lin) . "</strong> ao inv&eacute;s de <strong>" . $cell . "</strong><br>");
                        }
                    }
                    $col = $col + 1;
                }
            }
        } else {
            echo 'xlsx error: ' . $xlsx->error();
        }
        return $erros;
    }

    if (isset($_FILES['fileToUpload'])) {
        if (
            $_FILES['fileToUpload']['error'] == UPLOAD_ERR_OK               //checks for errors
            && is_uploaded_file($_FILES['fileToUpload']['tmp_name'])
        ) { //checks that file is uploaded

            $header = array(1 => "x1 (água)", 2 => "r (kg/m3)", 3 => "v (m3/kg)", 4 => "v (m3/mol) x 106", 5 => "Dvmis (m3/mol) x 106", 6 => "Modelo", 7 => "", 8 => "     parcial molar (m³/mol) x 106", 9 => "     parcial molar (m³/mol) x 106", 10 => "v (m3/mol) calculado x 106", 11 => "p (kg/m3) calculado");

            $file = $_FILES['fileToUpload']['tmp_name'];
            echo "<p>Arquivo carregado com sucesso!</p>";
            $xlsx = new SimpleXLSX($file); // try...catch
            echo "<pre>";
            if ($xlsx->success()) {
                $lin = 0;
                foreach ($xlsx->rows() as $r) {
                    $lin = $lin + 1;
                    $col = 0;
                    foreach ($r as $cell) {
                        if ($lin == 2 && $col > 0 && $col < 12) {
                            if ($header[$col] == $cell) {
                                echo "*";
                            }
                            echo "*";
                        }
                        $col = $col + 1;
                        echo ($cell);
                        echo ",";
                    }
                    echo "<br>";
                }
            } else {
                echo 'xlsx error: ' . $xlsx->error();
            }
            echo "</pre>";
            echo "<br>";
            $erros = Avaliar($file);
            foreach ($erros as $e) {
                echo $e;
            }
        }
    }
    ?>

</body>

</html>