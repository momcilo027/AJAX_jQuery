<?php

include("db_include.php");
doDB();

$get_topics_sql = "SELECT topic_id, topic_title, DATE_FORMAT(topic_create_time, '%b %e %Y at %r') AS fmt_topic_create_time, topic_owner FROM forum_topics ORDER BY topic_create_time DESC";
$get_topics_res = mysqli_query($mysqli, $get_topics_sql) or die(mysqli_error($mysqli));

if(mysqli_num_rows($get_topics_res) < 1){
  $display_block = "<p><em>No topics exist.</em></p>";
}else{
  $display_block <<<END_OF_TEXT
  <table id="myTable">
  <tr>
  <th><a href="javascirpt:sortTable(myTable,0,0);">TOPIC TITLE</a></th>
  <th><a href="javascript:sortTable(myTable,1,0);"># of POSTS</a></th>
  </tr>
  END_OF_TEXT;

  while($topic_info = mysqli_fetch_array($get_topics_res)){
    $topic_id = $topic_info['topic_id'];
    $topic_title = stripslashes($topic_info['topic_title']);
    $topic_create_time = $topic_info['fmt_topic_create_time'];
    $topic_owner = stripslashes($topic_info['topic_owner']);

    $get_num_posts_sql = "SELECT COUNT(post_id) AS post_count FROM forum_posts WHERE topic_id = '".$topic_id."'";
    $get_num_posts_res = mysqli_query($mysqli, $get_num_posts_sql) or die(mysqli_error($mysqli));

    while($posts_info = mysqli_fetch_array($get_num_posts_res)){
      $num_posts = $posts_info['post_count'];
    }

    $display_block .= <<<END_OF_TEXT
    <tr>
    <td><a hred="showtopic.php?topic_id=$topic_id">
    <strong>$topic_title</strong></a><br/>
    Created on $topic_create_time by $topic_owner</td>
    <td class="num_posts_col">$num_posts</td>
    </tr>
    END_OF_TEXT;
  }

  mysqli_free_result($get_topics_res);
  mysqli_free_result($get_num_posts_res);

  mysqli_close($mysqli);
  $display_block .= "</table>";
}

 ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Topics in My Forum</title>
    <style type="text/css">
      table{
        border: 1px solid black;
        border-collapse: collapse;
      }
      th{
        border: 1px solid black;
        padding: 6px;
        font-weight: bold;
        background: #ccc;
      }
      td{
        border: 1px solid black;
        padding: 6px;
      }
      .num_posts_col{
        text-align: center;
      }
    </style>
  </head>
  <body>
    <script type="text/javascript">
      function sortTable(table, col, reverse){
        var tb = table.tBodies[0];
        var tr = Array.prototype.slice.call(tb.rows, 0);
        var i;
        reverse = -((+reverse) || -1);
        tr = tr.sort(function (a, b){
          return reverse
            * (a.cells[col].textContent.trim()
              .localeCompare(b.cells[col].textContent.trim())
            );
        });
        for(i = 0; i < tr.length; i++) tb.appendChild(tr[i]);
      }
    </script>
    <h1>Topics in My Forum</h1>
    <?php echo $display_block; ?>
    <p>Would you like to <a href="addtopic.html">add a topic</a>?</p>
  </body>
</html>
