<?php include VIEW . 'header.php';?>


<h2>Registration Page</h2>

<?php
    if(isset($_POST['delete'])) {
        echo 'Sekmingai atsaukete vizita';
    }

echo $this->viewData['message'];
?>
<form method="post" action="register">
    <input type="text" name="user_name" placeholder="Iveskit varda">
    <input type="text" name="specialist_id" placeholder="Iveskite specialisto id (1 arba 2)">
    <input type="submit" value="Registruotis">
</form>
<?php include VIEW . 'footer.php';?>
