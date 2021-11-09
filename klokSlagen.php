<?php 
        $startTime = NULL;
        $endTime = NULL;
        if(isset($_POST['startTime']))
        {
            $startTime = $_POST['startTime'];
        }
        if(isset($_POST['endTime']))
        {
            $endTime = $_POST['endTime'];
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
                    $j = 1;
                    for($i=1; $i < $minus; $i++)
                    {
                        $hours = $date1->format('h') + $j;
                        if($hours > 12){$hours -= 12;}
                        if($j > 12){$j -= 12;}
                        $totalH += $hours;                    
                        $kwartOver += 1;
                        $half += 1;
                        $kwartVoor += 1;

                        $j++;
                    }
                }
                if($date1 > $date2)
                {
                    $j = 1;
                    for($i=1; $i < $minus2; $i++)
                    {
                        $hours = $date1->format('h') + $j;
                        if($hours > 12){$hours -= 12;}
                        if($j > 12){$j -= 12;}
                        $totalH += $hours;
                        $kwartOver += 1;
                        $half += 1;
                        $kwartVoor += 1;
                    
                        $j++;
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
        
        $array = [
            0 => ['Start Tijd:', $startTime, 'Eind tijd:', $endTime],
            1 => ['De klok is zovaak langs kwart over gegaan:', $kwartOver, 'Met een totaal aantal slagen van:', $kwartOver*1],
            2 => ['De klok is zovaak langs half gegaan:', $half, 'Met een totaal aantal slagen van:', $half*2],
            3 => ['De klok is zovaak langs kwart voor gegaan:', $kwartVoor, 'Met een totaal aantal slagen van:', $kwartVoor*3],
            4 => ['Aantal slagen min:', $totalM, 'Aantal slagen uur:', $totalH],
            5 => ['Totaal aantal slagen:', $total],
        ];

        for($i=0; $i<count($array)-1; $i++)
        {
            $j=0;
            echo '
            <div class="result">
                <b>'.$array[$i][$j].'</b>
                <p>'.$array[$i][++$j].'</p>
                <b>'.$array[$i][++$j].'</b>
                <p>'.$array[$i][++$j].'</p>
            </div>    
            ';
        }
        echo '<div class="result">
                <b>'.$array[5][0].'</b>
                <p>'.$array[5][1].'</p>
            </div>';   
        
    ?>