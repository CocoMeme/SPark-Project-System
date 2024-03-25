@extends('header')
@extends('footer')

<body>

    @auth('admin')
        <section class="main-home">
            <div class="main-text">
                <h5>Smart Parking Management System</h5>
                <h1>SPark<br></h1>
                <p>Advanced renting system!</p>
                <a href="/slots" class="main-btn">Rent Now! <i class='bx bxs-chevron-right'></i></a>
            </div>
        </section>


        <section class="main-home_map">
            <div>
                <h1>You Can Find Us Here!</h1>
                <iframe width="100%" height="400"
                    src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d7338.896009193448!2d121.0824182!3d14.6297892!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3397b781534dfb73%3A0x7b21af2b010d0f2c!2sGlobalparking%20Management%20Inc.!5e1!3m2!1sen!2sph!4v1710167428942!5m2!1sen!2sph"
                    allowfullscreen="" loading="lazy"></iframe>
            </div>
        </section>

        <section class="main-home_slots">
            <div>
                <table>
                    <tr>
                        <td>650 meters</td>
                        <td>50 slots</td>
                        <td>5.4 meters long by 2.4 meters wide</td>
                        <td>24 hours open!</td>
                    </tr>
                </table>
            </div>
        </section>

        <section class="main-home_text">
            <div>

                <h2>SPark's Objectives</h2>
                <p>The study aims to develop a user-centric and technologically advanced website tailored for Global Parking
                    Management Inc.,
                    enhancing the overall parking experience. By implementing real-time data analytics, intelligent
                    algorithms, and user-friendly
                    interfaces, the proposed system seeks to optimize parking, reduce congestion, and contribute to a more
                    sustainable and efficient
                    urban mobility landscape. Additionally, the integration of transparent financial features and robust
                    security measures ensures a
                    holistic approach to improving the parking ecosystem, benefiting both drivers and the city's urban
                    planning objectives.</p>
            </div>
            <div>

                <h2>W's of SPark</h2>
                <p>Located at 269 Katipunan Ave, Quezon City, 1105 Metro Manila, the Global Parking Management Inc. lot is a
                    big area with approximately 648 square meters.
                    It has 50 parking spots - 25 for regulars, 25 for guests, each about the standard size of 5.4 meters x
                    2.4 meters. It's where people can park their
                    cars when they're out and about in the city.In a busy place like this, finding parking can be tough, but
                    this spot makes it easier.
                    It's like a safe harbor in the sea of city chaos, making life simpler for drivers.</p>
            </div>
            <div>

                <h2>SPark's Introduction</h2>
                <p>Navigating through the city's hustle and bustle, the search for a parking space emerges as a daily
                    difficulty for many.
                    At the heart of this challenge lies the Global Parking Management Inc. parking area, a typical urban
                    space where there
                    is a relentless search for a spot. The rising demand for parking spots often outpaces the available
                    resources, leading
                    to frustrations and worsening the congestion issues. This study sets out to solve these complexities,
                    proposing a fresh
                    approach to urban parking and assisting drivers in effortlessly locating open parking spaces.</p>
            </div>

        </section>
    @else
        @auth

            <section class="main-home">
                <div class="main-text">
                    <h5>Smart Parking Management System</h5>
                    <h1>SPark<br></h1>
                    <p>Advanced renting system!</p>
                    <a href="/slots" class="main-btn">Rent Now! <i class='bx bxs-chevron-right'></i></a>
                </div>
            </section>


            <section class="main-home_map">
                <div>
                    <h1>You Can Find Us Here!</h1>
                    <iframe width="100%" height="400"
                        src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d7338.896009193448!2d121.0824182!3d14.6297892!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3397b781534dfb73%3A0x7b21af2b010d0f2c!2sGlobalparking%20Management%20Inc.!5e1!3m2!1sen!2sph!4v1710167428942!5m2!1sen!2sph"
                        allowfullscreen="" loading="lazy"></iframe>
                </div>
            </section>

            <section class="main-home_slots">
                <div>
                    <table>
                        <tr>
                            <td>650 meters</td>
                            <td>50 slots</td>
                            <td>5.4 meters long by 2.4 meters wide</td>
                            <td>24 hours open!</td>
                        </tr>
                    </table>
                </div>
            </section>

            <section class="main-home_text">
                <div>

                    <h2>SPark's Objectives</h2>
                    <p>The study aims to develop a user-centric and technologically advanced website tailored for Global Parking
                        Management Inc.,
                        enhancing the overall parking experience. By implementing real-time data analytics, intelligent
                        algorithms, and user-friendly
                        interfaces, the proposed system seeks to optimize parking, reduce congestion, and contribute to a more
                        sustainable and efficient
                        urban mobility landscape. Additionally, the integration of transparent financial features and robust
                        security measures ensures a
                        holistic approach to improving the parking ecosystem, benefiting both drivers and the city's urban
                        planning objectives.</p>
                </div>
                <div>

                    <h2>W's of SPark</h2>
                    <p>Located at 269 Katipunan Ave, Quezon City, 1105 Metro Manila, the Global Parking Management Inc. lot is a
                        big area with approximately 648 square meters.
                        It has 50 parking spots - 25 for regulars, 25 for guests, each about the standard size of 5.4 meters x
                        2.4 meters. It's where people can park their
                        cars when they're out and about in the city.In a busy place like this, finding parking can be tough, but
                        this spot makes it easier.
                        It's like a safe harbor in the sea of city chaos, making life simpler for drivers.</p>
                </div>
                <div>

                    <h2>SPark's Introduction</h2>
                    <p>Navigating through the city's hustle and bustle, the search for a parking space emerges as a daily
                        difficulty for many.
                        At the heart of this challenge lies the Global Parking Management Inc. parking area, a typical urban
                        space where there
                        is a relentless search for a spot. The rising demand for parking spots often outpaces the available
                        resources, leading
                        to frustrations and worsening the congestion issues. This study sets out to solve these complexities,
                        proposing a fresh
                        approach to urban parking and assisting drivers in effortlessly locating open parking spaces.</p>
                </div>

            </section>
        @else
            <section class="main-home">
                <div class="main-text">
                    <h5>Smart Parking Management System</h5>
                    <h1>SPark<br></h1>
                    <p>Advanced renting system!</p>
                    <a href="/slots" class="main-btn">Rent Now! <i class='bx bxs-chevron-right'></i></a>
                </div>
            </section>


            <section class="main-home_map">
                <div>
                    <h1>You Can Find Us Here!</h1>
                    <iframe width="100%" height="400"
                        src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d7338.896009193448!2d121.0824182!3d14.6297892!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3397b781534dfb73%3A0x7b21af2b010d0f2c!2sGlobalparking%20Management%20Inc.!5e1!3m2!1sen!2sph!4v1710167428942!5m2!1sen!2sph"
                        allowfullscreen="" loading="lazy"></iframe>
                </div>
            </section>

            <section class="main-home_slots">
                <div>
                    <table>
                        <tr>
                            <td>650 meters</td>
                            <td>50 slots</td>
                            <td>5.4 meters long by 2.4 meters wide</td>
                            <td>24 hours open!</td>
                        </tr>
                    </table>
                </div>
            </section>

            <section class="main-home_text">
                <div>

                    <h2>SPark's Objectives</h2>
                    <p>The study aims to develop a user-centric and technologically advanced website tailored for Global Parking
                        Management Inc.,
                        enhancing the overall parking experience. By implementing real-time data analytics, intelligent
                        algorithms, and user-friendly
                        interfaces, the proposed system seeks to optimize parking, reduce congestion, and contribute to a more
                        sustainable and efficient
                        urban mobility landscape. Additionally, the integration of transparent financial features and robust
                        security measures ensures a
                        holistic approach to improving the parking ecosystem, benefiting both drivers and the city's urban
                        planning objectives.</p>
                </div>
                <div>

                    <h2>W's of SPark</h2>
                    <p>Located at 269 Katipunan Ave, Quezon City, 1105 Metro Manila, the Global Parking Management Inc. lot is a
                        big area with approximately 648 square meters.
                        It has 50 parking spots - 25 for regulars, 25 for guests, each about the standard size of 5.4 meters x
                        2.4 meters. It's where people can park their
                        cars when they're out and about in the city.In a busy place like this, finding parking can be tough, but
                        this spot makes it easier.
                        It's like a safe harbor in the sea of city chaos, making life simpler for drivers.</p>
                </div>
                <div>

                    <h2>SPark's Introduction</h2>
                    <p>Navigating through the city's hustle and bustle, the search for a parking space emerges as a daily
                        difficulty for many.
                        At the heart of this challenge lies the Global Parking Management Inc. parking area, a typical urban
                        space where there
                        is a relentless search for a spot. The rising demand for parking spots often outpaces the available
                        resources, leading
                        to frustrations and worsening the congestion issues. This study sets out to solve these complexities,
                        proposing a fresh
                        approach to urban parking and assisting drivers in effortlessly locating open parking spaces.</p>
                </div>

            </section>

        @endauth
    @endauth


</body>

</html>
