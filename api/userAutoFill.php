<?php
    $kw = $_GET['kw'];
    set_time_limit(0);
    $res['row'] = array();
    $count = 0;
    $link = mysqli_connect("127.0.0.1:3306", "root", "123456");
    if (!$link) {
        die('Could not connect: ' . mysql_error());
    }
    else
    {
       $result = mysqli_query($link,"SELECT * from tweet.followers where name_followers like '%".$kw."%' ");
       if (! $result)
       {
            throw new My_Db_Exception('Database error: ' . mysqli_error());
        }           
        while ($row = mysqli_fetch_assoc($result))
       {    
            $res['row'][] =array('id'=>$row['id_followers'], 'name'=> $row['name_followers']);  
        }
     header('Content-Type: application/json');
     $count = mysqli_num_rows ($result);
     $res['number_sets'] = $count;
     echo '{"users":'.json_encode($res).'}';       
    }
   
?>