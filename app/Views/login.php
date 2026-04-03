<?php require __DIR__ . '/partials/header.php' ?>
<main id="login">
    <a class="redirect p-md" href="/register">Register</a>
    <section>
        <header>
            <img class="logo" src="/assets/images/logo.png" alt="">
            <h2>PCF:CareWise</h2>
        </header>
        <form class="form-ui" action="/login" method="post">
            <span class="p-sm">
                <h1 class="ctr-text spr-h">Hi Nurse</h1>
                <h2 class="ctr-text sb-h">Welcome to CareWise</h2>
            </span>
            <span class="p-sm">
                <input id="email" name="email" type="email" maxlength="150" required>
                <label for="email">Email</label>
            </span>
            <span class="p-sm">
                <div class="password">
                    <input id="password" name="password" id="password" type="password" required>
                    <button type="button" onclick="view(`viewPass`, `password`)">
                        <img id="viewPass" class="icon" src="/assets/images/hide.svg" alt="view">
                    </button>
                </div>
                <label for="password">Password</label>
            </span>
            <a class="forgotten" href="#">Forgotten?</a>
            <input type="submit" value="Login">
        </form>
    </section>
    <div class="site">
        <img src="assets/images/site.jpg" alt="">
    </div>
</main>
<?php require __DIR__ . '/partials/footer.php' ?>