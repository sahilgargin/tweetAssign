<?php
    $kw = $_GET['kw'];
    set_time_limit(0);
    $res['row'] = array();
    $count = 0;
    $link = mysqli_connect("localhost", "root", "foodiyerocks");
    if (!$link) {
        die('Could not connect: ' . mysql_error());
    }
    else
    {
        if($_GET['kw'])
        {
            $result = mysqli_query($link,"SELECT * from newDd.followers where name_followers like '%".$kw."%' ");
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

        else if ($_GET['twid'])
        {
            $result = mysqli_query($link,"SELECT * from newDd.followers where id_followers = '".$_GET['twid']."'");
            if (! $result)
            {
                throw new My_Db_Exception('Database error: ' . mysqli_error());
            }           
            while ($row = mysqli_fetch_assoc($result))
            {   
               
                $res['row'][] =array('id'=>$row['id_followers'], 'name'=> $row['name_followers'], 'tweets'=> json_decode($row['tweet_followers']));  
            }
         header('Content-Type: application/json');
         $count = mysqli_num_rows ($result);
         $res['number_sets'] = $count;
         echo '{"users":'.json_encode($res).'}';    
        } 
    }
   
?>