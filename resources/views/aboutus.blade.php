<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SPark: A Smart Parking Management System</title>

    @extends('header')
    @extends('footer')

    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(to right, #3498db, #1abc9c);
            color: #333;
            /* Updated text color */
            display: grid;
            flex-direction: column;
            min-height: 100vh;
            /* Ensure the body takes at least the full viewport height */
        }
    </style>
</head>

<body>

    <section class="about-us-section">

        <div class="aboutus">
            <img src="layouts/SPark-logos_transparent.png" alt="">
            <h3>Company Overview:</h3>

            <p>Spark: Smart Parking Management:</p>
            <p>
                Spark: Smart Parking Management is positioned as a company offering comprehensive smart parking
                solutions with a
                strong focus on user experience, technological innovation, and collaboration with local stakeholders,
                making it unique
                in its approach to addressing urban parking challenges.Spark specializes in providing smart parking
                management
                solutions to address parking challenges through innovative technologies and user-centric approaches.<br>
            </p>
            <div class="profiles-container">
                <div class="profile-container">
                    <div class="profile-picture">
                        <img src="profiles/Balignasay Erneto III, T..jpg" alt="">
                    </div>
                    <div class="profile-name">Ernesto T. Balignasay III</div>
                </div>

                <div class="profile-container">
                    <div class="profile-picture">
                        <img src="profiles/Co, Andrei C.jpeg" alt="">
                    </div>
                    <div class="profile-name">Andrei C. Co</div>
                </div>

                <div class="profile-container">
                    <div class="profile-picture">
                        <img src="profiles/Dacumos, Angelo Miguel S.jpg" alt="">
                    </div>
                    <div class="profile-name">Angelo Miguel S. Dacumos</div>
                </div>

                <div class="profile-container">
                    <div class="profile-picture">
                        <img src="profiles/GAMO, Marvin S..jpg" alt="">
                    </div>
                    <div class="profile-name">Marvin S. Gamo</div>
                </div>
            </div>


    </section>


</body>

</html>
