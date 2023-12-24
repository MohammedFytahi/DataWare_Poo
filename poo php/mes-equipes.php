<?php
include "Membre.php";

$message = "";
session_start();

if ($_SESSION['autoriser'] != "oui") {
    header("Location: index.php");
    exit();
}

$user = $_SESSION['username'];
$membreId = $_SESSION['id'];

$membre = new Membre(null, null, null, null, null, null, null, $database);

$memberTeams = $membre->getMemberTeams($membreId);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau des équipes</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
</head>
<body>
<nav class="bg-gray-800">
    <!-- ... (votre barre de navigation) ... -->
</nav>

<h5 class="mt-2 ms-2 text-xl font-semibold">Bienvenue <?php echo $user; ?> !</h5>
<h1 class="text-center mt-5 mb-5 text-3xl font-bold">Mes équipes</h1>

<div class="container mt-4">
    <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-2 gap-4">
        <div class="col-span-1">
            <div class="overflow-x-auto">
                <table class="table-auto w-full bg-primary mt-4 table-hover">
                    <thead>
                        <tr>
                            <th class="py-2 px-4 text-light">Nom d'équipe</th>
                            <th class="py-2 px-4 text-light">Date de création</th>
                        </tr>
                    </thead>
                    <?php
                    if (empty($memberTeams)) {
                        $message = "<span class='text-red-500'>Pas encore d'équipe.</span>";
                    } else {
                        foreach ($memberTeams as $team) {
                    ?>
                            <tbody class="table-light">
                                <tr>
                                    <td class="py-2 px-4"><?= $team['nom_equipe']; ?></td>
                                    <td class="py-2 px-4"><?= $team['date_creation_equipe']; ?></td>
                                </tr>
                            </tbody>
                    <?php
                        }
                    }
                    ?>
                </table>
            </div>
        </div>
    </div>
</div>

<p class="text-center mt-5 text-lg font-bold text-danger"><?php echo $message; ?></p>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
