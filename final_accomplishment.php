

<?php

	//deklarujemy rozmiar Macierzy i ograniczamy jej ilość do 5, w przypadku większej niż5 liczby - defaultowo ustawia 3 x 3	
	
    $rozmiarMacierzy = $_GET["stopien"];
    if(!is_numeric($rozmiarMacierzy) || $rozmiarMacierzy < 2 || $rozmiarMacierzy > 5)
        $rozmiarMacierzy = 3;
	//obsługa checkbox - podaj wynik- zakładam, że zawsze chcemy wynik
	
    if(!$_POST || $_POST["podaj_wynik"] == "podaj_wynik")
        $podaj_wynik = true;
	else
        $podaj_wynik = true;
  
 
    // jeżeli $POST nie jest puste, tworzymy macierz o podanym wcześniej rozmiarze (rozmiarMacierzy), 
	// jeżeli pole nie zostało wypełnione wstawiamy 0 
    if($_POST) {
        for($x = 1; $x <= $rozmiarMacierzy; $x++) {
            for($y = 1; $y <= $rozmiarMacierzy; $y++) {
                if(($a[$x][$y] = trim($_POST["a$x$y"])) == "")
                    $a[$x][$y] = "0";
                if(($b[$x][$y] = trim($_POST["b$x$y"])) == "")
                    $b[$x][$y] = "0";
            }
        }
        $znak = $_POST["znak"];
    }
?>
<!-- szkielet strony -->

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pl" lang="pl">
 
