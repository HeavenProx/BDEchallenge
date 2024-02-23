<!-- src/View/User/register_form.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #082B43;
            color: #FFFFFF;
            font-family: 'Arial', sans-serif;
        }

        h2 {
            color: #FDC040;
        }

        form {
            @apply max-w-md mx-auto p-8 bg-white rounded-lg shadow-md;
        }

        label {
            @apply block mb-2 text-blue-900;
        }

        input {
            @apply w-full px-4 py-2 mb-4 border rounded-md;
        }

        button {
            @apply bg-yellow-500 text-blue-900 px-6 py-3 rounded-md cursor-pointer;
        }

        button:hover {
            @apply bg-yellow-400;
        }
    </style>
</head>
<body>
    <header class="container mx-auto">
        <div class="w-20 h-20">
            <a href="/"><img src="img/logo.png" alt="" class="object-cover w-full h-full"></a>
        </div>
    </header>
    <h2 class="text-2xl text-center font-bold my-5">Nous envoyer un mail</h2>

    <form action="/contact/send" method="post" class="max-w-md mx-auto p-8 bg-white rounded-lg shadow-md">

        <label for="objet" class="block mb-2 text-blue-900">Sujet :</label>
        <input type="text" id="objet" name="objet" required class="text-blue-900 w-full px-4 py-2 mb-4 border rounded-md">

        <label for="message" class="block mb-2 text-blue-900">Message :</label>
        <input type="textarea" id="message" name="message" required class="text-blue-900 w-full px-4 py-2 mb-4 border rounded-md">

        <?php 
            if (isset($_SESSION['error'])): 
                echo '<h3 class="text-red-600">' . $_SESSION['error'] . '</h3>';
                unset($_SESSION['error']); // Supprime la variable $_SESSION['error']
            endif; 
        ?>

        <button type="submit" class="bg-yellow-500 text-blue-900 px-6 py-3 rounded-md cursor-pointer hover:bg-yellow-400">Envoyer</button>

    </form>
    <div class="py-20 w-full">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2784.1726218771773!2d4.863066377206497!3d45.747685171079986!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47f4ea7410c5175b%3A0xa0741b8940b6aded!2sCampus%20Sciences-U%20Lyon!5e0!3m2!1sfr!2sfr!4v1708636488258!5m2!1sfr!2sfr" width="600" height="300" style="border:0; width:100%" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>
</body>
</html>
