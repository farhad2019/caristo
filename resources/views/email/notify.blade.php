<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
</head>
<body>

<div>
    Hi {{ $name }},
    <br>
    You just receive a new trade in request on your car.
    <br>
    Click here to check : {{ route('admin.tradeInCars.index') }}
    <br/>
</div>

</body>
</html>