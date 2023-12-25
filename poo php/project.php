<?php
session_start();


include 'Owner.php';

// Assurez-vous que les clés existent dans la session
$nom = isset($_SESSION['nom']) ? $_SESSION['nom'] : '';
$prenom = isset($_SESSION['prenom']) ? $_SESSION['prenom'] : '';
$email = isset($_SESSION['email']) ? $_SESSION['email'] : '';
$tel = isset($_SESSION['tel']) ? $_SESSION['tel'] : '';
$role = isset($_SESSION['role']) ? $_SESSION['role'] : '';
$equipe = isset($_SESSION['equipe']) ? $_SESSION['equipe'] : '';
$statut = isset($_SESSION['statut']) ? $_SESSION['statut'] : '';

// Créez une instance de la classe Owner en passant les paramètres nécessaires
$owner = new Owner($nom, $prenom, $email, $tel, $role, $equipe, $statut, $conn);

// Utilisez la méthode pour obtenir tous les projets
$projects = $owner->getAllProjects();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete_id"])) {
  $projetId = $_POST["delete_id"];
  if ($owner->deleteProject($projetId)) {
      // Redirect after successful deletion
      header("Location: project.php");
      exit();
  } else {
      // Handle deletion failure, if needed
      echo "Error deleting project.";
  }
}
// Fetch all projects using PDO
$sql = "SELECT * FROM projets";
$statement = $conn->query($sql);

// Check if the query was successful
if (!$statement) {
    // Handle the error, e.g., display an error message
    die("Query failed: " . implode(" ", $conn->errorInfo()));
}

// Fetch the results
$projects = $statement->fetchAll(PDO::FETCH_ASSOC);
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
<nav class="bg-gray-800">
  <div class="mx-auto max-w-7xl px-2 sm:px-6 lg:px-8">
    <div class="relative flex h-16 items-center justify-between">
      <div class="absolute inset-y-0 left-0 flex items-center sm:hidden">
        <!-- Mobile menu button-->
        <button type="button" class="relative inline-flex items-center justify-center rounded-md p-2 text-gray-400 hover:bg-gray-700 hover:text-white focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white" aria-controls="mobile-menu" aria-expanded="false">
          <span class="absolute -inset-0.5"></span>
          <span class="sr-only">Open main menu</span>
          <!--
            Icon when menu is closed.

            Menu open: "hidden", Menu closed: "block"
          -->
          <svg class="block h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
          </svg>
          <!--
            Icon when menu is open.

            Menu open: "block", Menu closed: "hidden"
          -->
          <svg class="hidden h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
      </div>
      <div class="flex flex-1 items-center justify-center sm:items-stretch sm:justify-start">
        <div class="flex flex-shrink-0 items-center">
          <img class="h-8 w-auto" src="ware.png" alt="Your Company">
        </div>
        <div class="hidden sm:ml-6 sm:block">
          <div class="flex space-x-4">
            <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->
            <a href="interface.php" class="bg-gray-900 text-white rounded-md px-3 py-2 text-sm font-medium" aria-current="page">Membres</a>
            <a href="equipU.php" class="text-gray-300 hover:bg-gray-700 hover:text-white rounded-md px-3 py-2 text-sm font-medium">Team</a>
            <a href="project.php" class="text-gray-300 hover:bg-gray-700 hover:text-white rounded-md px-3 py-2 text-sm font-medium">Projects</a>
            
          </div>
        </div>
      </div>
      <div class="absolute inset-y-0 right-0 flex items-center pr-2 sm:static sm:inset-auto sm:ml-6 sm:pr-0">
        <button type="button" class="relative rounded-full bg-gray-800 p-1 text-gray-400 hover:text-white focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800">
          <span class="absolute -inset-1.5"></span>
          <span class="sr-only">View notifications</span>
          <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
          </svg>
        </button>

        <!-- Profile dropdown -->
        <div class="relative ml-3">
          <div>
            <button type="button" class="relative flex rounded-full bg-gray-800 text-sm focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800" id="user-menu-button" aria-expanded="false" aria-haspopup="true">
              <span class="absolute -inset-1.5"></span>
              <span class="sr-only">Open user menu</span>
              <img class="h-8 w-8 rounded-full" src="https://intranet.youcode.ma/storage/users/profile/thumbnail/766-1696615639.jpg" alt="">
            </button>
          </div>

          <!--
            Dropdown menu, show/hide based on menu state.

            Entering: "transition ease-out duration-100"
              From: "transform opacity-0 scale-95"
              To: "transform opacity-100 scale-100"
            Leaving: "transition ease-in duration-75"
              From: "transform opacity-100 scale-100"
              To: "transform opacity-0 scale-95"
          -->
          
        </div>
        <form action="logout.php" method="post">
          <button type="submit" class="relative rounded-full bg-gray-800 p-1 text-gray-400 hover:text-white focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800">
            <span class="absolute -inset-1.5"></span>
            <span class="sr-only">Logout</span>
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
              <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l3 3m0 0l-3 3m3-3H5"></path>
            </svg>
          </button>
        </form>
      </div>
    </div>
  </div>

  <!-- Mobile menu, show/hide based on menu state. -->
  <div class="sm:hidden" id="mobile-menu">
    <div class="space-y-1 px-2 pb-3 pt-2">
      <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->
      <a href="#" class="bg-gray-900 text-white block rounded-md px-3 py-2 text-base font-medium" aria-current="page">Dashboard</a>
      <a href="#" class="text-gray-300 hover:bg-gray-700 hover:text-white block rounded-md px-3 py-2 text-base font-medium">Team</a>
      <a href="#" class="text-gray-300 hover:bg-gray-700 hover:text-white block rounded-md px-3 py-2 text-base font-medium">Projects</a>
      
    </div>
  </div>
