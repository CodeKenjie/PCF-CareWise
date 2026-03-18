<?php require __DIR__ . '/partials/header.php' ?>
<main id="loginAccount">
    <div id="responseContainer" ></div>
    <button id="registerButton" class="bigButton" type="button">Register</button>
    <form id="login" action="" method="post">
        <header>
            <img src="assets/images/logo.png" alt="">
            <h1>PCCF:CareWise</h1>
        </header>
        <div>
            <input name="email" id="email" class="textField" type="text" placeholder="Email" required>
            <span>
                <input name="password" id="password" class="textField" type="password" placeholder="Password" required><img src="/" alt="">
                <img id="viewPass" class="icon" src="assets/images/view.svg" alt="show" role="button" tabindex="0" onclick="view(`viewPass`, `password`)">
            </span>
            <span class="sub-container"><input type="checkbox"><label for="remember">Remember me</label></span>
        </div>
        <button class="bigButton" type="submit">Login</button>
    </form>
    <script src="js/script.js" defer></script>
</main>
<?php require __DIR__ . '/partials/footer.php' ?>