<?php

include "Scrum.php";

$database = new PDO("mysql:host=localhost;dbname=dataware", "root", "");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_equipe = $_POST["id_equipe"];
    $id_user = $_POST["id_user"];

    $scrumMaster = new Scrum(null, null, null, null, null, null); 

    $message = $scrumMaster->addMemberToTeam($id_equipe, $id_user);

    echo $message;
}

$queryEquipe = "SELECT * FROM equipe";
$resultEquipe = $database->query($queryEquipe);

$queryUser = "SELECT users.*, equipe.nom_equipe, equipe.id_equipe FROM users LEFT JOIN equipe ON users.id_equipe = equipe.id_equipe";
$resultUser = $database->query($queryUser);
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <title>Ajouter Utilisateur à Équipe</title>

    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">



    <div class="container mx-auto mt-8">
        <h2 class="text-3xl font-bold my-4">Ajouter Utilisateur à Équipe</h2>

        <form method="post" class="space-y-4">
            <div class="mb-4">
                <label for="id_equipe" class="block text-gray-700 text-sm font-bold mb-2">Sélectionner Équipe:</label>
                <select id="id_equipe" name="id_equipe" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    <?php while ($rowEquipe = mysqli_fetch_assoc($resultEquipe)) : ?>
                        <option value="<?php echo $rowEquipe['id_equipe']; ?>"><?php echo $rowEquipe['nom_equipe']; ?></option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div class="mb-4">
                <label for="id_user" class="block text-gray-700 text-sm font-bold mb-2">Sélectionner Utilisateur:</label>
                <select id="id_user" name="id_user" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    <?php while ($rowUser = mysqli_fetch_assoc($resultUser)) : ?>
                        <option value="<?php echo $rowUser['id_user']; ?>"><?php echo $rowUser['nom'] . ' ' . $rowUser['prenom'] . ' - ' . $rowUser['nom_equipe'] . ' (ID équipe: ' . $rowUser['id_equipe'] . ')'; ?></option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div class="flex items-center justify-between">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Ajouter à l'équipe
                </button>
            </div>
        </form>
    </div>

    

</body>

</html>

