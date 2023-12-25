<?php
include "Scrum.php";


$database = new Database();
$conn = $database->getConnection();

$scrumMaster = new Scrum(null, null, null, null, null, null, $conn);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom_equipe = $_POST["nom_equipe"];
    $description_equipe = $_POST["description_equipe"];
    $date_creation_equipe = $_POST["date_creation_equipe"];

    $result = $scrumMaster->addNewTeam($nom_equipe, $description_equipe, $date_creation_equipe);

    echo $result;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Add Team</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">

    <div class="container mx-auto mt-8">
        <h2 class="text-3xl font-bold my-4">Add Team</h2>
        <form method="post" action="add-new.php" class="max-w-md">
            <div class="mb-4">
                <label for="nom_equipe" class="block text-gray-700 text-sm font-bold mb-2">Team Name:</label>
                <input type="text" name="nom_equipe" id="nom_equipe" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>
            <div class="mb-4">
                <label for="description_equipe" class="block text-gray-700 text-sm font-bold mb-2">Description:</label>
                <textarea name="description_equipe" id="description_equipe" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
            </div>
            <div class="mb-4">
                <label for="date_creation_equipe" class="block text-gray-700 text-sm font-bold mb-2">Creation Date:</label>
                <input type="date" name="date_creation_equipe" id="date_creation_equipe" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>
            <div class="flex items-center justify-between">
                <button type="submit" name="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Add Team
                </button>
            </div>
        </form>
    </div>

</body>

</html>
