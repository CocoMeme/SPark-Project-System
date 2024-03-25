    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Summary Report</title>

        <style class="summary">
            body {
                font-family: 'DejaVu Sans', sans-serif;
                margin: 0;
                padding: 0;
                background: #f8f9fa;
            }

            .header {
                font-size: 10px;
                display: flex;
                flex-direction: column;
                align-items: flex-start;
                padding: 10px;
                margin-bottom: 20px;
                /* Space between header and content */
            }

            .header img {
                max-height: 100px;
                margin-bottom: 10px;
            }

            .header-info {
                margin-bottom: 10px;
                /* Space between contact info and prepared by section */
            }

            .header-right {
                align-self: flex-start;
                /* Aligns 'Prepared By' below the contact info */
                margin-top: auto;
                /* Pushes the 'Prepared By' section to the bottom */
                font-size: 10px;
            }

            .header-content {
                display: flex;
                justify-content: space-between;
                /* This will position your items on the left and right */
                align-items: center;
                /* This will vertically align your items */
                padding: 10px;
            }

            .header h1 {
                font-size: 24px;
                /* Reduced font size */
                color: rgb(232, 113, 33);
                margin-top: 0px;
                margin-bottom: 0px;
                text-align: left;
            }

            .image {
                position: absolute;
            }

            .image img {
                width: 150px;
                /* Adjust as needed */
                top: 10px;
                right: 10px;
                margin: 0px;
            }

            .container {
                padding: 10px;
                /* Reduced padding */
                background: #fff;
            }

            .text-center {
                text-align: center;
                font-size: 16px;
                /* Adjusted font size */
            }

            .table {
                width: 100%;
                border-collapse: collapse;
                margin-bottom: 10px;
                /* Reduced margin */
            }

            .table,
            .table th,
            .table td {
                border: 1px solid #dee2e6;
            }

            .table th,
            .table td {
                padding: 5px 10px;
                /* Adjusted padding */
                text-align: center;
                font-size: 10px;
                /* Reduced font size */
            }

            .table thead {
                background-color: rgb(74, 83, 118);
                color: #ffffff;
            }

            .table thead th {
                font-weight: bold;
                /* Ensures bold headings */
            }

            .table tbody tr:nth-child(even) {
                background-color: #f2f2f2;
            }

            h2 {
                font-size: 14px;
                /* Reduced font size */
                background-color: rgb(74, 83, 118);
                color: white;
                padding: 5px;
                /* Adjusted padding */
                text-align: center;
            }

            .grand-total {
                background-color: #343a40;
                color: white;
            }

            .footer {
                text-align: center;
                padding: 5px;
                /* Adjusted padding */
                background-color: #fff;
                position: fixed;
                bottom: 0;
                width: 100%;
                font-size: 10px;
                /* Reduced font size */
            }
        </style>
    </head>

    <body>

<<<<<<< HEAD
<body>

    <div class="header">
        <div class="header-content">
            <div class="header-left">
                <img src="{{ public_path('layouts/SPark-logos_transparent.png') }}" alt="SPark Logo" style="height: 200px;">
=======
        <div class="header">
            <img src="{{ public_path('logo/SPark-logos_transparent.png') }}" alt="SPark Logo">
            <div class="header-info">
>>>>>>> 730e2369db155755aaf6bf55e4a6bd5b3a7488f4
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






        <div class="container">
            <div class="title">
                <h1>Monthly Summary Report for {{ Carbon\Carbon::parse($reportMonth)->format('F Y') }}</h1>

            </div>

            <h2 style="background-color: #4a5376; color: white; padding: 8px; margin-top: 20px; font-size: 16px;">Rental
                Record For Irregular User</h2>
            <table class="table">
                <tr>
<<<<<<< HEAD
                    <th>User ID</th>
=======
                    <th>Rental ID</th>
                    <th>Slot Number</th>
>>>>>>> 730e2369db155755aaf6bf55e4a6bd5b3a7488f4
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
<<<<<<< HEAD
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
=======
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
>>>>>>> 730e2369db155755aaf6bf55e4a6bd5b3a7488f4
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
                            <td>&#8369; {{ number_format($user->monthly_payment, 2) }}</td>
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
