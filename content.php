    <?php
    $db_conn = new mysqli('localhost', 'root', 'root', 'movieCol');

    if($_GET) {
      $col = $_GET['c'];
      $filter = strtolower($_GET['q']);
      $q = "SELECT * FROM movie_collection where lcase($col) like '%$filter%' order by title";
    } else {
      $q = "SELECT * FROM movie_collection order by title";
    }
    $r = $db_conn->query($q);
    $uniqTitles = array();
    $numMovies = mysqli_num_rows($r);

    $counter = 1;

    while ($counter < 4) {

        $row = $r ->fetch_object();
        $num = strval($counter);
        $imdb = $row->imdb;

        if($row->poster == "N/A") {
          $picLink = '<img src="http://entertainment.ie/movie_trailers/trailers/flash/posterPlaceholder.jpg">';
        } else {
          $picLink = $row->poster;
        }

        echo '<div id="movie'.$num.'">';
        echo '<h2>'.$row->title.'</h2><br />';
        echo '<img alt="" title="'.$row->title.'" src='.$picLink.'" width="180px" class="movie" /><br />';

        echo '<a class="video" title="'.$row->title.'" href="http://www.youtube.com/v/'.$row->youtube.'?fs=1&amp;autoplay=1">trailer</a>';
        echo ', <a target="_blank" href="http://www.imdb.com/title/'.$row->imdb.'">imdb</a></p>';
        echo '<form action="insert.php" method="post" name="movie'.$num.'">';
        echo '<input type="radio" name="rating" value=1 onclick="selected(\'up\', \''.$num.'\')" /> Up<br />';
        echo '<input type="radio" name="rating" value=-1 onclick="selected(\'down\', \''.$num.'\')" /> Down<br />';
        echo '<input type="radio" name="rating" value=0 onclick="selected(\'unseen\', \''.$num.'\')" /> Haven\'t seen<br />';
        echo '<input type=submit name="imdb" value="'.$imdb.'" /></form></div>';

        $counter++;
    }

