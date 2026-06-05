<?php require __DIR__ . "/../partials/header.php" ?>
<main id="me">
    <section class="acrylic-bg main-panel">
        <div class="avatar">
            <span class="rel profile">
                <img src="<?= empty($avatar ?? '') ? 'assets/images/profile.png' : ($avatar ?? '')?>" alt="">
                <form id="avatarUploadForm" action="/me/update/avatar" method="post">
                    <span class="avatarUpload abs">
                        <label>
                            <input name="avatar" type="file" accept="image/*" hidden>
                            <svg class="upload icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path fill-rule="evenodd" clip-rule="evenodd" d="M7.59843 4.48666C7.86525 3.17678 9.03088 2.25 10.3663 2.25H13.6337C14.9691 2.25 16.1347 3.17678 16.4016 4.48666C16.4632 4.78904 16.7371 5.01086 17.022 5.01086H17.0384L17.0548 5.01157C18.4582 5.07294 19.5362 5.24517 20.4362 5.83558C21.0032 6.20757 21.4909 6.68617 21.871 7.24464C22.3439 7.93947 22.5524 8.73694 22.6524 9.70145C22.75 10.6438 22.75 11.825 22.75 13.3211V13.4062C22.75 14.9023 22.75 16.0835 22.6524 17.0258C22.5524 17.9903 22.3439 18.7878 21.871 19.4826C21.4909 20.0411 21.0032 20.5197 20.4362 20.8917C19.7327 21.3532 18.9262 21.5567 17.948 21.6544C16.9903 21.75 15.789 21.75 14.2634 21.75H9.73657C8.21098 21.75 7.00967 21.75 6.05196 21.6544C5.07379 21.5567 4.26731 21.3532 3.56385 20.8917C2.99682 20.5197 2.50905 20.0411 2.12899 19.4826C1.65612 18.7878 1.44756 17.9903 1.34762 17.0258C1.24998 16.0835 1.24999 14.9023 1.25 13.4062V13.3211C1.24999 11.825 1.24998 10.6438 1.34762 9.70145C1.44756 8.73694 1.65612 7.93947 2.12899 7.24464C2.50905 6.68617 2.99682 6.20757 3.56385 5.83558C4.46383 5.24517 5.5418 5.07294 6.94523 5.01157L6.96161 5.01086H6.978C7.26288 5.01086 7.53683 4.78905 7.59843 4.48666ZM10.3663 3.75C9.72522 3.75 9.18905 4.19299 9.06824 4.78607C8.87258 5.74659 8.021 6.50186 6.99633 6.51078C5.64772 6.57069 4.92536 6.73636 4.38664 7.08978C3.98309 7.35452 3.63752 7.6941 3.36906 8.08857C3.09291 8.49435 2.92696 9.01325 2.83963 9.85604C2.75094 10.7121 2.75 11.8156 2.75 13.3636C2.75 14.9117 2.75094 16.0152 2.83963 16.8712C2.92696 17.714 3.09291 18.2329 3.36906 18.6387C3.63752 19.0332 3.98309 19.3728 4.38664 19.6375C4.80417 19.9114 5.33844 20.0756 6.20104 20.1618C7.07549 20.2491 8.20193 20.25 9.77778 20.25H14.2222C15.7981 20.25 16.9245 20.2491 17.799 20.1618C18.6616 20.0756 19.1958 19.9114 19.6134 19.6375C20.0169 19.3728 20.3625 19.0332 20.6309 18.6387C20.9071 18.2329 21.073 17.714 21.1604 16.8712C21.2491 16.0152 21.25 14.9117 21.25 13.3636C21.25 11.8156 21.2491 10.7121 21.1604 9.85604C21.073 9.01325 20.9071 8.49435 20.6309 8.08857C20.3625 7.6941 20.0169 7.35452 19.6134 7.08978C19.0746 6.73636 18.3523 6.57069 17.0037 6.51078C15.979 6.50186 15.1274 5.74659 14.9318 4.78607C14.8109 4.19299 14.2748 3.75 13.6337 3.75H10.3663ZM12 10.75C10.7574 10.75 9.75 11.7574 9.75 13C9.75 14.2426 10.7574 15.25 12 15.25C13.2426 15.25 14.25 14.2426 14.25 13C14.25 11.7574 13.2426 10.75 12 10.75ZM8.25 13C8.25 10.9289 9.92893 9.25 12 9.25C14.0711 9.25 15.75 10.9289 15.75 13C15.75 15.0711 14.0711 16.75 12 16.75C9.92893 16.75 8.25 15.0711 8.25 13ZM17.25 10C17.25 9.58579 17.5858 9.25 18 9.25H19C19.4142 9.25 19.75 9.58579 19.75 10C19.75 10.4142 19.4142 10.75 19 10.75H18C17.5858 10.75 17.25 10.4142 17.25 10Z" fill="currentColor"></path> </g></svg>
                        </label>
                        <svg class="save icon hidden" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M15 20V15H9V20M18 20H6C4.89543 20 4 19.1046 4 18V6C4 4.89543 4.89543 4 6 4H14.1716C14.702 4 15.2107 4.21071 15.5858 4.58579L19.4142 8.41421C19.7893 8.78929 20 9.29799 20 9.82843V18C20 19.1046 19.1046 20 18 20Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                    </span>
                </form>
            </span>
        </div>
        <h1 id="displayName" class="lrg-h"><?= htmlspecialchars($displayName ?? '')?></h1>
        <div class="rel userInfo">
            <button id="editInfoBtn" class="btn-borderless btn-highlight" style="width: fit-content; align-self: end">
                <svg class="sm-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M18.9445 9.1875L14.9445 5.1875M18.9445 9.1875L13.946 14.1859C13.2873 14.8446 12.4878 15.3646 11.5699 15.5229C10.6431 15.6828 9.49294 15.736 8.94444 15.1875C8.39595 14.639 8.44915 13.4888 8.609 12.562C8.76731 11.6441 9.28735 10.8446 9.946 10.1859L14.9445 5.1875M18.9445 9.1875C18.9445 9.1875 21.9444 6.1875 19.9444 4.1875C17.9444 2.1875 14.9445 5.1875 14.9445 5.1875M20.5 12C20.5 18.5 18.5 20.5 12 20.5C5.5 20.5 3.5 18.5 3.5 12C3.5 5.5 5.5 3.5 12 3.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
            </button>
            <span>
                <strong style="opacity: 75%">Name: </strong>
                <h4><?= htmlspecialchars($lastName ?? '') . ', ' . htmlspecialchars($firstName ?? '') ?></h4>
            </span>
            <span>
                <strong style="opacity: 75%">Position: </strong>
                <h4><?= htmlspecialchars($position ?? '') ?></h4>
            </span>
            <span>
                <strong style="opacity: 75%">Sex: </strong>
                <h4><?= htmlspecialchars($sex ?? '') ?></h4>
            </span>
            <span>
                <strong style="opacity: 75%">Birthdate: </strong>
                <h4><?= htmlspecialchars($birthdate ?? '') ?></h4>
            </span>
            <span>
                <strong style="opacity: 75%">Email: </strong>
                <h4><?= htmlspecialchars($email ?? '') ?></h4>
                <button id="verifyBtn" class="btn-accent btn-borderless" style="opacity: 75%" <?= ($isVerified ?? false) ? 'hidden' : ''?>>verify</button>
            </span>
            <span>
                <strong style="opacity: 75%">Contact: </strong>
                <h4><?= htmlspecialchars($contact ?? '') ?></h4>
            </span>
            <span>
                <strong style="opacity: 75%">Address: </strong>
                <h4><?= htmlspecialchars($address ?? '') ?></h4>
            </span>
            <span>
                <strong style="opacity: 75%">Role: </strong>
                <h4><?php echo $isEditor ?? '' ? 'Editor' : 'Viewer' ?></h4>
            </span>
            <form id="editInfoForm" class="abs form-ui p-lg hidden" action="/me/update" method="post">
                <input id="avatar" name="avatar" type="file" accept="image/*" hidden>
                <span class="p-sm">
                    <input name="displayName" type="text" value="<?= $displayName ?? ''?>" required>
                    <label>Display Name</label>
                </span>
                <div class="part p-sm">
                    <span>
                        <input name="firstName" type="text" value="<?= $firstName ?? ''?>" required>
                        <label>First Name</label>
                    </span>
                    <span>
                        <input name="lastName" type="text" value="<?=  $lastName ?? '' ?>" required>
                        <label>Last Name</label>
                    </span>
                    <span>
                        <select name="sex"required>
                            <option value="" hidden></option>
                            <option value="Male" <?= ($sex ?? '') === 'Male' ? 'selected' : '' ?>>Male</option>
                            <option value="Female" <?= ($sex ?? '') === 'Female' ? 'selected' : '' ?>>Female</option>
                        </select>
                        <label>Sex</label>
                    </span>
                    <span>
                        <select name="position" required>
                            <option value="" hidden></option>
                            <option value="ADMIN" <?= ($position ?? '') === 'ADMIN' ? 'selected' : '' ?>>ADMIN</option>
                            <option value="Doctor" <?= ($position ?? '') === 'Doctor' ? 'selected' : '' ?>>Doctor</option>
                            <option value="staff" <?= ($position ?? '') === 'staff' ? 'selected' : '' ?>>Staff</option>
                        </select>
                        <label>Position</label>
                    </span>
                    <span>
                        <input name="birthdate" type="date" value="<?= $birthdate ?? null ?>" required>
                        <label>Birthdate</label>
                    </span>
                    <span>
                        <input name="contact" type="text" value="<?= empty($contact ?? '') ? 'Not set' : $contact ?? '' ?>" maxlength="11" required>
                        <label>Contact</label>
                    </span>
                </div>
                <span class="text-area p-sm">
                    <textarea name="address" type="text" required><?= empty($address ?? '') ? 'Not set' : $address ?? '' ?></textarea>
                    <label>Address</label>
                </span>
                <div class="p-sm">
                    <button class="btn-square btn-accent" type="submit">Update</button>
                    <button id="cancelUpdateBtn" class="btn-square btn-highlight" type="button">Cancel</button>
                </div>
            </form>
        </div>
        <button id="requestAccess" class="btn-accent btn-borderless <?= ($request ?? false) ? 'requested' : '' ?>" <?=  ($isEditor ?? false) ? 'hidden' : '' ?> style="<?= ($isVerified ?? false) ? '' : 'opacity: 50%' ?>" ><?= ($request ?? false) ? 'Cancel request' : 'Request Access' ?></button>
    </section>
    <section id="editorPanel" class="acrylic-bg main-panel <?= ($isEditor ?? false) ? '' : 'hidden'?>">
        <h3 style="align-self: start">Requests:</h3>
        <ul id="collection"></ul>
        <h3 style="align-self: start">Editors:</h3>
        <ul id="editorCollection"></ul>
    </section>
