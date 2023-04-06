<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>!!!!!!</title>
    <style>
        .lao-font {
            font-family: 'Saysettha OT';
        }

    </style>
</head>

<body>
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <a class="dropdown-item lao-font" href="route('logout')" onclick="event.preventDefault();
                            this.closest('form').submit();" style="flex: content; text-align: center;"><i
                class="fa fa-sign-out pull-right"></i>
            <h1>ອອກ</h1>
        </a>
    </form>
</body>

</html>
