<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title inertia>{{ config('app.name', 'Cavite State University') }}</title>

    <style type="text/css">
        body {
            font-size: 16px
        }

        .name {
            font-weight: bolder;
        }

        .thanks {
            font-size: 16px;
        }

        .img-logo {
            width: 40px;
        }
    </style>
</head>

<body>
    <h2>
        <img src="https://drive.google.com/uc?id=1eXYuH_JePPGJCUg5XLNTuU0DeNoy5QKS" class="img-logo" alt="CvSU Logo"
            title="CvSU" />
        Cavite State University-Main Campus
    </h2>

    <h3 class="greetings">Greetings Mr/Ms. {{ $results->name }}</h3>
    <p>This is <span class="name">{{ config('app.name', 'Cavite State University') }}.</span></p>
    <p>We would like top inform you that you were {{ $results->status }} to enroll in {{ $results->course->course_name }} - {{ $results->course->course_desc }} program.</p>
    <p>Please proceed on completing the requirements for enrollment. If you have any concern regarding the enrollment. Please contact the university registrar.</p>

    <h4 class="thanks">Thank you!</h4>
    <p>Regards,</p>
    <p class="name">{{ config('app.name', 'Cavite State University') }}</p>
</body>

</html>
