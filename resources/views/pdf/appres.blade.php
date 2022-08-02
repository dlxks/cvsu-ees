<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Result</title>

    <style type="text/css">
        body {
            font-family: serif;
        }

        .header {
            font-family: sans-serif;
            color: rgba(100, 100, 100, 1);
            margin-left: 50px;
        }

        h2 {
            text-align: center;
            font-family: serif;
            padding-bottom: -15px
        }

        h4 {
            text-align: center
        }

        .name {
            font-weight: bold;
        }

        .g-name {
            font-weight: bold;
            font-size: 16px;
        }

        .a-name {
            font-weight: bold;
        }

        .s-name {
            font-weight: bold;
        }

        .main-letter {
            text-align: justify;
            margin: 50px;
        }

        .main-b {
            font-size: 14px;
            margin-top: 50px;
        }

        p {
            /* text-indent: 40px; */
            word-spacing: 8px;
            line-height: 2.5;
        }

        .signature {
            line-height: 0.5;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="header">
        <span class="date">{{ $date }} - </span>
        <span class="name"> Cavite State University-Main Campus</span>
    </div>

    <div class="main-letter">
        <h2>Cavite State University</h2>
        <h4>Indang, Cavite</h4>

        <div class="main-b">
            <p class="greetings">Greetings. This is <span class="g-name">Cavite State University-Main Campus.</span></p>

            <p class="p1">Congratulations! We would like to inform you, applicant <span
                    class="a-name">{{ $result->applicant->lname }},
                    {{ $result->applicant->fname }} {{ $result->applicant->mname }}</span>, was qualified to enroll
                at
                Cavite State
                University-Main Campus. Please proceed on completing the requirements for the enrollment.</p>

            <p class="p2">Please accept this letter as confirmation letter of your application at Cavite State
                University-Main Campus. If you have any question or concerns about the process of enrollment, please
                contact
                our University registrar immediately.</p>
            <p>Yours Sincerely,
            <p class="signature">Cavite State University-Main Campus</p>
        </div>
    </div>
    </div>

    {{-- <table>
        <thead>
            <tr>
                <th>Control Number</th>
                <th>Name</th>
                <th>Courses</th>
                <th>Status</th>
                <th>Email</th>
                <th>Phone Number</th>
            </tr>
        </thead>
        <tbody>

            <tr>
                <td>{{ $result->applicant_id }}</td>
                <td>{{ $result->name }}</td>
                <td>
                    @foreach ($result->courses as $course)
                        {{ $course->course_name . ', ' }}
                    @endforeach
                </td>
                <td>{{ $result->status }}</td>
                <td>{{ $result->applicant->email }}</td>
                <td>{{ $result->applicant->phone_number }}</td>
            </tr>
        </tbody>
    </table> --}}

</body>

</html>