</main>
<div id="verify" class="popup">
    <form id="verifyForm" class="form-ui" action="/me/verify">
        <span class="f p-sm" style="flex-direction: row">
            <span>
                <input id="code" type="text" required>
                <label for="code">Enter Code</label>
            </span>
            <button id="resendCode" class="btn-borderless btn-highlight" style="opacity: 50%;">
                <svg class="svg icon" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 861.143 861.143" xml:space="preserve"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g> <path d="M301.209,517.691c0-28.994-23.505-52.5-52.5-52.5H52.5c-28.995,0-52.5,23.506-52.5,52.5v198.885 c0,28.994,23.505,52.5,52.5,52.5c28.995,0,52.5-23.506,52.5-52.5v-84.329c31.275,54.438,74.821,100.956,127.655,135.996 c66.345,44.001,143.649,67.259,223.556,67.259c54.645,0,107.68-10.713,157.635-31.843c48.225-20.397,91.523-49.587,128.695-86.759 c37.17-37.171,66.361-80.471,86.758-128.695c21.131-49.956,31.844-102.991,31.844-157.633c0-54.643-10.713-107.678-31.844-157.633 c-20.396-48.225-49.588-91.525-86.758-128.696c-37.172-37.171-80.471-66.361-128.695-86.758 c-49.955-21.13-102.99-31.843-157.635-31.843c-46.663,0-92.43,7.883-136.029,23.431c-42.136,15.024-81.295,36.846-116.394,64.857 c-34.752,27.735-64.539,60.748-88.534,98.12C90.81,250.122,73.063,291.67,62.507,335.542c-6.783,28.189,10.57,56.542,38.761,63.325 c28.19,6.784,56.542-10.57,63.325-38.762c15.47-64.291,52.65-122.573,104.694-164.107c26.001-20.751,54.989-36.909,86.161-48.025 c32.249-11.5,66.151-17.331,100.763-17.331c80.115,0,155.436,31.198,212.084,87.848s87.848,131.969,87.848,212.083 c0,80.113-31.197,155.434-87.848,212.083c-56.65,56.648-131.969,87.848-212.084,87.848c-59.197,0-116.435-17.208-165.522-49.763 c-42.299-28.054-76.561-66.008-100.006-110.546h58.027C277.705,570.191,301.209,546.686,301.209,517.691z"></path> </g> </g></svg>
            </button>
        </span>
        <span class="f p-md" style="flex-direction: row">
            <button class="btn-bordered btn-accent">Verify</button>
            <button class="btn-bordered btn-higlight" type="button" onclick="closePopup()">Cancel</button>
        </span>
    </form>
