<!--
Die readTable.php liefert das grundliegende Tabellen-Layout.
Ferner liefert die Datenbankabfrage die notwendigen Informationen fuer den Inhalt der Tabelle
 -->

<div class="table-responsive">

    <table class="table table-bordered table-condensed table-hover table-striped" cellspacing="0" width="100%">
        <thead>
        <tr>
            <th>Datum</th>
            <th>Bild</th>
            <th>Memetext</th>
            <th>Aktion</th>
        </tr>
        </thead>

        <tbody>

        <?php

        // Abfrage der Informationen aus der Datenbank
        require_once 'dbconn.php';
        session_start();
        $userID = $_SESSION['userSession'];

        $query = "SELECT * FROM memes WHERE userid=$userID";
        $stmt = $DBcon->prepare($query);
        $stmt->execute();

        // Wenn der Count groesser als 0 ist soll die Tabelle solange gefuellt werden bis alle Informationen abgetragen sind.
        if ($stmt->rowCount() > 0) {

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                ?>
                <tr>
                    <td><?php echo $date; ?></td>
                    <td><img src="images/<?php echo $filename; ?>" width="220" height="220" class="rounded float-left">
                    </td>
                    <td><?php echo $memetext; ?></td>
                    <td>
                        <a class="btn btn-sm btn-danger" id="delete_meme" data-id="<?php echo $memeid; ?>"
                           href="javascript:void(0)">
                           <i class="fa fa-trash fa-2x"></i></a>
                    </td>
                </tr>
                <?php
            }

        // Wenn der Count 0 ist, hat der Nutzer noch keine Memes hochgeladen.
        } else {

            ?>
            <tr>
                <td colspan="3">Keine Memes gefunden....</td>
            </tr>
            <?php

        }
        ?>

        </tbody>
    </table>

</div>
