<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PCF:CareWise - Register</title>
    <link rel="icon" href="assets/images/logo.png"/>
    <link rel="stylesheet" href="assets/css/style.css"/>
    <link rel="stylesheet" href="assets/css/media.css"/>
</head>
<body>
    <div id="responseContainer"></div>
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
            <form class="form-ui" action="/register" method="post">
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
                <div class="p-md" style="display: flex; gap: 0.5em">
                    <input name="accept" type="checkbox" required>
                    <label for="accept" style="display:flex; gap: 0.25em">Accept the<span id="TCBtn" style="font-weight: var(-bold); color: purple; cursor:pointer">terms and condition</span></label>
                </div>
                <input type="submit" value="Register Account">
            </form>
        </section>
    </main>
    <div class="popup">
        <div class="acrylic-bg p-sm" style=" display: flex; flex-direction: column; gap: 0.2em">
            <span class="btn-close btn-highlight" onclick="closePopup()"></span>
            <div id="tnc">
                <h1>Terms and Condition</h1>
                <hr>
                <div class="p-sm" style="display: grid; gap: 1em">
                    <h3>Introduction</h3>
                    <p>Welcome to <strong>Philadelphia Christ center Fellowship</strong>. By accessing or using this website and its medical services platform, you agree to comply with and be bound by these Terms and Conditions.</p>
                    <p>These Terms apply to all users, including patients, clinic staff, administrators, doctors, nurses, and other authorized personnel using the system.</p>
                    <p>If you do not agree with any part of these Terms, you must discontinue use of the platform immediately.</p>
                    <h3>Purpose of the Platform</h3>
                    <p>This platform is designed to:</p>
                    <ul style="list-style-type: disc; padding:0 1em">
                        <li>Manage clinic operations</li>
                        <li>Store and process patient medical records</li>
                        <li>Assist in generating preliminary diagnoses</li>
                        <li>Provide prescription management</li>
                        <li>Facilitate appointment scheduling</li>
                    </ul>
                    <p>The platform is intended solely for lawful medical and administrative purposes.</p>
                </div>
            </div>
        </div>
    </div>
    <script src="assets/js/script.js" defer></script>
</body>
</html>