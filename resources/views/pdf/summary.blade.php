<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Summary Report</title>

    <style class="summary">
        body {
            font-family: Impact, fantasy;


            margin: 0;
            padding: 0;
            background: #f8f9fa;
        }

        .header {
            height: 120px;
            text-align: right;
            font-size: 12px;
        }

        .header h1 {
            font-size: 60px;
            color: rgb(232, 113, 33);
            margin-top: 0px;
            margin-bottom: 0px;
            left: 0px;
            text-align: left;
        }

        .image {
            position: absolute;
        }

        .image img {
            width: 200px;
            top: 10px;
            right: 10px;
            margin: 0px;
        }

        .container {
            padding: 20px;
            background: #fff;
        }

        .text-center {
            text-align: center;
            font-size: 20px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .table,
        .table th,
        .table td {
            border: 1px solid #dee2e6;
        }

        .table th,
        .table td {
            padding: 7px 15px;
            text-align: center;
        }

        .table thead {
            background-color: rgb(74, 83, 118);
            color: #ffffff;
        }

        .table thead th {
            font-weight: 600;
            font-size: 12px;
        }

        .text-right {
            text-align: right;
        }

        .table tbody tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .table tbody tr td {
            font-size: 12px;
        }

        .text-title {
            margin-bottom: 0;
            color: #333333;
            font-size: 2em;
        }

        h2 {
            font-size: 15px;
            background-color: rgb(74, 83, 118);
            color: white;
            padding: 10px;
            text-align: center;
        }

        .grand-total {
            background-color: #343a40;
            color: white;
        }

        .footer {
            text-align: center;
            padding: 10px;
            background-color: #fff;
            position: fixed;
            bottom: 0;
            width: 100%;
            font-size: 0.8em;
        }
    </style>
</head>

<body>

    <div class="header">
        <div class="header-content">
            <div class="header-left">
                <img src="{{ public_path('layouts/SPark-logos_transparent.png') }}" alt="SPark Logo" style="height: 200px;">
                <p>spark@gmail.com<br>
                    spark@facebook.com.ph<br>
                    8700-911-5522<br>
                    SPark Parking System | 2024 © Copyright</p>
            </div>
            <div class="header-right">
                <strong>Prepared By:</strong>
                <p>Co, Andrei<br>
                    Baligmasay, Ernesto<br>
                    Dacumos, Miguel Angelo<br>
                    Gamo, Marvin</p>
            </div>
        </div>
    </div>





    <div class="container">
        <div class="title">
            <h1>Monthly Summary Report for {{ $reportMonth }}</h1>
        </div>

        <h2 style="background-color: #4a5376; color: white; padding: 8px; margin-top: 20px; font-size: 16px;">Rental
            Record For Irregular User</h2>
        <table class="table">
            <tr>
                <th>Rental ID</th>
                <th>Slot Number</th>
                <th>Name</th>
                <th>Hours</th>
                <th>Minutes</th>
                <th>Minimum Rate</th>
                <th>Additional Rate</th>

                <th class="currency">Total</th>
            </tr>
            </thead>
            <tbody>
                @foreach ($rentals as $rental)
                    <tr>
                        <td>{{ $rental->id }}</td>
                        <td>{{ $rental->slot_number }}</td>
                        <td>{{ $rental->user->username }}</td>
                        <td>{{ $rental->hours }}</td>
                        <td>{{ $rental->minutes }}</td>
                        <td>₱ {{ number_format($ratePerHour, 2) }}</td>
                        <td>₱ {{ number_format($rental->additional_rate, 2) }}</td>
                        <td>₱ {{ number_format($rental->total, 2) }}</td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="7" class="text-right"><strong>Grand Total:</strong></td>
                    <td>₱ {{ number_format($grandTotalRental, 2) }}</td>
                </tr>
            </tbody>
        </table>
        </section>
    </div>


    <div class="table-container">
        <section>
            <h2 style="background-color: #4a5376; color: white; padding: 8px; margin-top: 20px; font-size: 16px;">
                Monthly Subscription of Regular Users</h2>
            <table class="table">
                <tr>
                    <th>User ID</th>
                    <th>Name</th>
                    <th>Month</th>
                    <th>Status</th>
                    <th>Monthly Payment</th>
                </tr>
                </thead>
                <tbody>
                    @foreach ($regularUsers as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->username }}</td>
                            <td>{{ $user->month }}</td>
                            <td>{{ $user->status }}</td>
                            <td>₱ {{ number_format($user->monthly_payment, 2) }}</td>
                        </tr>
                    @endforeach
                    <tr>
                        <td colspan="4" class="text-right"><strong>Grand Total:</strong></td>
                        <td>₱ {{ number_format($grandTotalRegular, 2) }}</td>
                    </tr>
                </tbody>
            </table>
        </section>
    </div>
    <div class="footer">
        SPark Parking System | 2024 © Copyright
    </div>



    </div>

</body>

</html>
