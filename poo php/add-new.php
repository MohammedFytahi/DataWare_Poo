<?php
include "Scrum.php";

$database = new PDO("mysql:host=localhost;dbname=dataware", "root", "");

if (isset($_POST["submit"])) {
    $email = $_POST["email"];
    $password = $_POST["password"];

    $scrumMaster = new Scrum($nom, $prenom, $email, $tel, $equipe, $statut);
    
    $error = $scrumMaster->authenticateUser($password);

    if ($error) {
        echo $error;
    }

    $nom_equipe = $_POST['nom_equipe'];
    $description_equipe = $_POST['description_equipe'];
    $date_creation_equipe = $_POST['date_creation_equipe'];

    $scrumMaster->addNewTeam($nom_equipe, $description_equipe, $date_creation_equipe);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">

   <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

   <title>Document</title>
</head>

<body>
<nav class="bg-gray-800">
  <!-- ... (unchanged) ... -->
</nav>

<div class="container mx-auto">
  <div class="text-center mb-4">
    <h3 class="text-3xl">Add New User</h3>
    <p class="text-gray-600">Complete the form below to add a new user</p>
  </div>

  <div class="flex justify-center">
    <form class="max-w-sm mx-auto" action="" method="post">
      <div class="mb-5">
        <label for="nom_equipe" class="block mb-2 text-sm font-medium text-gray-900">Nom de l'équipe:</label>
        <input type="text" name="nom_equipe" id="nom_equipe" class="block w-full p-4 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 sm:text-md focus:ring-blue-500 focus:border-blue-500">
      </div>
      <div class="mb-5">
        <label for="description_equipe" class="block mb-2 text-sm font-medium text-gray-900">Description de l'équipe:</label>
        <textarea name="description_equipe" id="description_equipe" class="block w-full p-4 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 sm:text-md focus:ring-blue-500 focus:border-blue-500"></textarea>
      </div>
      <div class="mb-5">
        <label for="date_creation_equipe" class="block mb-2 text-sm font-medium text-gray-900">Date de création:</label>
        <input type="date" name="date_creation_equipe" id="date_creation_equipe" class="block w-full p-4 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 sm:text-md focus:ring-blue-500 focus:border-blue-500">
      </div>
      
      <div>
        <button type="submit" name="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-700">Ajouter Equipe</button>
      </div>
    </form>
  </div>
</div>

</body>

</html>
