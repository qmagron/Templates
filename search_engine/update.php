<?php
$nbres = 10;

if(!isset($_POST['q'])) $_POST['q'] = $_GET['q'];
if(!isset($_POST['p'])) $_POST['p'] = $_GET['p'];
$_POST['q'] = preg_replace("/[^\w\-*+ Ü-ü]/", "", $_POST['q']);
$_POST['q'] = preg_replace("/([\-*+])+/", "$1", $_POST['q']);
$_POST['q'] = preg_replace("/^[\-+\s]+|[\-+\s]+$/", "", $_POST['q']);

$pdo = new pdo('mysql:host=localhost;dbname=templates;charset=utf8', 'user', 'pass');
$query = $pdo->prepare('
  SELECT date, url, title, teaser,
  MATCH(title) AGAINST(:keywords IN BOOLEAN MODE) as score
  FROM search_engine
  WHERE MATCH(title) AGAINST(:keywords IN BOOLEAN MODE)
  ORDER BY score DESC, LENGTH(title), date DESC
  LIMIT ' . $nbres * ($_POST['p']-1) . ', ' . ($nbres+1) . '
');
$query->execute(array('keywords' => $_POST['q']));

$n = 0;
while($res = $query->fetch()) {
  if($n != $nbres) {
?>
<li>
  <a href="<?= htmlspecialchars($res['url']) ?>">
    <h2><?= htmlspecialchars($res['title']) ?></h2>
    <div id="date"><?= htmlspecialchars($res['date']) ?></div>
    <p><?= htmlspecialchars($res['teaser']) ?></p>
  </a>
</li>
<?php
  } else {
?>
<li id="notLast" style="display: none"></li>
<?php
  }
  $n++;
}
if(!$n) {
  echo "No result\n";
}

$query->closecursor();
?>
