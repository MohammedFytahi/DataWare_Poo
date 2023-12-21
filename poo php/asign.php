<?php
include "connexion.php";
include "Owner.php";

$database = new Database();
$conn = $database->getConnection();

$owner = new Owner('', '', '', '', '', '', '', $conn);

if (isset($_POST["submit"])) {
    $selectedProject = $_POST["projet"];
    $selectedScrumMaster = $_POST["scrumMaster"];

    $owner->assignScrumMaster($selectedProject, $selectedScrumMaster);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
</head>
<body>
    <section>
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col col-xl-10">
                    <div class="card" style="border-radius: 1rem;">
                        <div class="d-flex justify-content-end px-3 py-1 "><a href="MembreP.php" class="text-danger fs-5"><i class="bi bi-x-lg"></i></a></div>
                        <div class="row g-0">
                            <div class="col-md-6 col-lg-5 d-none px-2 d-md-flex align-items-center">
                                <img src="data.png" alt="login form" class="img-fluid"  />
                            </div>
                            <div class="col-md-6 col-lg-7 d-flex align-items-center">
                                <div class="card-body text-black">
                                    <form method="post" action="">
                                        <h5 class="fw-semibold mb-3 mt-3 pb-3" style="letter-spacing: 1px;">Affecter un Scrum Master à un Projet</h5>
                                        <label for="cars" class="my-2">Sélectionnez le Projet :</label>
                                        <select class="form-select" aria-label="Default select example" name="projet">
                                            <?php
                                            $queryProjects = $conn->query("SELECT id_projet, nom_projet FROM projets WHERE scrum_master IS NULL;");
                                            while ($project = $queryProjects->fetch(PDO::FETCH_ASSOC)) {
                                                echo "<option value='{$project['id_projet']}'>{$project['nom_projet']}</option>";
                                            }
                                            ?>
                                        </select>
                                        <label for="cars" class="my-2">Sélectionnez le Scrum Master :</label>
                                        <select class="form-select" aria-label="Default select example" name="scrumMaster">
                                            <?php
                                            $queryScrumMasters = $conn->query("SELECT id_user, prenom FROM users WHERE role = 'scrum_master'");
                                            while ($scrumMaster = $queryScrumMasters->fetch(PDO::FETCH_ASSOC)) {
                                                echo "<option value='{$scrumMaster['id_user']}'>{$scrumMaster['prenom']}</option>";
                                            }
                                            ?>
                                        </select>
                                        <div class="pt-1 mb-3 d-flex mt-2 justify-content-end">
                                            <button class="btn btn-primary btn-lg btn-block" type="submit" name="submit">Valider</button> 
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>
</html>
