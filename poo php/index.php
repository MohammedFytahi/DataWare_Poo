<?php
include "users.php"; // Make sure to include the Users class file

$database = new PDO("mysql:host=localhost;dbname=dataware", "root", "");

if (isset($_POST["submit"])) {
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Assuming you have retrieved user data and created an instance of the Users class
    $user = new Users(null, null, $email, null, null, null, null, $database);

    // Call the authenticateUser method
    $error = $user->authenticateUser($password);

    // Check for authentication error
    if ($error) {
        echo $error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Include Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-50 dark:bg-gray-900">
    <section class="flex flex-col items-center justify-center h-screen">
        <div class="bg-white p-8 rounded-lg shadow-lg">
            <h1 class="text-2xl font-bold mb-6">Sign in to your account</h1>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-900">Your email</label>
                    <input type="email" name="email" id="email" class="w-full border rounded-md p-2" placeholder="name@company.com" required>
                </div>
                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-900">Password</label>
                    <input type="password" name="password" id="password" class="w-full border rounded-md p-2" placeholder="••••••••" required>
                </div>
                <button type="submit" name="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">Sign in</button>
                <p class="mt-3 text-gray-800">Don’t have an account yet? <a href="register.php" class="text-blue-800">Sign up</a></p>
            </form>
        </div>
    </section>
</body>

</html>
