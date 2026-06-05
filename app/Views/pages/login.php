<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PCF Care - Login</title>
    <link rel="icon" href="assets/images/logo.png"/>
    <link rel="stylesheet" href="assets/css/style.css"/>
    <link rel="stylesheet" href="assets/css/media.css"/>
</head>
<body>
    <div id="responseContainer"></div>
    <main id="login">
        <section>
            <header>
                <img class="logo" src="/assets/images/logo.png" alt="">
                <h2>PCF CareWise</h2>
            </header>
            <form class="form-ui" action="/login" method="post">
                <span class="p-sm">
                    <h1 class="ctr-text spr-h">Good Day!</h1>
                    <h2 class="ctr-text sb-h">Welcome to PCF CareWise</h2>
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
                <a class="forgotten hidden" style="color: purple; cursor: pointer">Forgotten?</a>
                <div class="fc" style="gap: 0.5em">
                    <input type="submit" value="Login">
                    <a class="mediaRedirect" href="/register">I want to make an account</a>
                </div>
            </form>
        </section>
        <div class="site rel">
            <a class="redirect p-md" href="/register">Register</a>
            <img src="assets/images/site.jpg" alt="">
        </div>
    </main>
    <script src="assets/js/script.js" defer></script>
</body>
</html>