<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title inertia>{{ config('app.name', 'Cavite State University') }}</title>
</head>
<body>
    <h3>Greetings Mr/Ms {{ $schedule['name'] }}</h3>
    <p>This is {{$schedule['regards']}}.</p>
    <p>Your entrance examination is scheduled on {{ $schedule['date'] }}.</p>
    <p>Your control number is {{ $schedule['ctrl_num'] }}. Exam is only available on the day of your schedule, from 07:00 AM to 5:00 PM. </p>
    <p>Exam retake won't be given to those who won't be able to take the exam.</p>
    <h4>Thank you!</h4>
    <p>Regards,</p>
    <p>{{$schedule['regards']}}</p>
</body>
</html>