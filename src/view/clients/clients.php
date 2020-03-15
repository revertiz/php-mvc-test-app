<?php include VIEW . 'header.php'; ?>

<h2>Client list</h2>
<a href=""></a>
<table>
    <tr>
        <th><a href="client.php?sorting=<?php echo 'asc'?>&field=name">Vardas</th>
        <th><a href="client.php?sorting=<?php echo 'asc'?>&field=serviced">Aptarnauta</th>
        <th><a href="client.php?sorting=<?php echo 'asc'?>&field=Id">Id</th>
        <th>Specialistas</th>
    </tr>
    <?php

//    $specialists = $this->viewData[1];
    $clients = $this->viewData[0];

    foreach ($clients as $client) {

        echo '<tr>';
        echo '<td>' . $client->getName() . '</td>';
        echo '<td>' . $client->getServiced() . '</td>';
        echo '<td>' . $client->getId() . '</td>';
        echo '<td>' . $client->getSpecialist()->getName() . '</td>';
        echo '<td>' . $client->getSpecialist()->getId() . '</td>';
        echo '<td>' . $client->getWaitTime() . '</td>';
        echo '<td>' . $client->getExpServTime() . '</td>';

    }
    ?>

</table>

<!--PHP template foreach-->
<!--<table>-->
<!--    --><?php //foreach ($articles as $article) : ?>
<!--        <tr>-->
<!--            <td>-->
<!--                <h2><a href="article/--><?//= $article['url'] ?><!--">--><?//= $article['title'] ?><!--</a></h2>-->
<!--                --><?//= $article['description'] ?>
<!--            </td>-->
<!--        </tr>-->
<!--    --><?php //endforeach ?>
<!--</table>-->

<?php include VIEW . 'footer.php'; ?>
