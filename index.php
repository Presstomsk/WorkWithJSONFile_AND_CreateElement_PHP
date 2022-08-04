<?php

$file = fopen("countries.txt", 'a+'); fclose($file); //Если файла не существует, во избежание ошибки file_get_contents, он создается
 
$ourData = file_get_contents("countries.txt"); // получаем данные из файла 
$countries = json_decode($ourData, true); // Преобразуем в массив
//var_dump($countries); // выводим массив   

if (!empty($_POST['country'])){   // Проверка на значение в поле
    
    $country = $_POST['country'];

    $flag = true;

    if ($countries != null){
        foreach ($countries as $value) {    // Проверка на наличие в файле
            if($value===$country){
                echo "Данная страна уже существует в списке!";
                $flag = false;
                break;
            } 
        }
    }
    
    if($flag == true){
        $countries[]=$country;
    } 

    $json = json_encode($countries,JSON_UNESCAPED_UNICODE); //Кодирование массива в формат JSON

    $file = fopen("countries.txt", 'w'); //Открытие файла для перезаписи
        fwrite($file, $json);
    fclose($file);    
    
}
else{
    echo 'Введите значение!';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Working with JSON file</title>
</head>
<body>
    <form action="" method="POST" name="countriesAdd-form">
        <label>Country</label>
        <input type="text" name="country"/>
        <button type="submit" name="addButton" >Add Country to the File</button>
    </form><br>    
    <?php  // Создание элемента select и вывода списка стран
    $str = "<select>";    
    $resultData = file_get_contents("countries.txt"); 
    $resultCountries = json_decode($resultData, true);
    if ($resultCountries != null){
        foreach ($resultCountries as $value) {    
            $str .= "<option>".$value."</option>";            
        }
    }   
    $str .= "</select>";
    echo $str;
    ?>    
</body>
</html>
