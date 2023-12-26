<?php
include_once 'Owner.php';

if (isset($_GET['id'])) {
    $userId = $_GET['id'];
    $owner = new Owner('', '', '', '', '', '', '', $conn);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $updatedName = $_POST['updated_name'];
        $updatedEmail = $_POST['updated_email'];
        $updatedRole = $_POST['updated_role'];

        $owner->updateUser($userId, $updatedName, $updatedEmail, $updatedRole);

        // Répéter la logique pour récupérer les données mises à jour ici

    } else {
        $query = "SELECT * FROM users WHERE id_user = :userId";
        $statement = $conn->prepare($query);
        $statement->bindParam(':userId', $userId, PDO::PARAM_INT);

        if ($statement->execute()) {
            $userData = $statement->fetch(PDO::FETCH_ASSOC);
        } else {
            echo "Erreur lors de la récupération des données de l'utilisateur : " . $statement->errorInfo()[2];
            exit();
        }
    }
} else {
    echo "ID utilisateur non fourni.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Balises head avec les métadonnées, les styles, etc. -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Utilisateur</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
</head>

<body class="bg-gray-200">
    <h2 class="text-center font-bold text-3xl m-10">Modifier Information Utilisateur</h2>

    <div class="container mx-auto bg-white p-8 rounded-md shadow-md max-w-md">
        <form method="post" class="space-y-4">
            <div class="mb-4">
                <label for="updated_name" class="block text-gray-700 text-sm font-bold mb-2">Nom:</label>
                <input type="text" id="updated_name" name="updated_name" value="<?= $userData['nom'] ?>" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>

            <div class="mb-4">
                <label for="updated_email" class="block text-gray-700 text-sm font-bold mb-2">Email:</label>
                <input type="email" id="updated_email" name="updated_email" value="<?= $userData['email'] ?>" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>

            <div class="mb-4">
                <label for="updated_role" class="block text-gray-700 text-sm font-bold mb-2">Role:</label>
                <select id="updated_role" name="updated_role" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    <option value="user" <?= $userData['role'] === 'user' ? 'selected' : '' ?>>User</option>
                    <option value="scrum_master" <?= $userData['role'] === 'scrum_master' ? 'selected' : '' ?>>Scrum Master</option>
                </select>
            </div>

            <div class="flex items-center justify-between">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Enregistrer
                </button>
                <a href="interface.php" class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">
                    Annuler
                </a>
            </div>
        </form>
    </div>
</body>

</html>
