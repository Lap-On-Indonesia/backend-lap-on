<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Report</title>
</head>

<body>
    <h1>Report</h1>
    <table>
        <thead>
            <tr>
                <th>Transaction</th>
                <th>Total</th>
                <th>Booking ID</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($reports as $report)
                <tr>
                    <td>{{ $report->transaction }}</td>
                    <td>{{ $report->total }}</td>
                    <td>{{ $report->booking->id ?? '-' }}</td>
                    <td>{{ $report->created_at }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
