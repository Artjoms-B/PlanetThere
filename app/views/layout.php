<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Planet There</title>
    <link rel="icon" href="/assets/images/favicon.png" type="image/png">

    <!-- Global styles -->
    <link rel="stylesheet" href="/assets/css/navbar.css">
    <link rel="stylesheet" href="/assets/css/global.css">
    <link rel="stylesheet" href="/assets/css/footer.css">
    <link rel="stylesheet" href="/assets/fonts/fontawesome-free-6.7.2-web/css/all.min.css">


    <!-- Page-specific styles -->
<link rel="stylesheet" href="<?php
    switch (getCurrentRoute()) {
        case '':
            echo '/assets/css/homepage.css'; break;
        case 'about':
            echo '/assets/css/about-us.css'; break;
        case 'faq':
            echo '/assets/css/faq.css'; break;
        case 'tac':
            echo '/assets/css/terms.css'; break;
        case 'account':
            echo '/assets/css/account.css'; break;
        case 'event-history':
            echo '/assets/css/events-history.css'; break;
        case 'profile-settings':
            echo '/assets/css/profile-settings.css'; break;
        case 'unauthorized':
            echo '/assets/css/blocked.css'; break;
        case 'signup-1':
            echo '/assets/css/signup-1.css'; break;
        case 'signup-2':
            echo '/assets/css/signup-2.css'; break;
        case 'login':
            echo '/assets/css/login.css'; break;
        case 'forgot-1':
            echo '/assets/css/forgot-1.css'; break;
        case 'forgot-2':
            echo '/assets/css/forgot-2.css'; break;
        case 'event-search':
            echo '/assets/css/event-search.css'; break;
        case 'user-search':
            echo '/assets/css/user-search.css'; break;
        case 'settings':
            echo '/assets/css/settings.css'; break;
        case 'create-event1':
            echo '/assets/css/create-event-1.css'; break;
        case 'create-event2':
            echo '/assets/css/create-event-2.css'; break;
        case 'friends':
            echo '/assets/css/friends.css'; break;
        case 'profile':
            echo '/assets/css/user-profile.css'; break;
        case 'event':
            echo '/assets/css/event-view.css'; break;
        case 'event-attendees':
        case 'event-waitlist':
            echo '/assets/css/event-attendees.css'; break;
        case 'blocked':
            echo '/assets/css/blocked.css'; break;
        default:
            echo '/assets/css/global.css'; break;
    }
?>">

</head>

<?php
// ---------- DARK MODE LOGIC ----------
$darkMode = false;

if (isset($_SESSION['settings']['dark_mode'])) {
    $darkMode = ((int)$_SESSION['settings']['dark_mode'] === 1);
}
?>

<?php
$raw = $_SESSION['settings']['dark_mode'] ?? null;
echo "<!-- dark_mode raw: " . var_export($raw, true) . " type: " . gettype($raw) . " -->";
?>

<body class="<?= $darkMode ? 'dark-mode' : '' ?>">
    <?php $serverDark = (int)($_SESSION['settings']['dark_mode'] ?? 0); ?>

<script>
  const serverDark = <?= $serverDark ?>;
  document.addEventListener('DOMContentLoaded', () => {
    document.body.classList.toggle('dark-mode', serverDark === 1);
  });
</script>


<?php require views_path('partials/navbar.php'); ?>

<div class="page-wrapper">
    <?= $content ?>
</div>

<?php require views_path('partials/footer.php'); ?>

<!-- DEBUG SETTINGS -->
<!--
user: <?= $_SESSION['user']['UserID'] ?? 'none' ?>
settings_user_id: <?= $_SESSION['settings_user_id'] ?? 'none' ?>
dark_mode: <?= $_SESSION['settings']['dark_mode'] ?? 'none' ?>
-->


</body>
</html>

