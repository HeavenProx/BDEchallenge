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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js" integrity="sha512-7eHRwcbYkK4d9g/6tD/mhkf++eoTHwpNM9woBxtPUBWm67zeAfFC+HrdoE2GanKeocly/VxeLvIqwvCdk7qScg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.9.1/ScrollTrigger.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-element-bundle.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Cherry+Bomb+One&display=swap" rel="stylesheet">
    <title>BDE</title>
</head>

<body>

    <header>
        <script>
            <?php if(isset($_SESSION['error'])): ?>
                alert("Vous ne pouvez pas accéder à cette page")
            <?php endif; ?>
        </script>
        <?php
            unset($_SESSION['error']);
        ?>
        <nav>
            <img src="img/logo.png" class="logo">
            <div class="listMenu">
                <ul>
                    <?php if(isset($_SESSION['logged']) && $_SESSION['logged'] == true): ?>
                        <li><a href="/profil"><button class="btn border"><?php echo $_SESSION['user']['firstName'] . " " . $_SESSION['user']['lastName'] ?></button></a></li>
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
            <h1 class="cherry title">Bienvenue dans <br> la ruche</h1>
            <h2><a href="/events">Voir les évévenements</a></h2>
        </div>
    </header>

    <main>
        <section class="apropos">
            <article class="presentation">
                <h2 class="title1 cherry mb-5">A propos de nous</h2>
                <h3 class="title2">Butiner les moments de joie et de convivialité avec Beede, la ruche animée du BDE, où chaque abeille
                    compte!</h3>
            </article>
        </section>
        <section class="containerConcept container-fluid">
            <article class="articleConcept row">
                <img src="img/concert.png" class="col-md-6 col-12 p-0 right1">
                <div class="texteConcept col-md-6 col-12 p-0">
                    <div class="texteInt left1">
                        <h4 class="cherry">Les concerts</h4>
                        <p>Plongez au cœur d'une symphonie sensorielle inoubliable avec nos concerts enflammés, où
                            chaque note résonne dans l'âme.
                        </p>
                    </div>
                </div>
            </article>
            <article class="articleConcept row">
                <div class="texteConcept col-md-6 col-12 p-0">
                    <div class="texteInt right2">
                        <h4 class="cherry">Ciné Vibes</h4>
                        <p>Attendez-vous à des soirées ciné au top, avec Beede qui rend la magie du grand écran
                            accessible à tous nos potes géniaux !
                        </p>
                    </div>
                </div>
                <img src="img/clap.png" class="col-md-6 col-12 p-0 left2" alt="">
            </article>
            <article class="articleConcept row">
                <img src="img/hand.png" class="col-md-6 col-12 p-0 right3" alt="">
                <div class="texteConcept col-md-6 col-12 p-0">
                    <div class="texteInt left3">
                        <h4 class="cherry">Bee-Party</h4>
                        <p>Préparez-vous à une ambiance enivrante avec les soirées organisées par Beede! Plongez au cœur de l'énergie débordante de nos événements!!
                        </p>
                    </div>
                </div>
            </article>
        </section>

        <section class="containerEvents">
            <div class="container text-center">
                <h2 class="cherry mb-5 title4">Nos Évènements</h2>
                <ul class="row justify-content-center list-unstyled mb-5">
                    <?php if (empty($events)): ?>
                        <p class="mt-4">Pas encore d'évènement mais reste à l'affût !</p>
                    <?php else: ?>
                        <swiper-container
                            slides-per-view="3"
                            :breakpoints='{
                                "640": {
                                    "slidesPerView": 1,
                                    "spaceBetween": 10
                                },
                                "768": {
                                    "slidesPerView": 2,
                                    "spaceBetween": 20
                                },
                                "1024": {
                                    "slidesPerView": 3,
                                    "spaceBetween": 30
                                }
                            }'>
                        <?php foreach ($events as $event): ?>
                            <swiper-slide>
                            <li class="col">
                                <a href="/event/details/<?php echo $event['eventNumber']; ?>">
                                    <div class="event-item rounded-4">
                                        <h3 class="fw-bold mb-5 fs-2"><?php echo $event['name'] ?></h3>
                                        <p><?php echo $event['category'] . ' à ' . $event['eventDate']?></p>
                                    </div>
                                </a>
                            </li>
                            </swiper-slide>
                        <?php endforeach; ?>
                        </swiper-container>
                    <?php endif; ?>
                </ul>
                <a href="/events"><button class="btn border btnEvent">Voir tous nos évènements</button></a>
            </div>
               
        </section>

    </main>

    <footer class="d-flex align-items-center justify-content-center">
        <div class="row container d-flex align-items-center justify-content-center">
            <div class="col-lg-6 col-md-12 px-5">Sciences-U Lyon</div>
            <div class="col-lg-6 col-md-12 px-5"><a href="/contact">Nous Contacter</a></div>
            <div class="col-lg-6 col-md-12 px-5">53 Cr Albert Thomas, 69003 Lyon</div>
            <div class="col-lg-6 col-md-12 px-5">Sciences-u-lyon.fr</div>
        </div>
    </footer>

</body>
<script>

    gsap.registerPlugin(ScrollTrigger);

    function animateElement(element, xValue) {
      gsap.from(element, {
        x: xValue,
        duration: 1,
        opacity: 0,
        scrollTrigger: {
          trigger: element,
          start: 'top 80%',
        },
      });
    }

    animateElement('.title', '-100%');
    animateElement('.title1', '100%');
    animateElement('.title2', '-100%');

    animateElement('.right1', '-100%');
    animateElement('.right2', '-100%');
    animateElement('.right3', '-100%');

    animateElement('.left1', '100%');
    animateElement('.left2', '100%');
    animateElement('.left3', '100%');

    // Animation pour le bouton "Tous nos évènements"
    gsap.from('.btnEvent', {
        opacity: 0,
        y: 50,
        duration: 1,
        scrollTrigger: {
            trigger: '.btnEvent',
            start: 'top 80%',
            end: 'top 100%', // Ajustez cette valeur selon vos besoins
            scrub: true, // Animation fluide pendant le défilement
        },
    });
  </script>
</html>