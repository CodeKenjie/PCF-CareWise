<?php require __DIR__ . "/../partials/header.php" ?>
<main id="me">
    <section class="acrylic-bg">
        <div class="avatar">
            <span class="profile">
                <img class="profilePic" src="<?= (str_ends_with(($avatar ?? ''), '/upload//')) ? 'assets/images/profile.png' : ($avatar ?? '')?>" alt="">
            </span>
            <label id="avatarBtn" for="avatar" class="hidden">
                <svg viewBox="0 0 32 32" class="svg sm-icon" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g fill="none" fill-rule="evenodd"> <path d="m0 0h32v32h-32z"></path> <path d="m24 2c4.418278 0 8 3.581722 8 8v12c0 4.418278-3.581722 8-8 8h-16c-4.418278 0-8-3.581722-8-8v-12c0-4.418278 3.581722-8 8-8zm-15.15704017 11.3933983-6.84295983 6.8426017v1.764c0 3.2383969 2.56557489 5.8775718 5.77506174 5.9958615l.22493826.0041385h15.45zm21.15704017-1.8643983-10.096 10.097 6.048224 6.0492469c2.2878684-.7868384 3.9503124-2.9181728 4.0436375-5.4503086l.0041385-.2249383zm-6-7.529h-16c-3.23839694 0-5.87757176 2.56557489-5.99586153 5.77506174l-.00413847.22493826v7.407l5.42874627-5.4278153c.74554637-.7455464 1.93326028-.7794348 2.71900373-.1016654l.1094234.1016654 8.2318266 8.2318153 11.3946671-11.39268045c-.5346164-2.67667729-2.8501212-4.71066623-5.6587288-4.81418108zm-5.4 2c2.209139 0 4 1.790861 4 4s-1.790861 4-4 4-4-1.790861-4-4 1.790861-4 4-4zm0 2c-1.1045695 0-2 .8954305-2 2s.8954305 2 2 2 2-.8954305 2-2-.8954305-2-2-2z" fill="currentColor" fill-rule="nonzero"></path> </g> </g></svg>
            </label>
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
                <button class="btn-accent btn-borderless" style="opacity: 75%">verify</button>
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
        <button id="requestAccess" class="btn-accent btn-borderless <?= ($request ?? false) ? 'requested' : '' ?>" <?=  ($isEditor ?? false) ? 'hidden' : '' ?>><?= ($request ?? false) ? 'Cancel request' : 'Request Access' ?></button>
        <button id="deleteAccount" class="btn-borderless btn-critical">Delete Account</button>
    </section>
    <section id="editorPanel" class="acrylic-bg main-panel <?= ($isEditor ?? false) ? '' : 'hidden'?>">
        <h3 style="align-self: start">Requests:</h3>
        <ul id="collection"></ul>
        <h3 style="align-self: start">Editors:</h3>
        <ul id="editorCollection"></ul>
    </section>
</main>
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