</nav>
<div class="container mx-auto bg-white p-8 rounded-md shadow-md">
    <h1 class="text-2xl font-bold mb-4">Tableau des Projets</h1>

    <div class="flex">
        <a href="add-proj.php" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded mb-4 inline-block">
            Ajouter un nouveau projet
        </a>
        <a href="asign.php" class="bg-green-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-4 ml-4">
            <i class="bi bi-bookmark-plus-fill"></i> Affecter un Scrum Master à un Projet
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-300">
            <thead class="bg-gray-200">
                <tr>
                    <th class="border border-gray-300 px-4 py-2">Nom du Projet</th>
                    <th class="border border-gray-300 px-4 py-2">Description</th>
                    <th class="border border-gray-300 px-4 py-2">Date de début</th>
                    <th class="border border-gray-300 px-4 py-2">Date de fin</th>
                    <th class="border border-gray-300 px-4 py-2">Statut</th>
                    <th class="border border-gray-300 px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($projects as $row) : ?>
    <tr>
        <td class="border border-gray-300 px-4 py-2"><?= $row['nom_projet'] ?></td>
        <td class="border border-gray-300 px-4 py-2"><?= $row['description'] ?></td>
        <td class="border border-gray-300 px-4 py-2"><?= $row['date_debut'] ?></td>
        <td class="border border-gray-300 px-4 py-2"><?= $row['date_fin'] ?></td>
        <td class="border border-gray-300 px-4 py-2"><?= $row['statut'] ?></td>
        <td class="border border-gray-300 px-4 py-2">
            <a href='modif-proj.php?id=<?= $row['id_projet'] ?>' class="text-blue-500 hover:underline">Modifier</a>
            <span class="text-gray-400 mx-1">|</span>
            <form action="project.php" method="post" style="display: inline-block;">
                    <input type="hidden" name="delete_id" value="<?= $row['id_projet'] ?>">
                    <button type="submit" class="text-red-500 hover:underline" onclick="return confirm('Are you sure you want to delete this project?')">Supprimer</button>
                </form>
        </td>
    </tr>
<?php endforeach; ?>

            </tbody>
        </table>
    </div>
</div>
</body>
</html>