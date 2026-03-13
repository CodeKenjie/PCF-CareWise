<?php require __DIR__ . "/partials/header.php" ?>
<main id="registerAccount">
    <button  id="loginButton" class="bigButton" type="button">Login</button>
    <form id="register"  method="post" action="/register/store">
        <header>
            <img src="images/logo.png" alt="">
            <h1>Register Account</h1>
        </header>
        <div>
            <h3 id="ul">Username</h3>
            <input name="username" id="username" class="textField" type="text" required>
            <h3>First name</h3>
            <input name="firstName" class="textField" type="text" required>
            <h3>Last name</h3>
            <input name="lastName" class="textField" type="text" required>
            <h3>Birthdate</h3>
            <input name="birthdate" class="textField" type="date" required>
            <h3>Address</h3>
            <input name="address" class="textField" type="text" required>
            <section>
                <input name="sex" id="sex" class="textField" value="male" type="text" hidden>
                <select id="selectedSex" onchange="updateInput(`sex`, this.value)" required>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                </select>
                <input name="role" id="position" class="textField" type="text" hidden>
                <select id="selectedPosition" onchange="updateInput(`position`, this.value)" required>
                    <option value="">Position</option>
                    <option value="admin(editor)">ADMIN (editor)</option>
                    <option value="staff(viewer)">staff (viewer)</option>
                </select>
            </section>
            <h3 id="el">Email</h3>
            <input name="email" id="email" class="textField" type="text" placeholder="example@example.com" required>
            <h3 id="pl">Password</h3>
            <span>
                <input name="password" id="password" class="textField" type="password" required>
                <img id="viewPass" class="icon" src="/images/hide.svg" alt="view" role="button" tabindex="0" onclick="view(`viewPass`, `password`)">
            </span>
            <p id="strength"></p>
            <h3 id="cpl">Confirm Password</h3>
            <span>
                <input name="conf_password" id="confPassword"class="textField" type="password" required>
                <img id="viewConfPass" class="icon" src="/images/hide.svg" alt="view" role="button" tabindex="0" onclick="view(`viewConfPass`, `confPassword`)">
            </span>               
            <span>
               <input name="accept" type="checkbox"><label id="terms" for="terms"> I accept <a href="">terms and condition</a></label>
            </span>
        </div>
        <button class="bigButton" type="submit">Create Account</button>
    </form>
</main>
<?php require __DIR__ . "/partials/footer.php" ?>