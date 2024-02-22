<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        <?php
        //fait avec Audrey HOSSEPIAN = patch par rapport à l'incompréhension du MVC custom du cours PHP
         require( __DIR__. "../../../../public/asset/css/bootstrap.css");
         require( __DIR__. "../../../../public/asset/css/base.css");
         require( __DIR__. "../../../../public/asset/css/style.css");
         //décommenter si utilisation de fontawesome
         //require( __DIR__. "../../../../public/css/all.css");
         ?>
    </style>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cherry+Bomb+One&display=swap" rel="stylesheet">
    <title>BDE</title>
</head>

<body>

    <header>
        <nav>
            <img src="img/logo.png" class="logo">

            <div class="listMenu">
                <ul>
                    
                    <?php if(isset($_SESSION['logged']) && $_SESSION['logged'] == true): ?>
                        <li><a href="/profile"><button class="btn border"><?php echo $_SESSION['user']['firstName'] . " " . $_SESSION['user']['lastName'] ?></button></a></li>
                        <li><a href="/logout"><button class="btn border">Se déconnecter</button></a></li>
                        <?php if($_SESSION['user']['role'] == "Admin"): ?>
                            <li><a href="/users"><button class="btn border">Panneau d'administration</button></a></li>
                        <?php endif; ?>
                    <?php else: ?>
                        <li><a href="/login"><button class="btn border">Se connecter</button></a></li>
                        <li> <a href="/register"><button class="btn border">S'inscrire</button></a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </nav>


        <div>
            <h1 class="cherry">Bienvenue dans <br> la ruche</h1>
            <h2><a href="/events">Voir les évévenements</a></h2>
        </div>
    </header>

    <main>

        <section class="apropos">
            <article class="presentation">
                <h2>A propos de nous</h2>
                <h3>Butiner les moments de joie et de convivialité avec Beede, la ruche animée du BDE, où chaque abeille
                    compte!</h3>
            </article>
        </section>

        <section class="containerConcept container-fluid">
            <article class="articleConcept row">
                <img src="img/concert.png" class="col-md-6 col-12 p-0">
                <div class="texteConcept col-md-6 col-12 p-0">
                    <div class="texteInt">
                        <h4 class="cherry">Les concerts</h4>
                        <p>Plongez au cœur d'une symphonie sensorielle inoubliable avec nos concerts enflammés, où
                            chaque note résonne dans l'âme.
                        </p>
                    </div>
                </div>
            </article>
            <article class="articleConcept row">
                <div class="texteConcept col-md-6 col-12 p-0">
                    <div class="texteInt">
                        <h4 class="cherry">Ciné Vibes</h4>
                        <p>Attendez-vous à des soirées ciné au top, avec Beede qui rend la magie du grand écran
                            accessible à tous nos potes géniaux !
                        </p>
                    </div>
                </div>
                <img src="img/clap.png" class="col-md-6 col-12 p-0" alt="">
            </article>
            <article class="articleConcept row">
                <img src="img/hand.png" class="col-md-6 col-12 p-0" alt="">
                <div class="texteConcept col-md-6 col-12 p-0">
                    <div class="texteInt">
                        <h4 class="cherry">Bee-Party</h4>
                        <p>Préparez-vous à une ambiance de folie avec les soirées Beede ! Plongez dans l'énergie
                            débordante de nos events !!
                        </p>
                    </div>
                </div>
            </article>
        </section>

        <section class="containerEvents">
            <div class="container">
                <h2 class="text-center cherry">Nos Evènements</h2>
                <ul class="row list-unstyled text-center ">
                    <li class="col-lg-4 col-md-12 py-4">
                        <div>
                            <!--<img src="img/" class="mb-4" alt="faits maison"> -->
                            <h3 class="fw-bold">Soirée d'intégration</h3>
                            <p>Ipsum qui adipisicing quis mollit nostrud laboris dolore.</p>
                        </div>
                    </li>
                    <li class="col-lg-4 col-md-12 py-4">
                        <div>
                            <!--<img src="img/" class="mb-4" alt="produits frais"> -->
                            <h3 class="fw-bold">Soirée Halloween</h3>
                            <p>Ipsum qui adipisicing quis mollit nostrud laboris dolore.</p>
                        </div>
                    </li>
                    <li class="col-lg-4 col-md-12 py-4">
                        <div>
                            <!--<img src="img/" class="mb-4" alt="bios et locaux"> -->
                            <h3 class="fw-bold">Soirée Déguisé</h3>
                            <p>Ipsum qui adipisicing quis mollit nostrud laboris dolore.</p>
                        </div>
                    </li>
                </ul>
            </div>
               
        </section>

    </main>

    <footer>
        <div class="row container">
        <div class="col-lg-6 col-md-12 px-5">Sciences-U Lyon</div>
        <div class="col-lg-6 col-md-12 px-5">53 Cr Albert Thomas, 69003 Lyon</div>
        <div class="col-lg-6 col-md-12 px-5">Sciences-u-lyon.fr</div>
        <div class="col-lg-6 col-md-12 px-5"><a href="/contact">Nous Contacter</a></div>
        </div>
    </footer>

</body>

</html>