<?php
session_start(); 

?>
<!DOCTYPE html>
<html>
<head>        
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">         
     
<style>
    main {
        width: 600px;
        margin: auto;
        color: darkblue;
        text-align: left;
    }
    a {
        text-decoration: none;
    }
    h1{
        text-align: center;
        color: darkblue;
    }
    h4, i {
        color: darkmagenta;
    }
</style>   
</head>
<body>
<main>
<a href = 'https://catsandcode.org/simple-list'>&larr; Return</a><br><br>         
<a href = 'index.php'><h1>Your Items</h1></a>
<i>(Number of items limited to 7, number of submissions limited to 10)</i>        

<?php
//Prevent to many submissions during session
if (!isset ($_SESSION['items-counter'])) { 
    $_SESSION['items-counter'] = 0;
}
$string1 = file_get_contents ('items.txt');
$array1 = explode (',', $string1);


if ($_SERVER ["REQUEST_METHOD"] == "POST" ) {
    $_SESSION['items-counter']++;
    if ($_SESSION['items-counter'] >= 10) {
        echo "<h4>Too many submissions during this session</h4>";
    }
    else {
        $newitem = $_POST['newitem']; 
        if ($newitem ) {          
            $newitem = preg_replace('/[^A-Za-z0-9-]/', '', $newitem);            
       
            if (in_array ( $newitem, $array1) ) {
                echo "<h4>" . $newitem . " already exists</h4>";
            }
            else { 
               if (count ($array1) >= 7) {
                   array_shift ($array1);    
                   echo "<h4>Limit reached - first item removed</h4>";
               }
               array_push ($array1, $newitem);
               $string1 = implode (',', $array1);
               ltrim ($string1, ',');
               file_put_contents ('items.txt', $string1);
               echo "<h4>" . $newitem . " added </h4>";       
            } 
         }
    }
} 

$string1 = file_get_contents ('items.txt');
$array1 = explode (',', $string1);

if ($string1) {  
    echo "<h3>Current Items:</h3>";
     

    echo "<ul>";
    foreach ($array1 as $item1) {
        if ($item1) {
             echo "<li>" . $item1 . "</li>";
        }
    }
    echo "</ul>";
}

?>
<br><h3>Add New Item</h3>
<form action="index.php?page=add-list" method="post" >               
    <input type = 'text' name = 'newitem' /><br><br>
    <input class = 'submitbutton' type = 'submit'  value = 'Submit' name = 'submit-new'>        
</form>
</main>
</body>
</html>

