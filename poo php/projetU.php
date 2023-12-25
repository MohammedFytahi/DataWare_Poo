<?php
include 'connexion.php';
include 'pr.php';

$sql = "SELECT * FROM projets";
$stmt = $conn->query($sql);
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau des Projets</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
</head>

<body>
    <div class="container mx-auto bg-white p-8 rounded-md shadow-md">
        <h1 class="text-2xl font-bold mb-4">Tableau des Projets</h1>

        <div class="overflow-x-auto">
            <table class="min-w-full border border-gray-300">
                <thead>
                    <tr>
                        <th class="border border-gray-300 px-4 py-2">Nom du Projet</th>
                        <th class="border border-gray-300 px-4 py-2">Description</th>
                        <th class="border border-gray-300 px-4 py-2">Date de Début</th>
                        <th class="border border-gray-300 px-4 py-2">Date de Fin</th>
                        <th class="border border-gray-300 px-4 py-2">Statut</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($result as $row) : ?>
                        <?php
                        $project = new Project(
                            $row['id_projet'],
                            $row['nom_projet'],
                            $row['description'],
                            $row['date_debut'],
                            $row['date_fin'],
                            $row['statut']
                        );
                        ?>
                        <tr>
                            <td class="border border-gray-300 px-4 py-2"><?= $project->getNomProjet() ?></td>
                            <td class="border border-gray-300 px-4 py-2"><?= $project->getDescription() ?></td>
                            <td class="border border-gray-300 px-4 py-2"><?= $project->getDateDebut() ?></td>
                            <td class="border border-gray-300 px-4 py-2"><?= $project->getDateFin() ?></td>
                            <td class="border border-gray-300 px-4 py-2"><?= $project->getStatut() ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>
?>
