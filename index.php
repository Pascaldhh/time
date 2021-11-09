<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <title>Clock</title>
    <style>
        .times input[type="time"]{
            font-size: 9rem !important;
            background-color: transparent;
            border:none;
            color: white;
            user-select: none;
        }
        .times input[type="time"]:focus {
            outline: none;
        }
        .times input[type="time"]::-webkit-calendar-picker-indicator {
            filter: brightness(0) invert(1);  
            display: none;      
        }
        .times {
            position: relative;
        }
        .times::after {
            content: '';
            bottom:-175px;
            left: 50%;
            transform: translateX(-50%);
            background-image: url('pijl.png');
            width: 150px;
            height:150px;
            background-size: 150px 150px;
            background-repeat:no-repeat;
            background-position:center;
            position:absolute;
            filter: brightness(0) invert(1);
        }
    </style>
</head>
<body class="bg-danger bg-gradient">
    <div class="container-fluid vh-100 d-flex justify-content-center align-items-center">
        <div class="times">
            <form method="POST" class="d-flex flex-column gap-3">
                <input type="time" class="display-1" value="20:00" id="time1" name="startTime">
                <input type="time" class="display-1" value="21:00" id="time2" name="endTime">
            </form>
        </div>
    </div>
    <div class="container-fluid d-flex flex-column align-items-center text-white results">
        <div class="items">

        </div>
    </div>

    <script>
        $.post('klokSlagen.php', $('form').serialize(), function (data) {
            $('.items').html(data);
        });
        $('input[type="time"]').on('change', () => {
            $.post('klokSlagen.php', $('form').serialize(), function (data) {
                $('.items').html(data);
            });
        });
    </script>
</body>
</html>