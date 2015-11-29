    <?php
    mysql_connect('localhost', 'root', 'root') or die(mysql_error());
    mysql_select_db('movieCol') or die(mysql_error());

    $upMovs = "SELECT * , user_ratings.rating AS userRating
      FROM movie_collection, user_ratings
      WHERE (
        movie_collection.imdb = user_ratings.imdbid
        AND user_ratings.rating =  '1'
      )
      ORDER BY user_ratings.rating DESC ";
    $downMovs = "SELECT * , user_ratings.rating AS userRating
      FROM movie_collection, user_ratings
      WHERE (
        movie_collection.imdb = user_ratings.imdbid
        AND user_ratings.rating =  '-1'
      )
      ORDER BY user_ratings.rating DESC ";
    $unseenMovs = "SELECT * , user_ratings.rating AS userRating
      FROM movie_collection, user_ratings
      WHERE (
        movie_collection.imdb = user_ratings.imdbid
        AND user_ratings.rating =  '0'
      )
      ORDER BY user_ratings.rating DESC ";

    $resultUp = mysql_query($upMovs) or die(mysql_error());
    $resultDown = mysql_query($downMovs) or die(mysql_error());
    $resultUnseen = mysql_query($unseenMovs) or die(mysql_error());
    
    //upvoted stuff
    if(mysql_num_rows($resultUp)) { 
      $counter = 0;
      echo '<br /><h1>stuff i like</h1><table align="center" border="1" style="background-color:green">';
      while($row = mysql_fetch_array($resultUp)) {
        if($counter%3 == 0) {
          echo '<tr>';
        }
        echo '<td><img src="'.$row['poster'].'" alt="'.$row['title'].'" width="180px" /><br /><h2>'.$row['title'].'</h2></td>';
        if($counter%3 == 2 || $counter==(mysql_num_rows($resultUp)-1)) {
          echo '</tr>'; 
        }
        $counter++;
      }
      echo '</table><br />';
    }

    //downvoted stuff
    if(mysql_num_rows($resultDown)) { 
      $counter = 0;
      echo '<br /><h1>stuff i <em>don\'t</em> like</h1><table align="center" border="1" style="background-color:red">';
      while($row = mysql_fetch_array($resultDown)) {
        if($counter%3 == 0) {
          echo '<tr>';
        }
        echo '<td><img src="'.$row['poster'].'" alt="'.$row['title'].'" width="180px" /><br /><h2>'.$row['title'].'</h2></td>';
        if($counter%3 == 2 || $counter==(mysql_num_rows($resultDown)-1)) {
          echo '</tr>'; 
        }
        $counter++;
      }
      echo '</table><br />';
    }
    
    //unvoted stuff
    if(mysql_num_rows($resultUnseen)) { 
      $counter = 0;
      echo '<br /><h1>stuff i haven\'t seen</h1><ul>';
      while($row = mysql_fetch_array($resultUnseen)) {
        echo '<li><strong>'.$row['title'].' </strong>(wait! i\'ve seen this! <a href="upvote">it\'s good :]</a> <a href="downvote">not for me :/</a></li>';
        if($counter==(mysql_num_rows($resultUnseen)-1)) {
          echo '</ul>'; 
        }
        $counter++;
      }
      echo '</table><br />';
    }
    ?>
