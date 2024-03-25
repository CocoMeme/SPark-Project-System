@extends('header')

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Summary Report</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
</head>

<body>


    <div class="container mt-5">

        <!-- Rental Record Section -->

        <section>
            <h1 class="text-center mb-4">Summary Report</h1>
            <div class="text-center mb-4">

            </div>
            <h2>Rental Record For Irregular User</h2>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Rental ID</th>
                        <th>Slot Number</th>
                        <th>Name</th>
                        <th>Hours</th>
                        <th>Minutes</th>
                        <th>Minimum Rate</th>
                        <th>Additional Rate</th>
                        <th>Total</th>
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



        <!-- Monthly Subscription for Regular Users Section -->

        <section>
            <h2>Monthly Subscription of Regular Users</h2>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>User ID</th>
<<<<<<< HEAD
=======

>>>>>>> 730e2369db155755aaf6bf55e4a6bd5b3a7488f4
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
<<<<<<< HEAD
=======

>>>>>>> 730e2369db155755aaf6bf55e4a6bd5b3a7488f4
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

        <div class="report-selection">
            <form action="{{ route('admin.generate-summary-report') }}" method="GET" class="text-center">
                <label for="reportMonth" class="report-label">Select Month and Year for Report:</label>
                <input type="month" id="reportMonth" name="reportMonth" value="{{ old('reportMonth', date('Y-m')) }}"
                    class="report-input">
                <button type="submit" class="btn generate-report-btn">Generate Report</button>

            </form>
        </div>

    </div>


    </div>

</body>
