<?php require __DIR__ . "/partials/header.php" ?>
<main id="register">
    <a class="redirect p-md" href="/login">Login</a>
    <div class="site">
        <img src="assets/images/site.jpg" alt="">
    </div>
    <section>
        <header>
            <img class="logo" src="/assets/images/logo.png" alt="">
            <h2>PCF:CareWise</h2>
        </header>
        <form action="/register" method="post">
            <span class="p-sm">
                <h1 class="ctr-text spr-h">Join our team</h1>
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
            <span class="p-sm">
                <input name="birthdate" type="date" required>
                <label for="birthdate">Birthdate</label>
            </span>
            <span class="p-sm">
                <input name="address" type="text" maxlength="255" required>
                <label for="address">Address</label>
            </span>
            <div class="part p-sm">
                <select name="sex">
                    <option value="Male" selected>Male</option>
                    <option value="Female">Female</option>
                </select>
                <select name="role">
                    <option value="admin">Admin</option>
                    <option value="staff" selected>Staff</option>
                </select>
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
            <h4 id="strength" class="p-sm"></h4>
            <span class="p-sm">
                <div class="password">
                    <input id="confPass" name="confPass" id="confPass" type="password" required>
                    <button type="button" onclick="view(`viewConfPass`, `confPass`)">
                        <img id="viewConfPass" class="icon" src="/assets/images/hide.svg" alt="view">
                    </button>
                </div>
                <label for="confPass">Confirm Password</label>
            </span>
            <div class="p-md">
                <input name="accept" type="checkbox" required>
                <label for="accept">Accept the <a href="">terms and condition</a></label>
            </div>
            <input type="submit" value="Register Account">
        </form>
    </section>
</main>
<?php require __DIR__ . "/partials/footer.php" ?>