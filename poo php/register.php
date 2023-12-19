<?php
require_once 'Users.php';

if (isset($_POST['submit'])) {
   
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $password = $_POST['password']; 

    Users::registerUser($nom, $prenom, $email, $password);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-blue-400">

    <section class="vh-100 flex items-center justify-center bg-white
    ">
        <div class="container mx-auto">
            <div class="flex justify-center">
                <div class="bg-white p-8 rounded-lg shadow-lg">

                    <form method="post" action="register.php">

                        <h5 class="font-semibold mb-3 mt-3 pb-3 text-lg text-blue-800">Create an account</h5>

                        <div class="mb-3">
                            <input type="text" name="prenom" class="form-input w-full border rounded-md p-2" id="floatingInput" placeholder="Prénom" required>
                        </div>
                        <div class="mb-3">
                            <input type="text" name="nom" class="form-input w-full border rounded-md p-2" id="floatingInput" placeholder="Nom" required>
                        </div>
                        <div class="mb-3">
                            <input type="email" name="email" class="form-input w-full border rounded-md p-2" id="floatingInput" placeholder="Email address" required>
                        </div>
                        <div class="mb-3">
                            <input type="password" name="password" class="form-input w-full border rounded-md p-2" id="floatingPassword" placeholder="Password" required>
                        </div>

                        <div class="mt-3 flex justify-end">
                            <button class="bg-blue-800 text-white px-4 py-2 rounded-lg" type="submit" name="submit">Register</button>
                        </div>

                        <p class="mt-3 text-gray-800">Already have an account? <a href="index.php" class="text-blue-800"> Login here</a></p>
                    </form>
                </div>
            </div>
        </div>
    </section>

</body>

</html>
