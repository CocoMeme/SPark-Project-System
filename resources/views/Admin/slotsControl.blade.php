@extends('header')

<body>

    @auth('admin')

        @if (session('success'))
            <div class="success-message-admin">
                {{ session('success') }}
            </div>
        @endif

        <section class="home-section" style="margin-top: 0">
            <div class="overall-slots">
                <h2 name="heading">ADMIN SLOT CONTROL</h2>
                <div class="slots">


                    {{-- CREATE SLOT --}}

                    <div class="available" style="text-align: center;">
                        <h2>Create New Slot</h2>
                        <form method="POST" action="createSlot">
                            @csrf

                            <label for="slot-number" style="margin-top: 50px">Slot Number:</label>
                            <input type="text" id="slot-number" name="slot_number" required
                                style="padding: 5px; width: 98%; border: 3px solid rgb(74, 83, 118); text-align:center">

                            <button type="submit" name="blue" style="margin-top: 90px">Create Slot</button>
                        </form>
                    </div>

                    @foreach ($slots as $slot)
                        <div
                            class="slot @if ($slot->status === 'occupied') occupied @elseif($slot->status === 'pending') reserved @else available @endif">
                            <h2>{{ $slot->slot_number }}</h2>
                            <h5>{{ $slot->status }}</h5>

                            @php
                                $rental = $slot->currentRental();
                                $reservation = $slot->currentReservation();
                            @endphp

                            @if ($slot->status === 'occupied' && $rental)
                                <span>Rented by: </span>
                                <p>{{ $rental->user->username }}</p>
                            @elseif($slot->status === 'reserved')
                                <span>Reserved by: </span>
                                <p>{{ $reservation->user->username }}</p>
                            @else
                                <span>Rented/Reserved by:</span>
                                <p>None</p>
                            @endif

                            <span>Updated At: </span>
                            <p>{{ $slot->updated_at }}</p>

                            @if ($slot->status === 'available')
                                <form action="{{ route('rentAdmin', ['slot' => $slot->id]) }}" method="GET">
                                    <button type="submit" name="blue">Rent an Irregular</button>
                                </form>
                                <form action="{{ route('reserveAdmin', ['slot' => $slot->id]) }}" method="GET">
                                    <button type="submit" name="orange">Reserve a User</button>
                                </form>
                            @elseif($slot->status === 'occupied')
                                <button name="details" disabled>Details</button>
                                <form action="{{ route('end-renting-admin', ['slot' => $slot->id]) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" name="cancel">End Renting</button>
                                </form>
                            @elseif($slot->status === 'pending')
                                <form action="{{ route('approve-rent', ['slot' => $slot->id]) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" name="blue">Approve</button>
                                </form>
                                <form action="{{ route('denySlotRequest', ['id' => $slot->id]) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" name="cancel">Deny</button>
                                </form>
                            @endif

                        </div>
                    @endforeach
                </div>
<<<<<<< HEAD

                @foreach($slots as $slot)
                <div class="slot @if($slot->status === 'occupied') occupied @elseif($slot->status === 'pending') reserved @else available @endif">
                    <h2>{{$slot->slot_number}}</h2>
                    <h5>{{$slot->status}}</h5>

                    @php
                        $rental = $slot->currentRental();
                        $reservation = $slot->currentReservation();
                    @endphp

                    @if($slot->status === 'occupied' && $rental)
                        <span>Rented by: </span><p>{{ $rental->user->username }}</p>
                    @elseif($slot->status === 'reserved')
                        <span>Reserved by: </span><p>{{ $reservation->user->username }}</p>
                    @else
                        <span>Rented/Reserved by:</span><p>None</p>
                    @endif

                    <span>Updated At: </span>
                    <p>{{$slot->updated_at}}</p>

                    @if($slot->status === 'available')
                        <form action="{{ route('rentAdmin', ['slot' => $slot->id]) }}" method="GET">
                            <button type="submit" name="blue">Rent an Irregular</button>
                        </form>
                        <form action="{{ route('reserveAdmin', ['slot' => $slot->id]) }}" method="GET">
                            <button type="submit" name="orange">Reserve a User</button>
                        </form>

                    @elseif($slot->status === 'occupied')
                        <button name="details" disabled>Details</button>
                        <form action="{{ route('end-renting-admin', ['slot' => $slot->id]) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <button type="submit" name="cancel">End Renting</button>
                        </form>

                    @elseif($slot->status === 'pending')
                        <form action="{{ route('approve-rent', ['slot' => $slot->id]) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <button type="submit" name="blue">Approve</button>
                        </form>
                        <form action="{{ route('denySlotRequest', ['id' => $slot->id]) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <button type="submit" name="cancel">Deny</button>
                        </form>
                    @endif

                </div>
                @endforeach
=======
>>>>>>> 730e2369db155755aaf6bf55e4a6bd5b3a7488f4
            </div>
        </section>
    @else
        <section class="home-section">
            <div class="overall-slots">
                <h2 name="heading">ADMIN SLOT CONTROL</h2>
                <span>INVALID ADMIN AUTHENTICATION</span>
            </div>
        </section>

    @endauth

</body>

</html>
