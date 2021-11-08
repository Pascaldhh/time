<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Time</title>
</head>
<body>
    <form method="post">
        <label for="startD">Selecteer start tijd:</label>
        <input type="time" id="startD" name="startD">
        <label for="endD">Selecteer eind tijd:</label>
        <input type="time" id="endD" name="endD"> 
        <input type="submit">  
    </form>
    <?php 
        $startTime = NULL;
        $endTime = NULL;
        if(isset($_POST['startD']))
        {
            $startTime = $_POST['startD'];
        }
        if(isset($_POST['endD']))
        {
            $endTime = $_POST['endD'];
        }
        $date1 = new DateTime($startTime);
        $date2 = new DateTime($endTime);

        $tDiffrence = $date1->diff($date2);

        $totalH = 0;
        $totalM = 0;

        $kwartOver = 0;
        $half = 0;
        $kwartVoor = 0;

        //execute when time is the same and starttime is smaller than end
        function checkInSameH()
        {
            global $date1, $date2, $kwartOver, $half, $kwartVoor;

            if($date1->format('H') == $date2->format('H') && $date1 < $date2)
            {
                if($date1->format('i') <= 15 && $date2->format('i') >= 15){$kwartOver += 1;}
                if($date1->format('i') <= 30 && $date2->format('i') >= 30){$half += 1;}
                if($date1->format('i') <= 45 && $date2->format('i') >= 45){$kwartVoor += 1;}
            }
        }
        checkInSameH();

        

        $minus = $date2->format('H')-$date1->format('H');
        $minus2 = $date2->format('H')-$date1->format('H')+ 24;
    
        function ifNotSameH()
        {
            global $date1, $date2, $kwartOver, $half, $kwartVoor, $minus, $totalH, $minus2;

            if($minus >= 1 || $minus <= -1 || $date1 > $date2)
            {
                if($date1->format('i') <= 15){$kwartOver += 1;}
                if($date1->format('i') <= 30){$half += 1;}
                if($date1->format('i') <= 45){$kwartVoor += 1;}
                
                if($minus >= 1)
                {
                    for($i=1; $i < $minus; $i++)
                    {
                        $totalH += $date1->format('h') + $i;
                        if($totalH > 12){$totalH -= 12;}
                        		                       
                        $kwartOver += 1;
                        $half += 1;
                        $kwartVoor += 1;
                    }
                }
                if($date1 > $date2)
                {
                    for($i=1; $i < $minus2; $i++)
                    {
                        $totalH += $date1->format('h') + $i;
                        if($totalH > 12){$totalH -= 12;}
                        $kwartOver += 1;
                        $half += 1;
                        $kwartVoor += 1;
                    }
                }
                if($date2->format('i') >= 0){$totalH += $date2->format('h');}
                if($date2->format('i') >= 15){$kwartOver += 1;}
                if($date2->format('i') >= 30){$half += 1;}
                if($date2->format('i') >= 45){$kwartVoor += 1;}
            }
        }
        ifNotSameH();


        $totalM = $kwartOver + $half*2 + $kwartVoor*3;
        $total = $totalH+$totalM;
        
        echo '<br>Start Tijd:<b> ' . $startTime .'</b><br>Eind Tijd: <b>'. $endTime . '</b><br><br>'.
             'De klok is zovaak langs kwart over gegaan:<b> ' . $kwartOver .'</b><br>Met een totaal aantal slagen van: <b>'. $kwartOver . '</b><br><br>'.
             'De klok is zovaak langs half gegaan:<b> ' . $half .'</b><br>Met een totaal aantal slagen van: <b>'. $half*2 ."</b><br><br>".
             'De klok is zovaak langs kwart voor gegaan:<b> ' . $kwartVoor .'</b><br>Met een totaal aantal slagen van: <b>'. $kwartVoor*3 ."</b><br><br>".
             'Aantal slagen min:<b> '.$totalM. '</b><br>Aantal slagen uur:<b> '.$totalH. 
             '</b><br><br>Totaal aantal slagen: <b>' . $total . '</b>';
    
        
    ?>
</body>
</html>