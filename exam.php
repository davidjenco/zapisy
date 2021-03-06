<?php
require "config.php";
if(!isset($_GET["id"])) header("Location: /");
$db = new PDO(
  "mysql:host=" . Config::$db_host . ";dbname=" . Config::$db_name,
  Config::$db_user, Config::$db_pass
);
$query = $db->prepare("SELECT * FROM exams WHERE _ID = ?");
$query->execute(array($_GET["id"]));
$exam = $query->fetchAll()[0];

$query = $db->prepare("SELECT exam_files.name, exam_files.type, exam_files.data, authors.name AS author_name" .
  " FROM exam_files LEFT JOIN authors ON exam_files.author_ID = authors.author_ID WHERE exam_files.exam_ID = ?");
$query->execute(array($_GET["id"]));
$files = $query->fetchAll();

echo "<!DOCTYPE html>\n<html>\n<head>\n<meta charset=\"UTF-8\">";
echo "<link rel=\"shortcut icon\" href=\"img/ikona.ico\"/>";
echo "<link rel=\"apple-touch-icon\" href=\"img/zapisy-512px.png\"/>";
echo "<link rel=\"icon\" type=\"image/png\" href=\"img/zapisy-512px.png\"/>";
echo "<meta name=\"viewport\" content=\"width=device-width, user-scalable=no\"/>";
echo "<meta name=\"author\" content=\"github.com/jelinekp/zapisy\">";
echo "<link href=\"https://fonts.googleapis.com/icon?family=Roboto\" rel=\"stylesheet\">";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"common.css\"/>";
echo "<link rel=\"stylesheet\" media=\"(min-width: 731px)\" type=\"text/css\" href=\"style.css\"/>";
echo "<link rel=\"stylesheet\" media=\"(max-width: 730px)\" type=\"text/css\" href=\"mobile.css\"/>";
echo "<title>Zápisy</title></head>";
echo "<body>";
echo "<div id=\"container\">";
echo "<h1>" . $exam["subject"] . "</h1>";
echo "<b>" . $exam["range"] . "</b><br/>";
echo date("j.n.Y", strtotime($exam["exam_date"])) . "<br/>";
echo $exam["notes"];
echo "<table>";
foreach($files as $file) {
  echo "<tr><td>";
  echo "<a href=\"" . $file["data"] . "\" class=\"file-link\">";
  echo "<div class=\"file-link-container\">";
  echo "<div class=\"file-icon file-icon-" . $file["type"] . "\"></div>";
  echo "<span class=\"file-name\">" . $file["name"] . "</span>";
  echo "<span class=\"file-author\">" . $file["author_name"] . "</span>";
  echo "</div></a>";
  echo "</td></tr>";
}
echo "</table>";
echo "<br><br><br><span style=\"text-align: center; width: 100%; display: block;\">© 2016</span>";
echo "</div>";
echo "</body>";
echo "</html>";
?>
