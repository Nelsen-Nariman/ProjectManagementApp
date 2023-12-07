<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Index PDF</title>
</head>
<body>
    @php
        $count = 1;
    @endphp

    @foreach ($documentations as $documentation)
        <h1>{{ $count }}. {{ $documentation->name }}</h1>
        <br>
        <img src="{{ public_path().'\storage/'.$documentation->image }}" alt="documentation name's image" style="width: 500px">
        <br>
        <p>{{ $documentation->description }}</p>
        <br>
        <br>

        @php
            $count++;
        @endphp
    @endforeach

        
</body>
</html>