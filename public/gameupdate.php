<?php
error_reporting(0);

$db = mysqli_connect("localhost", "singroav_kuill", "kuill@12345", "singroav_kuill");


//date_default_timezone_set('Asia/Kolkata');

$days_ago = date('H:i', strtotime('-30 minutes', strtotime("now")));

$days_ago1 = date('Y-m-d');

$resul = mysqli_query($db,"SELECT * FROM game where isactive=1 ");
//var_dump($resul);die;


$num = mysqli_num_rows($resul);

if($num>0)
{

    $I = 0;
    while($I<($row = mysqli_fetch_assoc($resul))){
        $closedate=$row['close_date'];
        $closetime=$row['game_time'];
        $closedatetime=$closedate." ".$closetime;
       // var_dump($closedatetime);die();
        $closedatevalue=strtotime($closedatetime);
        $currentdate = date('Y-m-d H:i');
        $currentvalue=strtotime($currentdate);

        if($currentvalue>=$closedatevalue){
          //  var_dump($row[id]); die('aaa');
            $update = $db->query("UPDATE game SET isactive =3 where id='$row[id]'");
        }

        $I++;

    }


}
?>
