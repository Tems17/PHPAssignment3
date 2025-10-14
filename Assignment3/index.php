<?php
$pageTitle = "View User Profile";
$pageDesc = "This page allows users to view their created profiles";
require_once './inc/Database.php';
$users = $db->read();
if($users === false){
    $readError = "<p>No Profile Found</p>";
}
require './templates/header.php';

?>

<main class="container">
    <section class="page-header">
        <h1>User Profile</h1>
        <a href="create.php"></a>
</section>

<?php if(isset($readError)): ?>
    <section class="message">
        <p class="error"><?= htmlspecialchars($readError) ?></p>
        </section>
    <?php endif; ?>

    <?php if($users && count($users) > 0): ?>
        <section class="profile-grid">
            <?php foreach($users as $user): ?>
                <article class="profile-card">
                    <img src="<?php echo htmlspecialchars($user['profile_img']); ?>" 
                                     alt="<?php echo htmlspecialchars($user['name']); ?>" 
                                     class="profile-img">

                    <h2><?php echo htmlspecialchars($user['name']) ?></h2>
                    <p class="username"><?php echo htmlspecialchars($user['username']) ?></p>
                    <p class="email"><?php echo htmlspecialchars($user['email']) ?></p>
                    <p class="bio"><?php echo htmlspecialchars($user['bio']) ?></p>
                    <p class="created"><?php echo htmlspecialchars($user['created_at']) ?></p>
                </article>
<?php endforeach; ?>
            </section>

            <?php else: ?>
        <section class="no-profiles">
            <p>No profiles created. Create One!</p>
        </section>
    <?php endif; ?>
</main>

<?php require './templates/footer.php'; ?>
                
