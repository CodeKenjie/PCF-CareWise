<div id="settingsPop" class="popup">
    <div id="settings" class="acrylic-bg main-panel">
        <span class="p-md">
            <h2>Settings</h2>
            <button class="btn-close btn-highlight" onclick="closePopup()"></button>
        </span>
        <div>
            <ul>
                <li class="option selected" onclick="showTab(`account`, this)">Account</li>
                <li class="option" onclick="showTab(`display`, this)">Display</li>
            </ul>
            <div id="accountSettings" class="tab">
                <form id="changePasswordForm" class="form-ui p-sm" style="border: none">
                    <h3 class="p-sm">Change password</h3>
                    <span class="p-sm">
                        <div class="password">
                            <input id="currentPassword" type="password" required>
                            <button type="button" onclick="view(`viewCurrentPass`, `currentPassword`)">
                                <img id="viewCurrentPass" class="icon" src="/assets/images/hide.svg" alt="view">
                            </button>
                        </div>
                        <label for="currentPassword">Password</label>
                    </span>
                    <span class="p-sm">
                        <div class="password">
                            <input id="newPassword" type="password" required>
                            <button type="button" onclick="view(`viewNewPass`, `newPassword`)">
                                <img id="viewNewPass" class="icon" src="/assets/images/hide.svg" alt="view">
                            </button>
                        </div>
                        <label for="newPassword">New Password</label>
                    </span>
                    <h4 id="strength" class="p-sm hidden"></h4>
                    <span class="p-sm">
                        <div class="password">
                            <input id="confirmNewPassword" type="password" required>
                            <button type="button" onclick="view(`viewConfPass`, `confirmNewPassword`)">
                                <img id="viewConfPass" class="icon" src="/assets/images/hide.svg" alt="view">
                            </button>
                        </div>
                        <label for="confirmNewPassword">Confirm Password</label>
                    </span>
                    <span class="p-sm">
                        <button class="btn-borderless btn-accent" style="color:var(--alt-font-color); background: var(--button-color); font-size: var(--normal); width:fit-content">Save</button>
                    </span>
                </form>
                <div class="p-md">
                    <h3 style="padding: 0.5em 0;">Delete Account</h3>
                    <p style="font-weight: var(--bold); opacity: 50%"><span style="color: var(--critical)">WARNING:</span> Once you deleted your account there is no way of recovering it all  your data will be loss forever.</p>
                    <button id="deleteAccountBtn" class="btn-borderless btn-critical" style="margin: 1em">Delete Account</button>
                </div>
            </div>
            <div id="displaySettings" class="tab">
                <h3 class="p-sm">Appearance</h3>
                <span class="f p-sm">
                    <label for="">Button Color: </label>
                    <input type="color">
                </span>
                <span class="f p-sm">
                    <label for="">Font: </label>
                    <select name="" id="">
                        <option value="" selected>Arial</option>
                        <option value="">Poppins</option>
                        <option value="">Verdana</option>
                        <option value="">Times</option>
                    </select>
                </span>
                <h3 class="p-sm">Theme</h3>
                <span class="p-sm">
                    <select name="" id="">
                        <option value="" selected>Default</option>
                        <option value="">Light</option>
                        <option value="">Dark</option>
                    </select>
                </span>
                <span class="p-md" style="align-self: end">
                    <button class="btn-bordered btn-highlight">Default Settings</button>
                </span>
            </div>
        </div>
    </div>
</div>

<div id="deleteAccount" class="delete popup">
    <form id="deleteAccountForm" class="form-ui" action="/patients/delete" method="post">
        <header>
            <svg class="svg icon" viewBox="-5.5 0 32 32" version="1.1" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <title>warning</title> <path d="M10.16 25.92c-2.6 0-8.72-0.24-9.88-2.24-1.28-2.28 2.040-8.24 3.080-10.040 1.040-1.76 4.64-7.56 7.12-7.56 2.8 0 7.24 7.48 8.56 10.12 1.92 3.84 2.48 6.4 1.56 7.6-1.52 2.040-8.96 2.12-10.44 2.12zM10.48 7.72c-0.72 0-3.080 2.36-5.64 6.76-2.76 4.68-3.48 7.72-3.080 8.4 0.32 0.56 3.2 1.4 8.4 1.4 5.44 0 8.64-0.88 9.080-1.48 0.28-0.36 0.040-2.28-1.72-5.84-2.64-5.28-6.12-9.24-7.040-9.24zM10.52 19.2c-0.48 0-0.84-0.36-0.84-0.84v-6.36c0-0.48 0.36-0.84 0.84-0.84s0.84 0.36 0.84 0.84v6.32c0 0.48-0.4 0.88-0.84 0.88zM11.36 21.36c0 0.464-0.376 0.84-0.84 0.84s-0.84-0.376-0.84-0.84c0-0.464 0.376-0.84 0.84-0.84s0.84 0.376 0.84 0.84z"></path> </g></svg>
            <h4>Delete Your Account</h4>
        </header>
        <hr style="height: 1px; color: var(--border-color);">
        <span class="p-md">
            <p>Are you sure that you want to delete your Account?</p>
            <p style="font-weight: var(--bold); opacity: 50%"><span style="color: var(--critical)">WARNING:</span> Once you deleted your account there is no way of recovering it all  your data will be loss forever.</p>
        </span>
        <div>
            <button class="btn-square btn-critical" type="submit">Delete</button>
            <button id="deleteAccountCancel" class="btn-square btn-highlight" type="button">Cancel</button>
        </div>
    </form>
</div>