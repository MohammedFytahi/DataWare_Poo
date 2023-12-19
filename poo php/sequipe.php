<?php
include "Scrum.php";

$database = new PDO("mysql:host=localhost;dbname=dataware", "root", "");

$scrumMaster = new Scrum(null, null, null, null, null, null);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_equipe = $_POST["id_equipe"];
    $id_user = $_POST["id_user"];

    $message = $scrumMaster->removeMemberFromTeam($id_equipe, $id_user);

    echo $message;
}

$resultEquipe = $scrumMaster->getTeams();
$resultUserInEquipe = $scrumMaster->getUsersInTeam();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Retirer Membre d'Équipe</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">

    <div class="container mx-auto mt-8">
        <h2 class="text-3xl font-bold my-4">Retirer Membre d'Équipe</h2>

        <form method="post" class="space-y-4">
            <div class="mb-4">
                <label for="id_equipe" class="block text-gray-700 text-sm font-bold mb-2">Sélectionner Équipe:</label>
                <select id="id_equipe" name="id_equipe" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    <?php while ($rowEquipe = $resultEquipe->fetch(PDO::FETCH_ASSOC)) : ?>
                        <option value="<?php echo $rowEquipe['id_equipe']; ?>"><?php echo $rowEquipe['nom_equipe']; ?></option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div class="mb-4">
                <label for="id_user" class="block text-gray-700 text-sm font-bold mb-2">Sélectionner Membre à Retirer:</label>
                <select id="id_user" name="id_user" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    <?php while ($rowUserInEquipe = $resultUserInEquipe->fetch(PDO::FETCH_ASSOC)) : ?>
                        <option value="<?php echo $rowUserInEquipe['id_user']; ?>"><?php echo $rowUserInEquipe['nom'] . ' ' . $rowUserInEquipe['prenom']; ?></option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div class="flex items-center justify-between">
                <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Retirer de l'équipe
                </button>
            </div>
        </form>
    </div>
</body>

</html>
