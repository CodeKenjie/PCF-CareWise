<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PCF Care - Register</title>
    <link rel="icon" href="assets/images/logo.png"/>
    <link rel="stylesheet" href="assets/css/style.css"/>
    <link rel="stylesheet" href="assets/css/media.css"/>
</head>
<body>
    <div id="responseContainer"></div>
    <main id="register" class="rel">
        <div class="site">
            <a class="redirect p-md" href="/login">Login</a>
            <img src="assets/images/register-site.jpg" alt="">
        </div>
        <section>
            <header>
                <img class="logo" src="/assets/images/logo.png" alt="">
                <h2>PCF Care</h2>
            </header>
            <form class="form-ui" action="/register" method="post">
                <span class="p-sm">
                    <h1 class="ctr-text m-h">Join our team</h1>
                    <h2 class="ctr-text sb-h">help our community</h2>
                </span>
                <span class="p-sm">
                    <input id="displayName" name="displayName" type="text" maxlength="50" required>
                    <label for="displayName">Display Name</label>
                </span>
                <div class="part p-sm">
                    <span>
                        <input id="firstName" name="firstName" type="text" maxlength="100" required>
                        <label for="firstName">First Name</label>
                    </span>
                    <span>
                        <input id="lastName" name="lastName" type="text" maxlength="100" required>
                        <label for="lastName">Last Name</label>
                    </span>
                </div>
                <div class="part p-sm">
                    <span>
                        <select name="sex" required>
                            <option value="" hidden></option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                        <label for="sex">Sex</label>
                    </span>
                    <span>
                        <select name="position" required>
                            <option value="" hidden></option>
                            <option value="Doctor">Doctor</option>
                            <option value="staff">Staff</option>
                        </select>
                        <label for="role">Position</label>
                    </span>
                </div>
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
                <h4 id="strength" class="p-sm hidden"></h4>
                <span class="p-sm">
                    <div class="password">
                        <input id="confPass" name="confPass" id="confPass" type="password" required>
                        <button type="button" onclick="view(`viewConfPass`, `confPass`)">
                            <img id="viewConfPass" class="icon" src="/assets/images/hide.svg" alt="view">
                        </button>
                    </div>
                    <label for="confPass">Confirm Password</label>
                </span>
                <div class="p-md" style="display: flex; gap: 0.5em">
                    <input name="accept" type="checkbox" required>
                    <label for="accept" style="display:flex; gap: 0.25em">Accept the<span id="TCBtn" style="font-weight: var(-bold); color: purple; cursor:pointer">terms and condition</span></label>
                </div>
                <div class="fc" style="gap: 0.5em">
                    <input type="submit" value="Register Account">
                    <a class="mediaRedirect" href="/login">I already have an account</a>
                </div>
            </form>
        </section>
    </main>
    <?php require __DIR__ . '/../partials/terms_and_condition.php'?>
    <script src="assets/js/script.js" defer></script>
</body>
</html>
