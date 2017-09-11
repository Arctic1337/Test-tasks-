<?php
function PageByNumber($result, $pageNumber) {
  for ($i=0; $i < 5 ; $i++) {
    global $MyTitle, $MyAnnounce, $MyDate, $MyId, $MyContent;
    if (!is_object($result)) {
        return NULL;
    }
    $result->data_seek($i+($pageNumber)*5-5);
    $row = $result->fetch_array(MYSQLI_ASSOC);
    $MyTitle[$i] = $row['title'];
    $MyAnnounce[$i] = $row['announce'];
    $MyId[$i] = $row['id'];
    $MyDate[$i] = date('d.m.Y', $row['idate']);
  }
}
function NewsById($result, $id) {
  for ($i=0; $i < 5 ; $i++) {
    global $MyTitle, $MyContent;
    if (!is_object($result)) {
        return NULL;
    }
    $result->data_seek($_GET["id"] - 1);
    $row = $result->fetch_array(MYSQLI_ASSOC);
    $MyTitle = $row['title'];
    $MyContent= $row['content'];
  }
}
require_once 'login.php';
$conn = new mysqli ($hn, $un, $pw, $db);
if ($conn->connect_error) die($conn->connect_error);
$conn->query('SET NAMES utf8');
$query = "SELECT * FROM news ORDER BY idate DESC";
$result = $conn->query($query);
if (!$result) die ($conn->error);
$NumberOfRows = $result->num_rows;
$NumberOfRef = ceil($NumberOfRows/5);
$CreateListItems = "";
$MyTitle= array();
$MyAnnounce= array();
$MyDate= array();
$MyId = array();
$MyContent;
if (!empty($_GET["n"])) {
  PageByNumber($result, $_GET["n"]);
  for ($i=2; $i < $NumberOfRef+1; $i++) {
    $CreateListItems .= "<li><a href='forTask2.php?n=" . $i . "'>" . $i . "</a></li>\n";
  }
echo <<<_END
        <!DOCTYPE html>
        <html lang="ru">
          <head>
            <meta charset="utf-8">
            <title>The Task</title>
            <link rel="stylesheet" href="style.css">
          </head>
          <body>
          <div class="container">
            <header>
              <h1>Новости</h1>
            </header>
            <main>
              <div>
                <div class="date-and-announce">
                  <span>$MyDate[0]</span>
                  <a href="forTask2.php?id=$MyId[0]">$MyTitle[0]</a>
                </div>
                <p>$MyAnnounce[0]</p>
              </div>
              <div>
                <div class="date-and-announce">
                  <span>$MyDate[1]</span>
                  <a href="forTask2.php?id=$MyId[1]">$MyTitle[1]</a>
                </div>
                <p>$MyAnnounce[1]</p>
              </div>
              <div>
                <div class="date-and-announce">
                  <span>$MyDate[2]</span>
                  <a href="forTask2.php?id=$MyId[2]">$MyTitle[2]</a>
                </div>
                <p>$MyAnnounce[2]</p>
              </div>
              <div>
                <div class="date-and-announce">
                  <span>$MyDate[3]</span>
                  <a href="forTask2.php?id=$MyId[3]">$MyTitle[3]</a>
                </div>
                <p>$MyAnnounce[3]</p>
              </div>
              <div>
                <div class="date-and-announce">
                  <span>$MyDate[4]</span>
                  <a href="forTask2.php?id=$MyId[4]">$MyTitle[4]</a>
                </div>
                <p>$MyAnnounce[4]</p>
              </div>
            </main>
            <footer>
              <h2>Страницы:</h2>
              <ul id="selectBackground">
                <li><a href="forTask2.php">1</a></li>
                $CreateListItems
              </ul>
            </footer>
            </div>
          </body>
        </html>
_END;
}
elseif (!empty($_GET["id"])) {
  NewsById($result, $_GET["id"]);
echo <<<_END
    <!DOCTYPE html>
    <html lang="ru">
      <head>
        <meta charset="utf-8">
        <title>The Task</title>
        <link rel="stylesheet" href="style.css">
      </head>
      <body>
      <div class="container">
        <header>
          <h1>$MyTitle</h1>
        </header>
        <main>
          $MyContent
        </main>
        <footer>
          <a href="forTask2.php">Все новости >></a>
        </footer>
      </div>
      </body>
    </html>
_END;
}
elseif(empty($_GET["n"]) || empty($_GET["id"])){
  for ($i=0; $i < 5; $i++) {
    $result->data_seek($i);
    $row = $result->fetch_array(MYSQLI_ASSOC);
    $MyTitle[$i] = $row['title'];
    $MyAnnounce[$i] = $row['announce'];
    $MyDate[$i] = $row['idate'];
    $MyDate[$i] = date('d.m.Y', $row['idate']);
    $MyId[$i] = $row['id'];
  }
  for ($i=2; $i < $NumberOfRef+1; $i++) {
    $CreateListItems .= "<li><a href='forTask2.php?n=" . $i . "'>" . $i . "</a></li>\n";
  }
echo <<<_END
          <!DOCTYPE html>
          <html lang="ru">
            <head>
              <meta charset="utf-8">
              <title>The Task</title>
              <link rel="stylesheet" href="style.css">
            </head>
            <body>
            <div class="container">
              <header>
                <h1>Новости</h1>
              </header>
              <main>
                <div>
                  <div class="date-and-announce">
                    <span>$MyDate[0]</span>
                    <a href="forTask2.php?id=$MyId[0]">$MyTitle[0]</a>
                  </div>
                  <p>$MyAnnounce[0]</p>
                </div>
                <div>
                  <div class="date-and-announce">
                    <span>$MyDate[1]</span>
                    <a href="forTask2.php?id=$MyId[1]">$MyTitle[1]</a>
                  </div>
                  <p>$MyAnnounce[1]</p>
                </div>
                <div>
                  <div class="date-and-announce">
                    <span>$MyDate[2]</span>
                    <a href="forTask2.php?id=$MyId[2]">$MyTitle[2]</a>
                  </div>
                  <p>$MyAnnounce[2]</p>
                </div>
                <div>
                  <div class="date-and-announce">
                    <span>$MyDate[3]</span>
                    <a href="forTask2.php?id=$MyId[3]">$MyTitle[3]</a>
                  </div>
                  <p>$MyAnnounce[3]</p>
                </div>
                <div>
                  <div class="date-and-announce">
                    <span>$MyDate[4]</span>
                    <a href="forTask2.php?id=$MyId[4]">$MyTitle[4]</a>
                  </div>
                  <p>$MyAnnounce[4]</p>
                </div>
              </main>
              <footer>
                <h2>Страницы:</h2>
                <ul id="selectBackground">
                  <li><a href="forTask2.php">1</a></li>
                  $CreateListItems
                </ul>
              </footer>
              </div>
            </body>
          </html>
_END;
}
?>
