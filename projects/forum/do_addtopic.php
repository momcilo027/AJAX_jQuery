<?php

include("db_include.php");
doDB();

if((!$_POST['topic_owner']) || (!$_POST['topic_title']) || (!$_POST['topic_text'])){
  header("Location: addtopic.html");
  exit;
}

$clean_topic_owner = mysqli_real_escape_string($mysqli, $_POST['topic_owner']);
$clean_topic_title = mysqli_real_escape_string($mysqli, $_POST['topic_title']);
$clean_post_text = mysqli_real_escape_string($mysqli, $_POST['post_text']);

$add_topic_sql = "INSERT INTO forum_topics (topic_title, topic_create_time, topic_owner) VALUES ('".$clean_topic_title."', now(), '".$clean_topic_owner."')";
$add_topic_res = mysqli_query($mysqli, $add_topic_sql) or die(mysqli_error($mysqli));

$topic_id = mysqli_insert_id($mysqli);

$add_post_sql = "INSERT INTO forum_posts (topic_id, post_text, post_create_time, post_owner) VALUES ('".$topic_id."', '".$clean_post_text."', now(), '".$clean_topic_owner."')";

$add_post_res = mysqli_query($mysqli, $add_post_sql) or die(mysqli_error($mysqli));

mysqli_close($mysqli);

$display_block = "<p>The <strong>".$_POST['topic_title'];"</strong> topic has been created.</p>";

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>New Topic Added</title>
  </head>
  <body>
    <h1>New Topic Added</h1>
    <?php echo $display_block; ?>
  </body>
</html>
