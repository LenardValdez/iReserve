<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>iReserve | @yield('title')</title>

        <!-- Fonts -->
        <link rel="dns-prefetch" href="//fonts.gstatic.com">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Source Sans Pro', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .code {
                border-right: 2px solid;
                font-size: 20px;
                padding: 0 15px 0 15px;
                text-align: left;
            }

            .message {
                font-size: 20px;
                text-align: left;
                margin-left: 12px;
            }

            a, a:visited, a:hover {
                color: rgba(0, 91, 150, 1);
            }
        </style>
        <script type="text/javascript">
            var redirectSeconds = 5;
            var redirectCountdown = setInterval(function() {
                redirectSeconds--;
                document.getElementById("countdown").innerHTML = (redirectSeconds != 1) ? redirectSeconds + " seconds" : "1 second";
                if (redirectSeconds == 0) {
                    clearInterval(redirectCountdown);
                    window.location = "{{ route('home') }}";
                }
            }, 1000);
        </script>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            <div class="code">
                <img src={{ URL::asset("img/iacademy_shield.png") }} width="80" alt="iACADEMY">
            </div>

            <div class="message" style="padding: 10px;">
                @yield('code')
                @yield('message')
                <br>
                <small style="text-align: left">Redirecting to home in <span id="countdown">5 seconds</span> (or <a href="/">click here</a>)...</small>
            </div>
        </div>
    </body>
</html>
