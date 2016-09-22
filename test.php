<?php
function display()
{
    echo "hello ".$_POST["nameInput"];
}
if(isset($_POST['submit']))
{
   display();
}
?>