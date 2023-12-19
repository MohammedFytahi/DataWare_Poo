<?php
include "connexion.php";
include "Team.php"; // Inclure la classe Team

$query = "SELECT equipe.*, GROUP_CONCAT(projets.nom_projet) as projects
          FROM equipe
          LEFT JOIN projets ON equipe.id_equipe = projets.equipe_id
          GROUP BY equipe.id_equipe";

$result = $conn->query($query);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Les balises head avec les styles et le titre -->
</head>

<body class="bg-gray-100">
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-300">
            <thead class="bg-gray-800 text-white">
                <tr>
                    <th class="py-2 px-4">Nom de l'Équipe</th>
                    <th class="py-2 px-4">Description</th>
                    <th class="py-2 px-4">Date de création</th>
                    <th class="py-2 px-4">Projets</th>
                    <th class="py-2 px-4">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch(PDO::FETCH_ASSOC)) : ?>
                    <?php
                    $team = new Team(
                        $row['id_equipe'],
                        $row['nom_equipe'],
                        $row['description_equipe'],
                        $row['date_creation_equipe']
                    );
                    ?>
                    <tr>
                        <td class="py-2 px-4"><?php echo $team->getName(); ?></td>
                        <td class="py-2 px-4"><?php echo $team->getDescription(); ?></td>
                        <td class="py-2 px-4"><?php echo $team->getCreationDate(); ?></td>
                        <td class="py-2 px-4"><?php echo $row['projects']; ?></td>
                        <td class="py-2 px-4">
                            <a href="mequipe.php?id=<?php echo $team->getId(); ?>" class="text-blue-500 hover:text-blue-800">Modifier</a>
                        </td>
                        <td class="py-2 px-4">
                            <a href="delete.php?id=<?php echo $team->getId(); ?>" class="text-red-500 hover:text-red-800" onclick="return confirm('Are you sure you want to delete this team?')">Supprimer</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>

</html>
