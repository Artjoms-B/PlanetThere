<?php

if (!isset($settings) || !is_array($settings)) {
    $settings = [
        'language' => 'english',
        'dark_mode' => 0,
        'privacy' => 0,
        'notifications' => 1
    ];
}

$language = $settings['language'] ?? 'english';
$dark = (int)($settings['dark_mode'] ?? 0);
$privacy = (int)($settings['privacy'] ?? 0);
$notifications = (int)($settings['notifications'] ?? 1);
?>

<div class="settings-page">

    <header class="settings-header">
        <h1>Settings</h1>
        <p>Adjust your preferences</p>
    </header>

    <form id="settingsForm" action="/settings/save" method="POST">

        <section class="settings-options">

            <div class="settings-item">
                <label for="language-select">Choose your <span class="highlight">language</span>:</label>
                <select id="language-select" name="language" class="dropdown">
                    <option value="english" <?= $language === 'english' ? 'selected' : '' ?>>English</option>
                    <option value="french"  <?= $language === 'french'  ? 'selected' : '' ?>>French</option>
                </select>
            </div>

            <div class="settings-item">
                <label for="dark-mode-toggle">Enable <span class="highlight">Dark Mode</span>:</label>
                <div class="switch">
                    <input type="checkbox" id="dark-mode-toggle" name="dark_mode" value="1"
                           <?= $dark === 1 ? 'checked' : '' ?>>
                    <div class="slider"></div>
                </div>
            </div>

            <div class="settings-item">
                <label for="privacy-toggle">Attended Event <span class="highlight">Privacy</span>:</label>
                <div class="switch">
                    <input type="checkbox" id="privacy-toggle" name="privacy" value="1"
                           <?= $privacy === 1 ? 'checked' : '' ?>>
                    <div class="slider"></div>
                </div>
            </div>

            <div class="settings-item">
                <label for="notifications-toggle"><span class="highlight">Notification</span> settings:</label>
                <div class="switch">
                    <input type="checkbox" id="notifications-toggle" name="notifications" value="1"
                           <?= $notifications === 1 ? 'checked' : '' ?>>
                    <div class="slider"></div>
                </div>
            </div>

            <div class="settings-save-button-container">
                <button type="submit" class="settings-save-button">Save Changes</button>
            </div>

        </section>
    </form>

</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
  const serverDark = <?= $dark ?>;

  const toggle = document.getElementById('dark-mode-toggle');
  const logo = document.getElementById('logo');

  document.body.classList.toggle('dark-mode', serverDark === 1);

  if (logo) {
    logo.src = serverDark === 1
      ? '/assets/images/logo-text-white.svg'
      : '/assets/images/logo-text.svg';
  }

  if (toggle) {
    toggle.addEventListener('change', (e) => {
      document.body.classList.toggle('dark-mode', e.target.checked);

      if (logo) {
        logo.src = e.target.checked
          ? '/assets/images/logo-text-white.svg'
          : '/assets/images/logo-text.svg';
      }
    });
  }
});
</script>





