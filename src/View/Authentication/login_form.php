<!-- src/View/User/register_form.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
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
    <h2 class="text-2xl font-bold mb-4 text-center mt-8">Connexion</h2>

    <div>
        
    </div>

    <form action="/checklogs" method="post" class="max-w-md mx-auto p-8 bg-white rounded-lg shadow-md">
        <label for="email" class="block mb-2 text-blue-900">E-mail:</label>
        <input type="email" id="email" name="email" required class="text-blue-900 w-full px-4 py-2 mb-4 border rounded-md">

        <label for="password" class="block mb-2 text-blue-900">Mot de passe:</label>
        <input type="password" id="password" name="password" required class="text-blue-900 w-full px-4 py-2 mb-4 border rounded-md">

        <?php if (isset($_SESSION['error'])): ?>
            <?php 
                if (isset($_SESSION['error'])): 
                    echo '<h3 class="text-red-600">' . $_SESSION['error'] . '</h3>';
                    unset($_SESSION['error']); // Supprime la variable $_SESSION['error']
                endif; 
            ?>
        <?php endif; ?>

        <button type="submit" class="bg-yellow-500 text-blue-900 px-6 py-3 rounded-md cursor-pointer hover:bg-yellow-400">Se connecter</button>
        <a href="/register" class="text-black ml-5 border-b border-black">S'inscrire</a>
    </form>
</body>
</html>
