<div class="table-responsive">

	<table class="table table-bordered table-condensed table-hover table-striped" cellspacing="0" width="100%">
        <thead>
            <tr>
            	<th>Bild</th>
                <th>Memetext</th>
                <th>Aktion</th>
            </tr>
        </thead>

        <tbody>

            <?php

			require_once 'dbconn.php';
			$query = "SELECT memeid, filename, memetext FROM memes";
			$stmt = $DBcon->prepare( $query );
			$stmt->execute();

			if($stmt->rowCount() > 0) {

				while($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
				extract($row);
				?>
				<tr>
		        <td><img src="images/<?php echo $filename; ?>" width="220" height="220" class="rounded float-left"></td>
                <td><?php echo $memetext; ?></td>
		        <td>
		        <a class="btn btn-sm btn-danger" id="delete_meme" data-id="<?php echo $memeid; ?>" href="javascript:void(0)"><i class="glyphicon glyphicon-trash"></i></a>
		        </td>
		        </tr>
				<?php
				}

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
