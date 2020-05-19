<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield('title')</title>

        <!-- Fonts -->
        <link rel="dns-prefetch" href="//fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
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
                <small style="text-align: left">Redirecting to home in <span id="countdown">5 seconds</span>...</small>
            </div>
        </div>
    </body>
</html>
