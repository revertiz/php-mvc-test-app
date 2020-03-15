<?php include VIEW . 'header.php'; ?>

<h2>Client Page</h2>

<?php
$client = $this->viewData['client'];

//sita brieda reikia tvarkyt padarius clientExists(); kur nors funkcija GAL ir ne
// pasiziuret kaip formatuot php +html koda vanila
if ($_GET['id']) {
if ($client->getName() == null) {
    echo 'Tokio vartotojo nera' . '<br>';
    echo 'Iveskite savo kliento id';
    ?>
    <form method="get" action="">
        <input type="text" name="id" placeholder="iveskite id">
        <input type="submit" value="Rodyti">
    </form>
    <?php
} else {
$name = $client->getName();
$serviced = $client->getServiced();
$isserviced = $client->isServiced();
$id = $client->getId();
$specialistName = $client->getSpecialist()->getName();
?>
<table>
    <tr>
        <th><a href="client.php?sorting=<?php echo 'asc' ?>&field=name">Vardas</th>
        <th><a href="client.php?sorting=<?php echo 'asc' ?>&field=serviced">Aptarnauta</th>
        <th><a href="client.php?sorting=<?php echo 'asc' ?>&field=Id">Id</th>
        <th>Specialistas</th>
        <?php if ($isserviced) {
            echo '<td>' . 'Vizito laikas' . '</td>';
        } else {
            echo '<td>' . 'Laukimo laikas' . '</td>';
        }
        ?>

    </tr>
    <?php

    echo '<tr>';
    echo '<td>' . $name . '</td>';
    echo '<td>' . $serviced . '</td>';
    echo '<td>' . $id . '</td>';
    echo '<td>' . $specialistName . '</td>';
    if ($isserviced) {
        echo '<td>' . $client->getVisitLength($id) . '</td>';
    } else {
        echo '<td>' . $client->getWaitTime() . '</td>';
        echo '<td>' . $client->getExpServTime() . '</td>';
    }
    echo '<td><form method="post" action=""><input type="submit" name="delete" value="Atsaukti"></form></td>';
    echo '</tr>';
    }
    } else {
        echo 'Iveskite savo kliento id';
        ?>
        <form method="get" action="">
            <input type="text" name="id" placeholder="iveskite id">
            <input type="submit" value="Rodyti">
        </form>
        <?php
    }
    ?>
</table>

<?php include VIEW . 'footer.php'; ?>
