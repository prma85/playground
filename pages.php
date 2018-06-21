<?php
session_start();

$_SESSION['userID'] = 2;
$_SESSION['page'] = array();

$_SESSION['page']['max'] = 4;
$_SESSION['page'][1] = 10;
$_SESSION['page'][2] = 20;
$_SESSION['page'][3] = 30;
$_SESSION['page'][4] = 33;
$_SESSION['page']['active'] = 1;

$prev = $_SESSION['page']['active'] - 1;
if ($prev == 0) {
  $prev = $_SESSION['page']['active'];
}

$next = $_SESSION['page']['active'] + 1;
if ($next > $_SESSION['page']['max']) {
  $next = $_SESSION['page']['active'];
}

if (isset ($_GET['page'])){
  $_SESSION['page']['active'] = (int)$_GET['page'];
}

$active = $_SESSION['page']['active'];
$end = $_SESSION['page'][$active];
$start = $end - 9;

if ($active == $_SESSION['page']['max']) {
  $start = $_SESSION['page'][$active-1]+1;
}

echo 'SELECT * FROM posts where user_id = '.$_SESSION['userID'].' LIMIT '.$start.', '.$end;

?>
<html>
<body>
<style>
a {
  text-decoration: none;
}
.active {
  font-weight: bold;
  text-decoration: underline;
}
</style>
<div>
  <a href='?page=1'>First Page</a>
  <a href='?page=<?php echo $prev;?>'>Back</a>
<?php

for ($i = 1; $i <= $_SESSION['page']['max']; $i++){
 $class = '';

if ($i == $_SESSION['page']['active']) {
  $class = 'active';
}

 echo '<a class="'.$class.'" href="?page='.$i.'"> '.$i.' </a>';

}


?>
<a href='?page=<?php echo $next;?>'>Next</a>
<a href='?page=<?php echo $_SESSION['page']['max']; ?>'>Last Page</a>
</div>

</body>
</html>
