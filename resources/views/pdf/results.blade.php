<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Applicants</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">

    <style type="text/css">
        body {
            padding-left: 10px;
            padding-right: 10px;
        }

        table {
            text-align: center;
            margin-left: auto;
            margin-right: auto;
            border-collapse: 6px;
            width: 100%;
        }

        thead tr {
            border: 1px solid rgba(0, 0, 0, 0.2);
            padding: 4px;
        }

        thead tr th {
            text-align: center;
            padding: 4px;
        }

        tbody tr {
            text-align: left;
        }

        tbody tr td {
            text-align: left;
            padding-left: 10px;
            padding-right: 10px;
            padding-bottom: 5px;
            padding-top: 5px;

        }

    </style>
</head>

<body>
    <span class="date">{{ $ddate }}</span>

    <table>
        <thead>
            <tr>
                <th>Control Number</th>
                <th>Name</th>
                <th>Course</th>
                <th>Status</th>
                <th>Email</th>
                <th>Phone Number</th>
            </tr>
        </thead>
        <tbody>

            @foreach ($data as $result)
                <tr>
                    <td>{{ $result->applicant_id }}</td>
                    <td>{{ $result->name }}</td>
                    <td>{{ $result->course }}</td>
                    <td>{{ $result->status }}</td>
                    <td>{{ $result->email }}</td>
                    <td>{{ $result->phone_number }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>
