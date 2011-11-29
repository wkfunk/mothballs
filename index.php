<!doctype html>
<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->
<!--[if lt IE 7 ]>  <html class="no-js ie6" lang="en"> <![endif] -->
<!--[if IE 7 ]>     <html class="no-js ie7" lang="en"> <![endif] -->
<!--[if IE 8 ]> <html class="no-js ie6" lang="en"> <![endif] -->
<!--[if (gte IE 9)|!(IE)]><!--> <html class="no-js" lang="en"> <!--<![endif] -->
<head>
  <meta charset="ISO-8859-1">

  <meta name="description" content="movie collection">
  <meta name="author" content="bb">

  <title>movie collection</title>

  <link rel="stylesheet" href="style.css">
  <!--<link rel="stylesheet" href="lightboxstyle.css">-->

  <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"></script>

  <script type="text/javascript" src="fancybox/jquery.fancybox-1.3.4.pack.js"></script>
  <link rel="stylesheet" type="text/css" href="fancybox/jquery.fancybox-1.3.4.css" media="screen" />
  <script type="text/javascript" src="fancybox/video.js"></script>

</head>

<body>
  <ul>
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
    echo '<h1>'.$numMovies . ' titles in Movie Collection';
    if($_GET) {
      echo '<br><span class="smaller"> for /'.$col.'/ = %'.$filter.'% -- <a style="color: #ccc; " href="index.php">view all</a> --</span>';
    }
    echo '</h1>';

    if(mysqli_num_rows($r)) {
      $counter = 0;

      while($row = $r ->fetch_object()){
        if(in_array($row->title, $uniqTitles)) {
          continue;
        }

        array_push($uniqTitles, $row->title);

        if($counter % 3 == 0) {
          echo '<li class="clear">';
        } else {
          echo '<li>';
        }
        echo '<h2>'.$row->title.'</h2>';

        echo '<div class="genreWrapper">';
        echo '<p>';

        $genres = explode(', ',$row->genre);
        $genresOut = '';
        foreach ($genres as $g) {
          $genresOut .= '<a href="index.php?c=genre&q=' .$g.'">'.$g.'</a>, ';
        }
        echo substr($genresOut, 0, -2);

        echo '</div>';

        echo '<div class="poster">';
        if($row->poster == "N/A") {
          echo '<img src="http://entertainment.ie/movie_trailers/trailers/flash/posterPlaceholder.jpg">';
        } else {
          echo '<img src="'.$row->poster.'">';
        }
        echo '</div>';

        echo '<div class="castWrappper">';
        echo '<h3>Cast</h3>';
        echo '<p>Director: ';

        $directors = explode(', ',$row->director);
        $directorsOut = '';
        foreach ($directors as $d) {
          $directorsOut .= '<a href="index.php?c=director&q=' .$d.'">'.$d.'</a>, ';
        }
        echo substr($directorsOut, 0, -2);

        echo '<br>Writer: ';

        $writers = explode(', ',$row->writer);
        $writersOut = '';
        foreach ($writers as $w) {
          $writersOut .= '<a href="index.php?c=writer&q=' .$w.'">'.$w.'</a>, ';
        }
        echo substr($writersOut, 0, -2);

        echo '<br>Actors: ';

        $actors = explode(', ',$row->actors);
        $actorsOut = '';
        foreach ($actors as $a) {
          $actorsOut .= '<a href="index.php?c=actor&q=' .$a.'">'.$a.'</a>, ';
        }
        echo substr($actorsOut, 0, -2);

        echo '</div>';

        echo '<div class="plotWrapper">';
        echo '<h3>Plot</h3>';
        echo '<p>'.$row->plot.'</p>';
        echo '</div>';

        echo '<div class="specWrapper">';
        echo '<h3>Specs</h3>';
        echo '<p>Year: <a href="index.php?c=year&q='.$row->year.'">'.$row->year.'</a>';
        echo ', runtime: '.$row->runtime;
        echo ', rating: '.$row->rating;
        echo ', votes: '.$row->votes;
        $titleEncodedForSharemovies = str_replace(' ', '%20', $row->title) . '('.$row->year.')';
        echo ', <a class="video" title="'.$row->title.'" href="http://www.youtube.com/v/'.$row->youtube.'?fs=1&amp;autoplay=1"'.'">trailer</a>';
        echo ', <a target="_blank" href="http://www.imdb.com/title'.$row->imdb.'">imdb</a></p>';
        echo '</div>';

        $counter++;

      }
    } else {
      echo "User not found";
    }

    ?>

  </ul>

</body> 
