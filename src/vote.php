<?php
require_once "config.php";
if (isset($_POST['vote']) && isset($_POST['post_id']) && isset($_POST['user_id'])) {
    $sql = "SELECT * FROM creaturereview WHERE id =".$_POST['post_id'];
    $query = mysqli_query($link, $sql);
    if(mysqli_num_rows($query) > 0)
    {
        $sql = "SELECT * FROM vote WHERE post_id =".$_POST['post_id']." AND user_id =".$_POST['user_id'];
        $query = mysqli_query($link, $sql);
        $row = mysqli_fetch_assoc($query);
        if(isset($row)) //voted
        {
            if($_POST['vote'] == 'upvote')
            {
                if($row['vote'] != 'upvote')
                {
                    $sql = "UPDATE creaturereview SET upvote = upvote + 1 WHERE id =".$_POST['post_id'];
                    mysqli_query($link, $sql);
                    $sql = "UPDATE creaturereview SET downvote = downvote - 1 WHERE id =".$_POST['post_id'];
                    mysqli_query($link, $sql);
                    $sql = "UPDATE vote SET vote = 'upvote' WHERE post_id =".$_POST['post_id']." AND user_id =".$_POST['user_id'];
                    mysqli_query($link, $sql);
                }
                else
                {
                    $sql = "UPDATE creaturereview SET upvote = upvote - 1 WHERE id =".$_POST['post_id'];
                    mysqli_query($link, $sql);
                    $sql = "DELETE FROM vote WHERE post_id =".$_POST['post_id']." AND user_id =".$_POST['user_id'];
                    mysqli_query($link, $sql);
                }
            }
            else 
            {
                if($row['vote'] != 'downvote')
                {
                    $sql = "UPDATE creaturereview SET upvote = upvote - 1 WHERE id =".$_POST['post_id'];
                    mysqli_query($link, $sql);
                    $sql = "UPDATE creaturereview SET downvote = downvote + 1 WHERE id =".$_POST['post_id'];
                    mysqli_query($link, $sql);
                    $sql = "UPDATE vote SET vote = 'downvote' WHERE post_id =".$_POST['post_id']." AND user_id =".$_POST['user_id'];
                    mysqli_query($link, $sql);
                }
                else
                {
                    $sql = "UPDATE creaturereview SET downvote = downvote - 1 WHERE id =".$_POST['post_id'];
                    mysqli_query($link, $sql);
                    $sql = "DELETE FROM vote WHERE post_id =".$_POST['post_id']." AND user_id =".$_POST['user_id'];
                    mysqli_query($link, $sql);
                }
            }
        }
        else //havent voted yet
        {
            if($_POST['vote'] == 'upvote')
            {
                $sql = "INSERT INTO vote(post_id, user_id, vote) VALUE(".$_POST['post_id'].",".$_POST['user_id'].",'upvote')";
                mysqli_query($link, $sql);
                $sql = "UPDATE creaturereview SET upvote = upvote + 1 WHERE id =".$_POST['post_id'];
                mysqli_query($link, $sql);
            }
            else
            {
                $sql = "INSERT INTO vote(post_id, user_id, vote) VALUE(".$_POST['post_id'].",".$_POST['user_id'].",'downvote')";
                mysqli_query($link, $sql);
                $sql = "UPDATE creaturereview SET downvote = downvote + 1 WHERE id =".$_POST['post_id'];
                mysqli_query($link, $sql);
            }
        }
    }
    else
    {
        $sql = "INSERT INTO creaturereview(id, upvote, downvote) VALUE(".$_POST['post_id'].", 1, 0)";
        mysqli_query($link, $sql);
        $sql = "INSERT INTO vote(post_id, user_id, vote) VALUE(".$_POST['post_id'].",".$_POST['user_id'].",'upvote')";
        mysqli_query($link, $sql);
    }
    $sql = "SELECT * FROM creaturereview WHERE id =".$_POST['post_id'];
    $query = mysqli_query($link, $sql);
    //delete if too bad
    if(mysqli_num_rows($query) > 0)
    {
        $row = mysqli_fetch_assoc($query);
        echo $row['upvote']." ".$row['downvote'];
        if($row['downvote']/$row['upvote'] > 2 && $row['downvote'] - $row['upvote'] > 500)
        {
            $sql = "DELETE FROM creature WHERE ID = ".$_POST['post_id'];
            mysqli_query($link, $sql);
            $sql = "DELETE FROM creaturereview WHERE ID = ".$_POST['post_id'];
            mysqli_query($link, $sql);
            $sql = "DELETE FROM vote WHERE post_id = ".$_POST['post_id'];
            mysqli_query($link, $sql);
        }
    }
    else
    {
        echo "0 0";
    }
    mysqli_close($link);
}
?>