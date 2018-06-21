<?php
require_once './db.php';

$db = new db();
$db->conn = $_SESSION["conn"];
$table = $_SESSION["table"];

$fields = $db->select("SHOW FULL COLUMNS FROM " . $table);
array_shift($fields);

$total = (int) $db->select("SELECT COUNT(*) as count FROM " . $table)[0]["count"];


$value = 0;
if (isset($_POST["size"])) {
    $value = $_POST["size"];
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Excel/CSV Analysis - Results</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="excel.js" type="text/javascript"></script>
        <style type="text/css">
            .tg  {border-collapse:collapse;border-spacing:0;border-color:#ccc;}
            .tg td{font-family:Arial, sans-serif;font-size:14px;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:black;}
            .tg th{font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:black;}
            .tg .tg-td2{text-align:center;vertical-align:top}
            .tg .tg-merged{font-weight:bold;vertical-align:middle}
            .tg .tg-top{font-weight:bold;text-align:center;vertical-align:top}
            .tg .tg-td1{vertical-align:top}
        </style>
    </head>
    <body>
        <div>
            <h2>initial steps for the analysis</h2>
            <form method="post" action="results.php" name="initial">
                <label>Select the main field for the analysis
                    <select name="filter" id="filter">
                        <option value="">Select an option</option>
                        <?php
                        foreach ($fields as $f) {
                            $selected = "";
                            if (isset($_POST['filter']) && $_POST['filter'] == $f['Field']) {
                                $selected = 'selected';
                            }
                            echo '<option value="' . $f['Field'] . '" ' . $selected . '>' . $f['Comment'] . '</option>';
                        }
                        ?>
                    </select>
                </label>
                <br />
                <label> how many fields do you want to compare?
                    <input type="number" name="size" id="size" value="<?php echo $value; ?>" />
                </label>
                <input type="submit" name="submit" value="start"/>
            </form>

            <br clear="all" />
            <hr />


            <?php
            if (isset($_POST['filter'])) {
                $r0 = $db->select("SELECT distinct(`" . $_POST['filter'] . "`) value FROM survey");
                $sqlR1 = "SELECT `" . $_POST['filter'] . "` value, COUNT(*) count FROM survey GROUP BY `" . $_POST['filter'] . "`";
                $r1 = $db->select($sqlR1);
                //echo $sqlR1;

                $mainTable = array();
                //get all possible values and put the count as 0
                foreach ($r0 as $r) {
                    $mainTable[$r["value"]] = 0;
                }

                //get all the found values
                foreach ($r1 as $c) {
                    $mainTable[$c["value"]] = (int) $c["count"];
                }

                echo "<table class='tg'>"
                . "<tr><th class='tg-top'>Metric</th><th class='tg-top'>Value</th><th class='tg-top'>% of Total</th></th>";

                // fill the main table

                foreach ($mainTable as $k => $row) {
                    echo "<tr>";
                    echo "<td class='tg-td1'>" . $k . "</d>";
                    echo "<td class='tg-td1'>" . $row . "</d>";
                    $percent = number_format(($row / $total) * 100, 2);
                    echo "<td class='tg-td1'>" . $percent . "%</d>";
                    echo "</tr>";
                }
                echo "</table>";
                ?>

            <?php } ?>
            <br clear="all" />
            <hr />

            <?php if ((int) $value > 0) { ?>

                <h2>Now, select what fields do you want to compare</h2>
                <form id="compare" name="compare" method="post" action="results.php">
                    <input type="hidden" name="filter" value="<?php echo $_POST['filter']; ?>" />
                    <input type="hidden" name="size" value="<?php echo $value; ?>" />
                    <input type="hidden" name="task" value="analysis" />

                    <?php
                    $allOptions = "";
                    foreach ($fields as $f) {
                        $allOptions .= '<option value="' . $f['Field'] . '">' . $f['Comment'] . '</option>';
                    }
                    for ($i = 1; $i <= $value; $i++) {
                        echo '<label>Filter ' . $i . ' to compare<select name="compare' . $i . '" id="compare' . $i . '">';
                        echo '<option value="">Select the filter ' . $i . '</option>';
                        //echo $allOptions;
                        foreach ($fields as $f) {
                            $selected = "";
                            if (isset($_POST['compare' . $i . '']) && $_POST['compare' . $i . ''] == $f['Field']) {
                                $selected = 'selected';
                            }
                            echo '<option value="' . $f['Field'] . '" ' . $selected . '>' . $f['Comment'] . '</option>';
                        }
                        echo '</select></label><br />';
                        $valueIpt = "";
                        if (isset($_POST['compare_query' . $i . ''])) {
                            $valueIpt = $_POST['compare_query' . $i . ''];
                        }
                        echo '<label>Want to look for a specific word? <input type="text" value="' . $valueIpt . '" name="compare_query' . $i . '" /></label><br />';

                        $checkedIpt = "";
                        if (isset($_POST['compare_query_group' . $i . '']) && $_POST['compare_query_group' . $i . ''] == "on") {
                            $checkedIpt = "checked";
                        }
                        echo '<label>Want to group the data? <input type="checkbox" ' . $checkedIpt . ' name="compare_query_group' . $i . '" /></label><br /><br />';
                    }
                    //var_dump($_POST);
                    ?>

                    <input type="submit" name="submit" value="Generate"/>
                </form>

                <br clear="all" />
                <hr />

                <?php
            }
            if (isset($_POST["task"])) {
                echo '<h3>' . $_POST['filter'] . '</h3>';
                echo '<table class="tg">';
                echo '<tr>';
                echo '<th class="tg-merged" rowspan="2">Items</th>';
                echo '<th class="tg-merged" rowspan="2">Value</th>';
                echo '<th class="tg-merged" rowspan="2">% of Total</th>';
                $allItems = array();

                for ($j = 1; $j <= $value; $j++) {
                    if (filter_input(INPUT_POST, "compare_query_group" . $j) && filter_input(INPUT_POST, "compare_query_group" . $j) == "on") {
                        $answers = array(0 => array('val' => filter_input(INPUT_POST, "compare_query" . $j)));
                    } else {
                        $sql = "SELECT DISTINCT(`" . filter_input(INPUT_POST, "compare" . $j) . "`) as val FROM " . $table;
                        if (filter_input(INPUT_POST, "compare_query" . $j)) {
                            $sql .= ' where ' . filter_input(INPUT_POST, "compare" . $j) . ' like "%' . filter_input(INPUT_POST, "compare_query" . $j) . '%"';
                        }
                        //echo $sql;
                        $answers = $db->select($sql);
                    }
                    $totalAnswers = count($answers);
                    //var_dump($answers);
                    echo '<th class="tg-top" colspan="' . $totalAnswers . '">' . filter_input(INPUT_POST, "compare" . $j) . '</th>';
                    $allItems[$j] = $answers;
                }

                echo '<tr>';
                foreach ($allItems as $item) {
                    foreach ($item as $i) {
                        echo '<td class="tg-top">' . $i["val"] . '</td>';
                    }
                }
                echo '</tr>';

                //var_dump($allItems); die;

                foreach ($mainTable as $k => $row) {
                    echo "<tr>";
                    echo "<td class='tg-td1'>" . $k . "</d>";
                    echo "<td class='tg-td1'>" . $row . "</d>";
                    $percent = number_format(($row / $total) * 100, 2);
                    echo "<td class='tg-td1'>" . $percent . "%</d>";

                    //SELECT challenging_projects_in_2016 as value, COUNT(*) count FROM survey where failure_projects_in_2016 = "None" GROUP BY challenging_projects_in_2016
                    //SELECT COUNT(*) count FROM survey where failure_projects_in_2016 = "None" and challenging_projects_in_2016 = "None"
                    for ($l = 1; $l <= $value; $l++) {
                        foreach ($allItems[$l] as $a) {
                            $tempSQL = 'SELECT COUNT(*) count FROM ' . $table . ' where `' . filter_input(INPUT_POST, "compare" . $l) . '` like "%' . $a["val"] . '%" and `' . $_POST['filter'] . '` = "' . $k . '"';
                            //echo $tempSQL; 
                            $tempResult = $db->select($tempSQL);
                            //var_dump($tempResult);
                            $tempValue = (int) $tempResult[0]['count'];
                            //var_dump($tempValue);
                            //die;
                            $tempPercent = number_format(($tempValue / $row) * 100, 2);

                            echo "<td class='tg-td1'>" . $tempPercent . "%</d>";
                        }
                    }
                    echo "</tr>";
                }

                echo '</table>';
                ?>

            <?php } ?>
        </div>

    </body>
</html>