<head>
    <title class="title">Operacje na macierzach - 55557</title>
	<h4>Zadanie zaliczeniowe z podstaw PHP - operacje na marcierzach. Indeks 55557</h4>
	<hr>
    <meta http-equiv="content-type" content="text/html;charset=utf-8" />
	
	<!-- CSS do obróbki strony -->
    <style type="text/css">
        /*<![CDATA[*/
        input {
            width: 35px;
			height: auto;
        }
 
        input.submit, input.no-text {
            width: auto;
        }
 
        #wynik {
            border: 2px solid black;
            
        }
 
        #wynik td {
            border: 2px solid black;
            padding: 9px;
			margin-left: 2px;
        }
		
		body {
			background-image: url('http://153.19.106.47/stud/wsb55557/background3.jpg');
			font-size: 20px;
			font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
			display: block;
		}
		.innerBody {
			
			background: #A9A9A9;
			display: block;
		}
		h4 {
			color: white;
		}
		
		h5 {
			margin-left: 20px;
		}
		.button {
			
			margin-top: 20px;
			padding: 20px;
			
		}
		
		#wynik {
			font-family: Arial, Helvetica, sans-serif;
			border-collapse: collapse;
			width: 20%;
			
		}
		#wynik td, #wynik th{
			
		border: 1px solid #ddd;
		padding: 8px;
		}
		
		#wynik th {
		  padding-top: 12px;
		  padding-bottom: 12px;
		  text-align: left;
		  background-color: #04AA6D;
		  color: white;
		}
		#wynik tr:hover 
		{background-color: #ddd;}
		
			
        /*]]>*/
		
    </style>
	
	<!-- koniec CSS do obróbki strony -->
</head>
 
<body>

<!-- główne body -->

<div class="innerBody">
 
    <form action="" method="get">
        <p class="button">
            <label>
                Stopień macierzy:
                <input type="text" name="stopien" value="<?php echo $rozmiarMacierzy; ?>" />
            </label> <br />
            <input class="submit" type="submit" value="Zatwierdź" />
        </p>
    </form>
 
    <form action="" method="post">
        <fieldset>
            <h5>Wpisz tylko cyfry</h5>
			
			
	<!-- operacje na macierzach -->		
<?php
    echo "<table>\n";
 
    for($x = 1; $x <= $rozmiarMacierzy; $x++) {
        echo "<tr>\n";
 
        for($y = 1; $y <= $rozmiarMacierzy; $y++)
            echo "<td> <input type='text' name='a$x$y' value='{$a[$x][$y]}' /> </td>\n";
 
        echo "<td>\n";
        if($x == (int)(($rozmiarMacierzy+1) / 2)) {
            echo "<select name='znak'>\n";
			
			//podajemy z listy 2 sposoby działania mnożenie i dodawanie
			
            $dzialania = array("+", "*");
            foreach($dzialania as $z) {
                $selected = "";
                if($z == $znak)
                    $selected = "selected='selected'";
                echo "<option value='$z' $selected>$z</option>\n";
            }
            echo "</select>\n";
        }
        echo "</td>\n";
 
        for($y = 1; $y <= $rozmiarMacierzy; $y++)
            echo "<td> <input type='text' name='b$x$y' value='{$b[$x][$y]}' /> </td>\n";
 
        echo "</tr>\n";
    }
    echo "</table>\n";
	
	//submit button - oblicz
    echo "
        <input class='submit' type='submit' value='Oblicz' />\n";
?>
        </fieldset>
    </form>
 
<?php
 
// główna funkcja - obliczenie zadanej operacji
function obliczMacierz()
{
    global $rozmiarMacierzy, $a, $b, $znak, $podaj_wynik;
 
    if(!$rozmiarMacierzy || !$znak || !$a || !$b)
        return false;
    for($x = 1; $x <= $rozmiarMacierzy; $x++) {
        for($y = 1; $y <= $rozmiarMacierzy; $y++) {
            if($a[$x][$y] == "" || $b[$x][$y] == "")
                return false;
            if(!is_numeric($a[$x][$y]) || !is_numeric($b[$x][$y]))
                $podaj_wynik = false;
        }
    }
	
	//używając switcha możemy obsłużyc osobno operacje dodawania i mnożenia
 
    $minus = false;
    switch($znak) {
		
		//dodawanie

    case "+":
        
        if($podaj_wynik) {
            for($x = 1; $x <= $rozmiarMacierzy; $x++) {
                for($y = 1; $y <= $rozmiarMacierzy; $y++) {
                    $b_tmp = ($minus ? -1 : 1) * $b[$x][$y];
                    $w[$x][$y] = $a[$x][$y] + $b_tmp;
                }
            }
        // podajemy zapis działania
        } else {
            for($x = 1; $x <= $rozmiarMacierzy; $x++) {
                for($y = 1; $y <= $rozmiarMacierzy; $y++) {
                    // obsługa dodatkowych znaków minus i plus w polach macierzy
                    $a_tmp = $a[$x][$y];
                    if(substr($a_tmp, 0, 1) == "+")
                        $a_tmp = substr($a_tmp, 1);
 
                    $b_tmp = $b[$x][$y];
                    switch(substr($b_tmp, 0, 1)) {

                    case "+":
                        $b_tmp = substr($b_tmp, 1);
                        break;
                    }
 
                    $w[$x][$y] = $a_tmp.($minus ? " - " : " + ").$b_tmp;
                }
            }
        }
        break;
		
		
    case "*":
        // mnożenie 
 
        if($podaj_wynik) {
            for($x = 1; $x <= $rozmiarMacierzy; $x++) {
                for($y = 1; $y <= $rozmiarMacierzy; $y++) {
                    $suma = 0;
                    for($r = 1; $r <= $rozmiarMacierzy; $r++)
                        $suma += $a[$x][$r] * $b[$r][$y];
                    $w[$x][$y] = $suma;
                }
            }

        } else {
            // obsługa dodatkowych znaków minus i plus w polach macierzy
            for($x = 1; $x <= $rozmiarMacierzy; $x++) {
                for($y = 1; $y <= $rozmiarMacierzy; $y++) {
                    switch(substr($a[$x][$y], 0, 1)) {
                    case "-":
                        $a[$x][$y] = "({$a[$x][$y]})";
                        break;
                    case "+":
                        $a[$x][$y] = substr($a[$x][$y], 1);
                        break;
                    }
                    switch(substr($b[$x][$y], 0, 1)) {
                    case "-":
                        $b[$x][$y] = "({$b[$x][$y]})";
                        break;
                    case "+":
                        $b[$x][$y] = substr($b[$x][$y], 1);
                        break;
                    }
                }
            }
            
            for($x = 1; $x <= $rozmiarMacierzy; $x++) {
                for($y = 1; $y <= $rozmiarMacierzy; $y++) {
                    $suma = "";
                    for($r = 1; $r <= $rozmiarMacierzy; $r++)
                        $suma .= "{$a[$x][$r]} * {$b[$r][$y]} + ";
                    $w[$x][$y] = substr($suma, 0, -3);
                }
            }
        }
        break;
		
		//w przypadku gdy żadna z operacji nie jest poprawna - false
    default:
        return false;
        break;
    }
 //wypisanie wyniku w tabeli
 
    echo "<table id='wynik'>\n";
    for($x = 1; $x <= $rozmiarMacierzy; $x++) {
        echo "<tr>\n";
        for($y = 1; $y <= $rozmiarMacierzy; $y++)
            echo "<td> {$w[$x][$y]} </td>\n";
        echo "</tr>\n";
    }
    echo "</table>\n";
 
    return true;
}
 
 //wyświetl wynik końcowy
if($_POST) {
    echo "<p>Wynikiem jest macierz:</p>\n";

    if(!obliczMacierz())
        echo "<p>Błąd danych</p>\n";
}
 
?>


</div>
 
</body>
</html>

<!-- koniec szkieletu strony -->

