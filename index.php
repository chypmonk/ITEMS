
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
    h4 {
        color: darkmagenta;
    }
</style>   
</head>
<body>
<main>
             
<a href = 'index.php'><h1>Your Items</h1></a>
           

<?php
$string1 = file_get_contents ('items.txt');
$array1 = explode (',', $string1);


if ($_SERVER ["REQUEST_METHOD"] == "POST" ) {
   
    if (isset(  $_POST['newitem'])) {

        $newitem = $_POST['newitem']; 
        if ($newitem ) {          
            $newitem = preg_replace('/[^A-Za-z0-9-]/', '', $newitem);            
       
            if (in_array ( $newitem, $array1) ) {
                echo "<h4>" . $newitem . " already exists</h4>";
            }
            else { 
               array_push ($array1, $newitem);
               $string1 = implode (',', $array1);
               ltrim ($string1, ',');
               file_put_contents ('items.txt', $string1);
               echo "<h4>" . $newitem . " added </h4>";       
            } 
         }
    }
} 
if ($string1) {  
    echo "<h3>Current Items: </h3>";

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

