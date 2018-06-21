<input type="hidden" id="postonpage" value="14,13,12,11,10,9,8" />

<script>
var el = document.getElementById('postonpage');

var url = 'getComents.php?ids='+el;



</script>


<?php

if (isset($_GET['ids'])){
$temp = $_GET['ids'];
$ids = explode(',', $temp);

for ($i = 0; $i < count($ids); $i++) {

echo 'SELECT count(*) from comments where postid = '.$ids[$i];
echo '<br>';
}


}