</div>
<div id="removeAccess" class="delete popup">
    <form id="removeAccessForm" class="form-ui">
        <header>
            <svg class="svg icon" viewBox="-5.5 0 32 32" version="1.1" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <title>warning</title> <path d="M10.16 25.92c-2.6 0-8.72-0.24-9.88-2.24-1.28-2.28 2.040-8.24 3.080-10.040 1.040-1.76 4.64-7.56 7.12-7.56 2.8 0 7.24 7.48 8.56 10.12 1.92 3.84 2.48 6.4 1.56 7.6-1.52 2.040-8.96 2.12-10.44 2.12zM10.48 7.72c-0.72 0-3.080 2.36-5.64 6.76-2.76 4.68-3.48 7.72-3.080 8.4 0.32 0.56 3.2 1.4 8.4 1.4 5.44 0 8.64-0.88 9.080-1.48 0.28-0.36 0.040-2.28-1.72-5.84-2.64-5.28-6.12-9.24-7.040-9.24zM10.52 19.2c-0.48 0-0.84-0.36-0.84-0.84v-6.36c0-0.48 0.36-0.84 0.84-0.84s0.84 0.36 0.84 0.84v6.32c0 0.48-0.4 0.88-0.84 0.88zM11.36 21.36c0 0.464-0.376 0.84-0.84 0.84s-0.84-0.376-0.84-0.84c0-0.464 0.376-0.84 0.84-0.84s0.84 0.376 0.84 0.84z"></path> </g></svg>
            <h4>Remove Access</h4>
        </header>
        <hr style="height: 1px; color: var(--border-color);">
        <span class="p-md">
            <p>Are you sure that you want to remove 
                <strong style="color:var(--critical)" id="editorName"></strong>'s 
                id: <strong style="color: var(--critical);" id="editorId"></strong> access?
            </p>
        </span>
        <div>
            <button class="btn-square btn-critical" type="submit">Remove Access</button>
            <button class="btn-square btn-highlight" type="button" onclick="closePopup()">Cancel</button>
        </div>
    </form>
</div>
<template id="requesterCard">
    <li>
        <h3 class="name">name</h3>
        <h3 class="position">position</h3>
        <button class="accept btn-borderless btn-accent" style="color: var(--alt-font-color); background: var(--button-color); padding: 1em;">Accept</button>
        <button class="decline btn-bordered btn-critical">Decline</button>
    </li>
</template>
<template id="editorCard">
    <li>
        <h3 class="name">name</h3>
        <h3 class="position">position</h3>
        <button class="remove btn-bordered btn-highlight">Remove access</button>
    </li>
</template>
<?php require __DIR__ . "/../partials/footer.php" ?>