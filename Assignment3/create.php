<?php
$pageTitle = "Create User Profile";
$pageDesc = "Add a user profile";
require_once './inc/Database.php';
require './templates/header.php';

$success = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $bio = trim($_POST['bio']);
    $uploadedImg = $_FILES['profile_img'];

    if ($db->createUser($name, $username, $email, $bio, $uploadedImg)) {
        $success = "Your profile has been created successfully!";
    }
}
?>

<main>
    <section class="user-form">
        <h2 class="user-form">User Form</h2>
        <?php if ($success): ?>
            <p class="success"><?= htmlspecialchars($success) ?></p>
        <?php endif; ?>

        <?php if ($db->error): ?>
            <p class="error"><?= htmlspecialchars($db->error) ?></p>
        <?php endif; ?>
    </section>

    <form class="profile-form" method="POST" enctype="multipart/form-data">
        <label for="name">Name</label>
        <input type="text" id="name" name="name" required>

        <label for="username">Username</label>
        <input type="text" id="username" name="username" required>

        <label for="email">Email</label>
        <input type="email" id="email" name="email">

        <label for="bio">Bio</label>
        <textarea id="bio" name="bio" rows="4"></textarea>

        <label for="profile_img">Profile Image</label>
        <input type="file" id="profile_img" name="profile_img" required>

        <button type="submit">Submit Profile</button>
    </form>
</main>

<?php require './templates/footer.php'; ?>
