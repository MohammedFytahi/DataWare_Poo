<?php
include_once "Scrum.php";


$nom = isset($_SESSION['nom']) ? $_SESSION['nom'] : '';
$prenom = isset($_SESSION['prenom']) ? $_SESSION['prenom'] : '';
$email = isset($_SESSION['email']) ? $_SESSION['email'] : '';
$tel = isset($_SESSION['tel']) ? $_SESSION['tel'] : '';
$role = isset($_SESSION['role']) ? $_SESSION['role'] : '';
$equipe = isset($_SESSION['equipe']) ? $_SESSION['equipe'] : '';
$statut = isset($_SESSION['statut']) ? $_SESSION['statut'] : '';


$scrum = new Scrum($nom, $prenom, $email, $tel, $equipe, $statut, $conn);


$teams = $scrum->getAllTeams();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    
    <title>Liste des Équipes</title>

    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">

<nav class="bg-gray-800">
  <div class="mx-auto max-w-7xl px-2 sm:px-6 lg:px-8">
    <div class="relative flex h-16 items-center justify-between">
      <div class="absolute inset-y-0 left-0 flex items-center sm:hidden">
        <button type="button" class="relative inline-flex items-center justify-center rounded-md p-2 text-gray-400 hover:bg-gray-700 hover:text-white focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white" aria-controls="mobile-menu" aria-expanded="false">
          <span class="absolute -inset-0.5"></span>
          <span class="sr-only">Open main menu</span>
          <svg class="block h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
          </svg>
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
            <a href="home.php" class="bg-gray-900 text-white rounded-md px-3 py-2 text-sm font-medium" aria-current="page">Membres</a>
            <a href="equipe.php" class="text-gray-300 hover:bg-gray-700 hover:text-white rounded-md px-3 py-2 text-sm font-medium">Team</a>
            <a href="projetU.php" class="text-gray-300 hover:bg-gray-700 hover:text-white rounded-md px-3 py-2 text-sm font-medium">Projects</a>
          </div>
        </div>
      </div>
      <div class="absolute inset-y-0 right-0 flex items-center pr-2 sm:static sm:inset-auto sm:ml-6 sm:pr-0">
        <button type="button" class="relative rounded-full bg-gray-800 p-1 text-gray-400 hover:text-white focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800">
          <span class="absolute -inset-1.5"></span>
          <span class="sr-only">View notifications</span>
          <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.640 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
          </svg>
        </button>

        <div class="relative ml-3">
          <div>
            <button type="button" class="relative flex rounded-full bg-gray-800 text-sm focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800" id="user-menu-button" aria-expanded="false" aria-haspopup="true">
              <span class="absolute -inset-1.5"></span>
              <span class="sr-only">Open user menu</span>
              <img class="h-8 w-8 rounded-full" src="https://intranet.youcode.ma/storage/users/profile/thumbnail/766-1696615639.jpg" alt="">
            </button>
          </div>
        </div>

        <!-- Logout Button -->
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

  <div class="sm:hidden" id="mobile-menu">
    <div class="space-y-1 px-2 pb-3 pt-2">
      <a href="#" class="bg-gray-900 text-white block rounded-md px-3 py-2 text-base font-medium" aria-current="page">Dashboard</a>
      <a href="#" class="text-gray-300 hover:bg-gray-700 hover:text-white block rounded-md px-3 py-2 text-base font-medium">Team</a>
      <a href="#" class="text-gray-300 hover:bg-gray-700 hover:text-white block rounded-md px-3 py-2 text-base font-medium">Projects</a>
    </div>
  </div>
</nav>


    <div class="container mx-auto mt-8">
    <h2 class="text-3xl font-bold my-4">Liste des Équipes</h2>
    <div class="mb-4 space-x-4">
        <a href="add-new.php" class="bg-gray-800 text-white font-bold py-2 px-4 rounded-md hover:bg-gray-600 focus:outline-none focus:shadow-outline-gray active:bg-gray-800">Créer une équipe</a>
        <a href="ajout.php" class="bg-gray-800 text-white font-bold py-2 px-4 rounded-md hover:bg-gray-600 focus:outline-none focus:shadow-outline-gray active:bg-gray-800">Ajouter un membre</a>
        <a href="sequipe.php" class="bg-gray-800 text-white font-bold py-2 px-4 rounded-md hover:bg-gray-600 focus:outline-none focus:shadow-outline-gray active:bg-gray-800">Supprimer membre</a>
        <a href="affecte.php" class="bg-gray-800 text-white font-bold py-2 px-4 rounded-md hover:bg-gray-600 focus:outline-none focus:shadow-outline-gray active:bg-gray-800">Affectuer projet</a>
    </div>
    
 
       
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-300">
                <thead class="bg-gray-800 text-white">
                    <tr>
                        <th class="py-2 px-4">Team Name</th>
                        <th class="py-2 px-4">Description</th>
                        <th class="py-2 px-4">Creation Date</th>
                        <th class="py-2 px-4" colspan="2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($teams as $team) : ?>
                        <tr>
                            <td class="py-2 px-4"><?php echo $team-> getNomEquipe(); ?></td>
                            <td class="py-2 px-4"><?php echo $team->getDescription(); ?></td>
                            <td class="py-2 px-4"><?php echo $team->getCreationDate(); ?></td>
                           
                            <td class="py-2 px-4">
                                <a href="edit-team.php?id=<?php echo $team->getIdEquipe(); ?>" class="text-blue-500 hover:text-blue-800">Edit</a>
                            </td>
                            <td class="py-2 px-4">
                                <a href="delete-team.php?id=<?php echo $team->getIdEquipe(); ?>" class="text-red-500 hover:text-red-800" onclick="return confirm('Are you sure you want to delete this team?')">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>

</body>

</html>
