<?php include VIEW . 'header.php'; ?>

    <h2>Unserviced client list</h2>
    <table>
        <tr>
            <th><a href="client.php?sorting=<?php echo 'asc'?>&field=name">Vardas</th>
            <th><a href="client.php?sorting=<?php echo 'asc'?>&field=serviced">Aptarnauta</th>
            <th><a href="client.php?sorting=<?php echo 'asc'?>&field=Id">Id</th>
            <th>Specialist</th>
        </tr>
        <?php
        //    echo 'vardumpas viewdata: <br>';
        //    var_dump($this->viewData);
        //    echo '<br>';
        foreach ($this->viewData[1] as $client) {
            echo '<tr>';
            echo '<td>' . $client->getName() . '</td>';
            echo '<td>' . $client->getServiced() . '</td>';
            echo '<td>' . $client->getId() . '</td>';
            echo '<td>' . $client->getSpecialist()->getName() . '</td>';
            echo '<td>';
            echo "<form method='post' action=''>";
            echo "<input type='hidden' name='id' value='" . $client->getId() . "'></input>";
            echo "<input type='hidden' name='specialist_id' value='" . $client->getSpecialistId() . "'></input>";
            echo "<button type='submit'>Service</button>";
            echo "</form>";
            echo '</td>';
            echo '</tr>';
        }
        ?>
    </table>
    <table>
        <tr>
            <th><a href="client.php?sorting=<?php echo 'asc'?>&field=name">Vardas</th>
            <th><a href="client.php?sorting=<?php echo 'asc'?>&field=Id">Id</th>
            <th><a href="client.php?sorting=<?php echo 'asc'?>&field=Id">Average service time</th>

        </tr>
        <?php
        //    echo 'vardumpas viewdata: <br>';
        //    var_dump($this->viewData);
        //    echo '<br>';
        foreach ($this->viewData[0] as $specialist) {
            echo '<tr>';
            echo '<td>' . $specialist->getName() . '</td>';
            echo '<td>' . $specialist->getId() . '</td>';
            echo '<td>' . $specialist->getAvgServiceTime() . '</td>';
            echo '</tr>';
        }
        ?>

    </table>

<?php include VIEW . 'footer.php'; ?>
