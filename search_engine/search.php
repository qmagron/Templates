<?php
if(isset($_GET['q']) && !empty($_GET['q'])) {
  if(!isset($_GET['p']) || empty($_GET['p']) || $_GET['p'] < 1) {
    // Add 'p' URI parameter
    header("Location: " . $_SERVER['REQUEST_URI'] . "&p=1");
  }
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>"<?= htmlspecialchars($_GET['q']) ?>"</title>
    <link rel="stylesheet" type="text/css" href="@resources/style.css" />
    <script src="@resources/script.js"></script>
  </head>
  <body>
    <h1>Search results for "<?= htmlspecialchars($_GET['q']) ?>"</h1>
    <ul id="results">
<?php include('update.php'); ?>
    </ul>
    <a id="prev" href="<?= preg_replace("/p=\d+/", "p=" . ($_GET['p']-1), $_SERVER['REQUEST_URI']) ?>" style="<?php if($_GET['p'] == 1) echo "visibility: hidden"; ?>"></a>
    <a id="next" href="<?= preg_replace("/p=\d+/", "p=" . ($_GET['p']+1), $_SERVER['REQUEST_URI']) ?>" style="<?php if($query->rowCount() != $nbres+1) echo "visibility: hidden"; ?>"></a>
    <script>
      window.addEventListener("load", function() {
        document.getElementById("prev").removeAttribute("href");
        document.getElementById("next").removeAttribute("href");
        updateButtons(<?= htmlspecialchars($_GET['p']) ?>);
      }, false);
      window.addEventListener("popstate", function(event) {
        var url = new URL(window.location);
        getPage(url.searchParams.get("p"), false);
      }, false);
      document.getElementById("prev").addEventListener("click", requestPrev, false);
      document.getElementById("next").addEventListener("click", requestNext, false);
    </script>
  </body>
</html>
<?php
} else {
  header($_SERVER['SERVER_PROTOCOL'] . " 400 Bad Request");
}
?>
