<?php require __DIR__ . "/partials/header.php" ?>
<main id="register">
    <a class="redirect p-md" href="/login">Login</a>
    <img class="site" src="/assets/images/site.jpg" alt="">
    <section>
        <div class="header">
            <img class="logo" src="/assets/images/logo.png" alt="">
            <h2>PCF:CareWise</h2>
        </div>
        <form action="/register/store method="post">
            <h1 class="ctr-text">Join our team</h1>
            <h2 class="ctr-text">help our community</h2>
            <span>
                <label for="displayName">Display Name</label>
                <input name="displayName" type="text" maxlength="12">
            </span>
            <span>
                <label for="firstName">First Name</label>
                <input name="firstName" type="text">
            </span>
            <span>
                <label for="lastName">Last Name</label>
                <input name="lastName" type="text">
            </span>
            <span>
                <label for="birthdate">Birthdate</label>
                <input name="birthdate" type="date">
            </span>
            <div class="selections">
                <input name="sex" type="text" value="Male" readonly hidden>
                <select name="sexSelect" id="">
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                </select>
                <input name="role" type="text" value="staff" readonly hidden>
                <select name="roleSelect" id="">
                    <option value="staff">Staff</option>
                    <option value="admin">Admin</option>
                </select>
            </div>
            <span>
                <label for="email">Email</label>
                <input name="email" type="text">
            </span>
            <span>
                <label for="password">Password</label>
                <div class="password">
                    <input name="password" type="password">
                    <button type="button">
                        <img class="icon" src="/assets/images/view.svg" alt="view">
                    </button>
                </div>
            </span>
            <span>
                <label for="confPass">Confirm Password</label>
                <div class="password">
                    <input name="confPass" type="password">
                    <button type="button">
                        <img class="icon" src="/assets/images/view.svg" alt="view">
                    </button>
                </div>
            </span>
            <div class="p-md">
                <input name="accept" type="checkbox">
                <label for="accept">Accept the <a href="">terms and condition</a></label>
            </div>
            <input type="submit" value="Register Account">
        </form>
    </section>
</main>
<?php require __DIR__ . "/partials/footer.php" ?>