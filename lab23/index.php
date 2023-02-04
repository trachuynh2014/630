<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <title>Art Work Database</title>
  <link rel="stylesheet" href="./stylesheets/index.css">
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
</head>

<body>
  <?php
  $servername = "127.0.0.1";
  $username = "root";
  $password = "";
  $dbname = "testnew";
  $conn = mysqli_connect($servername, $username, $password, $dbname);
  if ($_GET['clear'] === 'clear') {
    $del = "DROP TABLES art_work";
    if (!$conn) {
      die("Connection failed: " . mysqli_connect_error());
    }
    if ($conn->query($del) === TRUE) {
      echo "<div class='success'>Dropped all data</div>";
    } else {
      echo "<div class='fail'>Error deleting record</div>"; // display error message if not delete
    }
  } else {
    $genre = $_GET['genre'] ?? NULL;
    $type = $_GET['type'] ?? NULL;
    $spec = $_GET['specification'] ?? NULL;
    $year = $_GET['year'] ?? NULL;
    $muse = $_GET['name'] ?? NULL;

    if (!is_null($genre) && !is_null($type) && !is_null($spec) && !is_null($year) && !is_null($muse)) {
      $sql = "CREATE TABLE IF NOT EXISTS art_work (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        genre VARCHAR(30) NOT NULL,
        typeof VARCHAR(30) NOT NULL,
        specification VARCHAR(50),
        art_year VARCHAR(30),
        artname VARCHAR(30) NOT NULL
    )";

      $format = "INSERT INTO %s (genre,typeof,specification,art_year,artname) VALUES ('%s','%s','%s','%s','%s')";

      $sqlInsert = sprintf($format, "art_work", strval($genre), strval($type), strval($spec), strval($year), strval($muse));
      // Create connection
      $conn = mysqli_connect($servername, $username, $password, $dbname);

      if (!$conn) {
        die("Connection failed: " . mysqli_connect_error()) . "<br/>";
      }
      // Create table if not existed
      if ($conn->query($sql) === TRUE) {
        echo "<div class='success'>Table Student Records created successfully </div>";
      } else {
        echo $conn->error;
      }
      if ($conn->query($sqlInsert) === TRUE) {
        echo "<div class='success'>Added successfuly</div>";
      } else {
        echo "Failed to add<br/>";
      }
    }
    $conn->close();
  }


  ?>
  <h1>Art Work Database</h1>
  <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
    Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure
    dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
    proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>

  <form method="get">
    <label for="genre">Genre</label>
    <select class="genre" name="genre">
      <option value="abstract">Abstract</option>
      <option value="baroque">Baroque</option>
      <option value="gothic">Gothic</option>
      <option value="renaissance">Renaissance</option>
    </select>
    <label for="type">Type</label>
    <select class="type" name="type">
      <optgroup label="Painting">
        <option value="landscape">Landscape</option>
        <option value="portrait">Portrait</option>
      </optgroup>
      <option value="sculpture">Sculpture</option>
    </select>
    <label for="specification">Specification</label>
    <select class="specification" name="specification">
      <option value="commercial">Commercial</option>
      <option value="none-commercial">None-commercial</option>
      <option value="deritive work">Derivitive Work</option>
      <option value="nonne-deritive work">None-Derivitive Work</option>
    </select>
    <label for="year">Year</label>
    <input class="year" type="datetime" name="year" value="">
    <label for="name">Museum</label>
    <input class="muse" type="text" name="name" value="">
    <div class="container">
      <input class="save" type="submit" value="Save Record">
      <input type="submit" name="clear" value="Clear Record">
    </div>
  </form>
  <div class="records">
    <table>
      <thead>
        <th>Genre</th>
        <th>Type</th>
        <th>Specification</th>
        <th>Year</th>
        <th>Museum</th>
        <th></th>
      </thead>
      <tbody>
        <?php if (isset($_GET['submit']))
          unset($artwork);
        ?>
        <tr>
          <td id="genre"></td><td id="type"></td><td id="spec"></td><td id="art_year"></td><td id="artname">"<td>
        </tr>

        <?php
        $servername = "127.0.0.1";
        $username = "root";
        $password = "";
        $dbname = "testnew";
        $conn = mysqli_connect($servername, $username, $password, $dbname);
        $sqldata = "SELECT id,genre,typeof,specification,art_year,artname FROM art_work";
        $result = $conn->query($sqldata);
        if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
            echo "<tr><td>" . $row["genre"] . "</td><td>" . $row["typeof"] . "</td><td>" . $row["specification"] . "</td><td>" . $row["art_year"] . "</td><td>" . $row["artname"] . "<td><a href='delete.php?id=" . $row['id'] . "'>Delete</a></td></tr>";
          }
        } else {
          echo "0 results";
        }
        $conn->close();
        ?>
      </tbody>
    </table>
  </div>

  <script type="text/javascript">
    class handleEvents{
        constructor(){
          this.selections = [$(".genre"), $(".type"), $('.specification')];
          this.fields = [$('.year'), $('.muse')];
          this.tds = [$('#genre'), $('#type'), $('#spec'), $("#art_year"), $("#artname")];
        }
        update_selections(){
          for (var select = 0; select < this.selections.length; select++) {
              this.selections[select].click(()=>{
                this.update_table(this.selections);
              });
              this.selections[select].change(()=>{
                this.update_table(this.selections);
              });
          }
        }

        update_fields(){
          for (var i = 0; i < this.fields.length; i++) {
            this.fields[i].change(()=>{
              this.update_table(this.fields);
            });
            this.fields[i].click(()=>{
              this.update_table(this.fields);
            });
            this.fields[i].on('input', ()=>{
              this.update_table(this.fields);
            });
          }
        }

        update_table(array){
          if (array === this.selections) {
            for (var i = 0; i < 3; i++) {
              this.tds[i].html(array[i].val())
            }
          }else{
            for (var i = 0; i < 3; i++) {
              this.tds[i].html(this.selections[i].val())
            }
            for (var i = 3; i < this.tds.length; i++) {
              this.tds[i].html(array[i-3].val())
            }
          }
        }

        update_all(){
          this.update_selections ();
          this.update_fields();
        }

    }

    let events = new handleEvents();
    events.update_all();


    $('.save').click(() => {
      var genre = $('.genre').val();
      var type = $('.type').val();
      var spec = $('.specification').val();
      var year = $('.year').val();
      var muse = $('.muse').val();
    });

    $('div.success').fadeOut(3500)
    $('div.fail').fadeOut(5500)
    function createCookie(name, value, days) {
      var expires;
      if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        expires = "; expires=" + date.toGMTString();
      } else {
        expires = "";
      }
      document.cookie = escape(name) + "=" + escape(value) + expires + "; path=/";
    }
  </script>
</body>

</html>