<section>
    <div class="Topbar">
      <div class="top">
        <p style="color: rgb(248, 10, 10)">Welcome to TourBD</p>
      </div>
       <div class="top">
        <p style="color: rgb(255, 0, 0)"><i class="fas fa-phone-alt"></i>01777225582 <i class="far fa-envelope"></i> toursandtravels@gmail.com</p>
       </div>
    </div>
  </section>
    <header>
     <img  id="logo" src="{{asset('asset\image\travel.png')}}" alt=""> 
        <nav class=""  >
            <ul class="nav-bar">
                <li><a href={{route('home')}}>Home</a></li>
                <li><a href="{{route('packages')}}">Packages</a></li>
                <li><a href="{{route('events')}}">Events</a></li>
                <li><a href="">Contact Us</a></li>
              </ul>
        </nav>
        @if (Session::has('user'))
        <ul class="nav navbar-nav  ">
            <div class="dropdown" >
                <button class="btn" type="button" data-toggle="dropdown">{{Session::get('user')}}
                <span class="caret"></span></button>
                <ul class="dropdown-menu">
                  <li><a href="{{route('editprofile')}}">My Profile</a></li>
                  
                  @if (Session()->get('role')=='agent')
                    <li><a href="{{route('createpackages')}}">My Packages</a></li>
                    <li><a href="{{route('createevents')}}">My Events</a></li>
                  @else
                    <li><a href="{{route('mybooking')}}">My Booking</a></li>
                  @endif
                  
                  <li><a href="{{route('logout')}}">Log Out</a></li>
                </ul>
              </div>
        </ul>
        @else
            <li><a class="btn" href={{route('login')}} ><span ></span>Sign in</a></li>
        
        @endif
    </header>