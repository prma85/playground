<?php
require_once 'db.php';
$db = new db();
$result = $db->execute('show TABLES', 'select');
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Excel/CSV Analysis</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <div>
            <h2>Select a excel/csv file to start the analysis</h2>
            <p>The system only works with CSV files. You can open your excel file and go to "File --> Save as" and select the CSV dformat.</p>
            <form action="process.php" method="post" enctype="multipart/form-data">
                <label> Select a file <br />
                    <input type="file" name="file" />
                </label>
                <br />
                <label> Inform the table name <br />
                    <input name="table_name" type="text" />
                </label>
                <input type="submit" name="submit" value="upload"/>
            </form>
            <form action="process.php" method="post" enctype="multipart/form-data">
                <h3> Or select a existent database </h3>
                <select name="table">
                    <option value="">Select an option</option>
                    <?php
                    foreach ($result as $r) {
                        echo '<option value="' . $r['Tables_in_excel'] . '">' . $r['Tables_in_excel'] . '</option>';
                    }
                    ?>
                </select>
                <input type="submit" name="submit" value="start"/>
            </form>
        </div>
    </body>
</html>
