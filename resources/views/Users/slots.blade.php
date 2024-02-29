@extends('header')
@extends('footer')

<body>

    @auth {{-- IF LOGIN --}}
    <section class="home-section">
      <div class="overall-slots">
          <h2 name="heading">ALL SLOTS</h2>
          <div class="slots">
              @foreach($slots as $slot)
                  <div class="slot @if($slot->status === 'occupied') occupied @elseif($slot->status === 'reserved') reserved @else available @endif">
                      <h2>{{$slot->slot_number}}</h2>
                      <h5>{{$slot->status}}</h5>
                      <span>Updated At: </span><p>{{$slot->updated_at}}</p>
                      @if($slot->status === 'available')
                          <form action="{{ route('rent', ['slot' => $slot->id]) }}" method="GET">
                              <button type="submit" name="rent">Rent</button>
                          </form>
                          <button name="reserve">Reserve</button>
                      @else
                          <button name="details" disabled>Details</button>
                          <button name="cancel" disabled>Cancel</button>
                      @endif
                  </div>
              @endforeach
          </div>
      </div>
  </section>
  
  @else {{-- IF NOT LOGIN --}}
    <section class="main-home" style="background-image: url(/layouts/Create-Account.png);">
        <div class="main-text">
            <h5 style="font-size: 20px">SPark</h5>
            <h1 style="color: rgb(74, 83, 118)">You need an Account to see slots<br></h1>
            <h1>SPark - Smart Parking System</h1>
            <p>Advanced renting system!</p>

            <a href="/login" class="main-btn">Login Now! <i class='bx bxs-chevron-right'></i></a>
        </div>
    </section>

  @endauth


</body>
</html>