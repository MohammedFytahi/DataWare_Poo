<?php
include "Scrum.php";

// Connexion à la base de données
$connection = new PDO("mysql:host=localhost;dbname=dataware", "root", "");

// Instantiate the Scrum class
$scrumMaster = new Scrum(null, null, null, null, null, null, $connection);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["project"]) && isset($_POST["team"])) {
        $selectedProjectId = $_POST["project"];
        $selectedTeamId = $_POST["team"];

        // Get the selected project and team using their IDs
        $selectedProject = $scrumMaster->getProjectById($selectedProjectId);
        $selectedTeam = $scrumMaster->getTeamById($selectedTeamId);

        // Utilize the Scrum class method to assign a project to a team
        $scrumMaster->assignProjectToTeam($selectedProject, $selectedTeam);
    } else {
        echo "Les données du formulaire ne sont pas définies.";
    }
}
?>


<!DOCTYPE html>
<html lang="en">


<head>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <title>Affecter Projet</title>
</head>

<body class="bg-gray-100">
    <div class="container mx-auto mt-8">
        <h2 class="text-3xl font-bold my-4">Affecter Projet</h2>

        <form method="post" action="affecte.php" class="max-w-md mx-auto bg-white p-6 rounded-md shadow-md">
            <div class="mb-4">
                <label for="project" class="block text-gray-700 text-sm font-bold mb-2">Sélectionner un projet:</label>
                <select name="project" id="project" class="w-full p-2 border rounded-md">
                    <?php foreach ($scrumMaster->getProjects() as $project) : ?>
                        <option value="<?php echo $project->getIdProjet(); ?>"><?php echo $project->getNomProjet(); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-4">
                <label for="team" class="block text-gray-700 text-sm font-bold mb-2">Sélectionner une équipe:</label>
                <select name="team" id="team" class="w-full p-2 border rounded-md">
                    <?php foreach ($scrumMaster->getTeams() as $team) : ?>
                        <option value="<?php echo $team->getIdEquipe(); ?>"><?php echo $team->getNomEquipe(); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <button type="submit" class="bg-gray-800 text-white font-bold py-2 px-4 rounded-md hover:bg-gray-600 focus:outline-none focus:shadow-outline-gray active:bg-gray-800">Affecter Projet</button>
        </form>
    </div>
</body>

</html>
