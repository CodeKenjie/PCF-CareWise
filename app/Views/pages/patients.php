<?php require __DIR__ . "/../partials/header.php"; ?>
<main id="patients">
    <section class="actions acrylic-bg">
        <button id="registerPatientBtn" class="addBtn btn-accent" style="display: <?= ($isEditor ?? false) ? 'flex' : 'none' ?>">
            <svg class="svg icon" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M2,21h8a1,1,0,0,0,0-2H3.071A7.011,7.011,0,0,1,10,13a5.044,5.044,0,1,0-3.377-1.337A9.01,9.01,0,0,0,1,20,1,1,0,0,0,2,21ZM10,5A3,3,0,1,1,7,8,3,3,0,0,1,10,5ZM23,16a1,1,0,0,1-1,1H19v3a1,1,0,0,1-2,0V17H14a1,1,0,0,1,0-2h3V12a1,1,0,0,1,2,0v3h3A1,1,0,0,1,23,16Z"></path></g></svg>
            <span>Register Patient</span>
        </button>
        <div>
            <form action="/patients/sort" method="get">
                <span class="sortsSpan">
                    <button id="sort1" class="btn-highlight activeSort" type="button" value="id">I.D</button>
                    <button id="sort2" class="btn-highlight" type="button" value="last_name">Name</button>
                    <button id="sort3" class="btn-highlight" type="button" value="age">Age</button>
                    <button id="direction" class="btn-highlight" type="button" value="ASC">ASC</button>
                </span>
            </form>
            <form id="searchForm" action="/patients/patient" method="get">
                <span class="searchSpan">
                    <input id="search" name="search" style="padding-right: 4em;" type="text" placeholder="Search">
                    <button type="submit">
                        <svg viewBox="0 0 20 20" class="svg icon" xmlns="http://www.w3.org/2000/svg" fill="none"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path fill="currentColor" fill-rule="evenodd" d="M4 9a5 5 0 1110 0A5 5 0 014 9zm5-7a7 7 0 104.2 12.6.999.999 0 00.093.107l3 3a1 1 0 001.414-1.414l-3-3a.999.999 0 00-.107-.093A7 7 0 009 2z"></path> </g></svg>
                    </button>
                </span>
            </form>
        </div>
    </section>
    <section class="acrylic-bg main-panel">
        <ul id="collection"></ul>
    </section>
</main>
<div id="registerPatient" class="popup">
    <form id="registerPatientForm" class="form-ui" action="/patients/register" method="post">
        <span class="p-sm">
            <input id="firstName" name="firstName" type="text" required>
            <label for="firstName">First Name</label>
        </span>
        <span class="p-sm">
            <input id="lastName" name="lastName" type="text" required>
            <label for="lastName">Last Name</label>
        </span>
        <div class="part p-sm">
            <span>
                <input id="birthdate" name="birthdate" type="date" required>
                <label for="birthdate">Birthdate</label>
            </span>
            <span>
                <select id="sex" name="sex" required>
                    <option value="" hidden></option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                </select>
                <label for="sex">Sex</label>
            </span>
        </div>
        <span class="p-sm">
            <input id="address" name="address" type="text" required>
            <label for="address">Address</label>
        </span>
        <div class="part p-sm">
            <span>
                <input id="contact" name="contact" type="text" maxlength="11" required>
                <label for="contact">Contact</label>
            </span>
            <span>
                <input id="exContact" name="exContact" type="text" placeholder="N/A" required>
                <label for="exContact">Contact#2(N/A)</label>
            </span>
        </div>
        <div class="part p-sm">
            <span>
                <input id="referredBy" name="referredBy" type="text" placeholder="N/A" required>
                <label for="referredBy">Referred by</label>
            </span>
            <span>
                <select id="status" name="status" required>
                    <option value="" hidden></option>
                    <option value="" hidden></option>
                    <option value="Active">Active</option>
                    <option value="Inactive">Inactive</option>
                    <option value="Follow up">Follow up</option>
                    <option value="Complete">Complete</option>
                    <option value="Deceased">Deceased</option>
                </select>
                <label for="status">Status</label>
            </span>
        </div>
        <div class="part p-sm">
            <button class="btn-accent btn-pill" type="submit">Submit</button>
            <button class="btn-highlight btn-pill" type="reset" onclick="closePopup()">Cancel</button>
        </div>
    </form>
</div>
<div id="patientPreview" class="popup">
    <section class="preview">
        <section class="btn-highlight btn-close" onclick="closePopup()"></section>
        <div class="avatar">
            <header class="profile">
                <img id="dp" src="assets/images/profile.png" alt="">
            </header>
        </div>
        <div>
            <span style="flex: 0 0 fit-content">
                <label for="pId"><strong>I.D:</strong></label>
                <h3 id="pId"></h3>
            </span>
            <span>
                <label for="pName"><strong>Name:</strong></label>
                <h3 id="pName"></h3>
            </span>
            <span>
                <label for="pStatus"><strong>Status:</strong></label>
                <h3 id="pStatus"></h3>
            </span>
        </div>
        <div>
            <span>
                <label for="pSex"><strong>Sex:</strong></label>
                <h3 id="pSex"></h3>
            </span>
            <span>
                <label for="pAge"><strong>Age:</strong></label>
                <h3 id="pAge"></h3>
            </span>
            <span>
                <label for="pBirthdate"><strong>Birthdate:</strong></label>
                <h3 id="pBirthdate"></h3>
            </span>
        </div>
        <span>
            <label for="pAddress"><strong>Address:</strong></label>
            <h3 id="pAddress"></h3>
        </span>
        <div>
            <span>
                <label for="pContacts"><strong>Contacts:</strong></label>
                <h3 id="pContacts"></h3>
            </span>
            <span>
                <label for="pReferredBy"><strong>Referred By:</strong></label>
                <h3 id="pReferredBy"></h3>
            </span>
        </div>
    </section>
</div>
<div id="editPatient" class="popup">
    <form id="editPatientForm" class="form-ui" action="/patients/edit" method="post">
        <span class="p-sm">
            <input id="updateFirstName" name="updateFirstName" type="text" required>
            <label for="upadateFirstName">First Name</label>
        </span>
        <span class="p-sm">
            <input id="updateLastName" name="updateLastName" type="text" required>
            <label for="updateLastName">Last Name</label>
        </span>
        <div class="part p-sm">
            <span>
                <input id="updateBirthdate" name="updateBirthdate" type="date" required>
                <label for="updateBirthdate">Birthdate</label>
            </span>
            <span>
                <select id="updateSex" name="updateSex" class="updateSex" required>
                    <option value="" hidden></option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                </select>
                <label for="sex">Sex</label>
            </span>
        </div>
        <span class="p-sm">
            <input id="updateAddress" name="updateAddress" type="text" required>
            <label for="upadateAddress">Address</label>
        </span>
        <div class="part p-sm">
            <span>
                <input id="updateContact" name="updateContact" type="text" maxlength="11" required>
                <label for="updateContact">Contact</label>
            </span>
            <span>
                <input id="updateExContact" name="updateExContact" type="text" placeholder="N/A" required>
                <label for="updateExContact">Contact#2(N/A)</label>
            </span>
        </div>
        <div class="part p-sm">
            <span>
                <input id="updateReferredBy" name="updateReferredBy" type="text" placeholder="N/A" required>
                <label for="updateReferredBy">Referred by</label>
            </span>
            <span>
                <select id="updateStatus" name="updateStatus" required>
                    <option value="" hidden></option>
                    <option value="Active">Active</option>
                    <option value="Inactive">Inactive</option>
                    <option value="Follow Up">Follow Up</option>
                    <option value="Complete">Complete</option>
                    <option value="Deceased">Deceased</option>
                </select>
                <label for="updateStatus">Status</label>
            </span>
        </div>
        <div class="part p-sm">
            <button class="btn-pill btn-accent" type="submit">Submit</button>
            <button class="btn-pill btn-highlight" type="reset" onclick="closePopup()">Cancel</button>
        </div>
    </form>
</div>
<div id="deletePatient" class="delete popup">
    <form id="deletePatientForm" class="form-ui" action="/patients/delete" method="post">
        <header>
            <svg class="svg icon" viewBox="-5.5 0 32 32" version="1.1" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <title>warning</title> <path d="M10.16 25.92c-2.6 0-8.72-0.24-9.88-2.24-1.28-2.28 2.040-8.24 3.080-10.040 1.040-1.76 4.64-7.56 7.12-7.56 2.8 0 7.24 7.48 8.56 10.12 1.92 3.84 2.48 6.4 1.56 7.6-1.52 2.040-8.96 2.12-10.44 2.12zM10.48 7.72c-0.72 0-3.080 2.36-5.64 6.76-2.76 4.68-3.48 7.72-3.080 8.4 0.32 0.56 3.2 1.4 8.4 1.4 5.44 0 8.64-0.88 9.080-1.48 0.28-0.36 0.040-2.28-1.72-5.84-2.64-5.28-6.12-9.24-7.040-9.24zM10.52 19.2c-0.48 0-0.84-0.36-0.84-0.84v-6.36c0-0.48 0.36-0.84 0.84-0.84s0.84 0.36 0.84 0.84v6.32c0 0.48-0.4 0.88-0.84 0.88zM11.36 21.36c0 0.464-0.376 0.84-0.84 0.84s-0.84-0.376-0.84-0.84c0-0.464 0.376-0.84 0.84-0.84s0.84 0.376 0.84 0.84z"></path> </g></svg>
            <h4>Delete Patient</h4>
        </header>
        <hr style="height: 1px; color: var(--border-color);">
        <span class="p-md">
            <p>Are you sure that you want to delete 
                patient: <strong style="color:var(--critical)" id="name"></strong> 
                id: <strong style="color: var(--critical);" id="id"></strong> from patients?
            </p>
            <p>Reminder: You will not be able to recover deleted data.</p>
        </span>
        <div>
            <button class="btn-square btn-critical" type="submit">Delete</button>
            <button class="btn-square btn-highlight" type="button" onclick="closePopup()">Cancel</button>
        </div>
    </form>
</div>
<template id="patientsCard">
    <li>
        <div class="rel" style="display: flex; flex-direction: column; align-items:center">
            <span class="rel profile">
                <img src="assets/images/profile.png" alt="">
                <form class="patientAvatarForm" method="post" <?= ($isEditor ?? false) ? '' : 'hidden'?>>
                    <span class="avatarUpload abs">
                        <label>
                            <input name="avatar" type="file" accept="image/*" hidden>
                            <svg class="upload icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path fill-rule="evenodd" clip-rule="evenodd" d="M7.59843 4.48666C7.86525 3.17678 9.03088 2.25 10.3663 2.25H13.6337C14.9691 2.25 16.1347 3.17678 16.4016 4.48666C16.4632 4.78904 16.7371 5.01086 17.022 5.01086H17.0384L17.0548 5.01157C18.4582 5.07294 19.5362 5.24517 20.4362 5.83558C21.0032 6.20757 21.4909 6.68617 21.871 7.24464C22.3439 7.93947 22.5524 8.73694 22.6524 9.70145C22.75 10.6438 22.75 11.825 22.75 13.3211V13.4062C22.75 14.9023 22.75 16.0835 22.6524 17.0258C22.5524 17.9903 22.3439 18.7878 21.871 19.4826C21.4909 20.0411 21.0032 20.5197 20.4362 20.8917C19.7327 21.3532 18.9262 21.5567 17.948 21.6544C16.9903 21.75 15.789 21.75 14.2634 21.75H9.73657C8.21098 21.75 7.00967 21.75 6.05196 21.6544C5.07379 21.5567 4.26731 21.3532 3.56385 20.8917C2.99682 20.5197 2.50905 20.0411 2.12899 19.4826C1.65612 18.7878 1.44756 17.9903 1.34762 17.0258C1.24998 16.0835 1.24999 14.9023 1.25 13.4062V13.3211C1.24999 11.825 1.24998 10.6438 1.34762 9.70145C1.44756 8.73694 1.65612 7.93947 2.12899 7.24464C2.50905 6.68617 2.99682 6.20757 3.56385 5.83558C4.46383 5.24517 5.5418 5.07294 6.94523 5.01157L6.96161 5.01086H6.978C7.26288 5.01086 7.53683 4.78905 7.59843 4.48666ZM10.3663 3.75C9.72522 3.75 9.18905 4.19299 9.06824 4.78607C8.87258 5.74659 8.021 6.50186 6.99633 6.51078C5.64772 6.57069 4.92536 6.73636 4.38664 7.08978C3.98309 7.35452 3.63752 7.6941 3.36906 8.08857C3.09291 8.49435 2.92696 9.01325 2.83963 9.85604C2.75094 10.7121 2.75 11.8156 2.75 13.3636C2.75 14.9117 2.75094 16.0152 2.83963 16.8712C2.92696 17.714 3.09291 18.2329 3.36906 18.6387C3.63752 19.0332 3.98309 19.3728 4.38664 19.6375C4.80417 19.9114 5.33844 20.0756 6.20104 20.1618C7.07549 20.2491 8.20193 20.25 9.77778 20.25H14.2222C15.7981 20.25 16.9245 20.2491 17.799 20.1618C18.6616 20.0756 19.1958 19.9114 19.6134 19.6375C20.0169 19.3728 20.3625 19.0332 20.6309 18.6387C20.9071 18.2329 21.073 17.714 21.1604 16.8712C21.2491 16.0152 21.25 14.9117 21.25 13.3636C21.25 11.8156 21.2491 10.7121 21.1604 9.85604C21.073 9.01325 20.9071 8.49435 20.6309 8.08857C20.3625 7.6941 20.0169 7.35452 19.6134 7.08978C19.0746 6.73636 18.3523 6.57069 17.0037 6.51078C15.979 6.50186 15.1274 5.74659 14.9318 4.78607C14.8109 4.19299 14.2748 3.75 13.6337 3.75H10.3663ZM12 10.75C10.7574 10.75 9.75 11.7574 9.75 13C9.75 14.2426 10.7574 15.25 12 15.25C13.2426 15.25 14.25 14.2426 14.25 13C14.25 11.7574 13.2426 10.75 12 10.75ZM8.25 13C8.25 10.9289 9.92893 9.25 12 9.25C14.0711 9.25 15.75 10.9289 15.75 13C15.75 15.0711 14.0711 16.75 12 16.75C9.92893 16.75 8.25 15.0711 8.25 13ZM17.25 10C17.25 9.58579 17.5858 9.25 18 9.25H19C19.4142 9.25 19.75 9.58579 19.75 10C19.75 10.4142 19.4142 10.75 19 10.75H18C17.5858 10.75 17.25 10.4142 17.25 10Z" fill="currentColor"></path> </g></svg>
                        </label>
                        <svg class="save icon hidden" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M15 20V15H9V20M18 20H6C4.89543 20 4 19.1046 4 18V6C4 4.89543 4.89543 4 6 4H14.1716C14.702 4 15.2107 4.21071 15.5858 4.58579L19.4142 8.41421C19.7893 8.78929 20 9.29799 20 9.82843V18C20 19.1046 19.1046 20 18 20Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                    </span>
                </form>
            </span>
            <span class="status" style="font-weight: 800;"></span>
        </div>
        <table>
            <tbody>
                <tr>
                    <td><strong>I.D:</strong></td>
                    <td class="id"></td>
                </tr>
                <tr>
                    <td><strong>Name:</strong></td>
                    <td class="name"></td>
                </tr>
                <tr>
                    <td><strong>Age:</strong></td>
                    <td class="age"></td>
                </tr>
                <tr>
                    <td><strong>Sex:</strong></td>
                    <td class="sex"></td>
                </tr>
            </tbody>
            <tbody>
                <tr>
                    <td><strong>Birthdate:</strong></td>
                    <td class="birthdate"></td>
                </tr>
                <tr>
                    <td><strong>Address:</strong></td>
                    <td class="address"></td>
                </tr>
                <tr>
                    <td><strong>Contacts:</strong></td>
                    <td class="contact"></td>
                </tr>
                <tr>
                    <td><strong>Referred by:</strong></td>
                    <td class="referredBy" ></td>
                </tr>
            </tbody>
        </table>
        <div>
            <button class="patientPreviewBtn btn-highlight">
                <svg viewBox="0 0 24 24" class="svg sm-icon" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="currentColor"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><g id="🔍-Product-Icons" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"> <g id="ic_fluent_patient_24_regular" fill="currentColor" fill-rule="nonzero"> <path d="M17.75,2 C18.9926407,2 20,3.00735931 20,4.25 L20,19.754591 C20,20.9972317 18.9926407,22.004591 17.75,22.004591 L6.25,22.004591 C5.00735931,22.004591 4,20.9972317 4,19.754591 L4,4.25 C4,3.05913601 4.92516159,2.08435508 6.09595119,2.00519081 L6.25,2 L17.75,2 Z M18.5,16 L5.5,16 L5.5,19.754591 C5.5,20.1688046 5.83578644,20.504591 6.25,20.504591 L17.75,20.504591 C18.1642136,20.504591 18.5,20.1688046 18.5,19.754591 L18.5,16 Z M7.75128856,17.5 L16.25,17.5 C16.6642136,17.5 17,17.8357864 17,18.25 C17,18.6296958 16.7178461,18.943491 16.3517706,18.9931534 L16.25,19 L7.75128856,19 C7.337075,19 7.00128856,18.6642136 7.00128856,18.25 C7.00128856,17.8703042 7.28344245,17.556509 7.64951801,17.5068466 L7.75128856,17.5 L16.25,17.5 L7.75128856,17.5 Z M17.75,3.5 L6.25,3.5 L6.14822944,3.50684662 C5.78215388,3.55650904 5.5,3.87030423 5.5,4.25 L5.5,14.5 L8,14.5 L8,12.2455246 C8,11.5983159 8.49187466,11.0659907 9.12219476,11.0019782 L9.25,10.9955246 L14.75,10.9955246 C15.3972087,10.9955246 15.9295339,11.4873992 15.9935464,12.1177193 L16,12.2455246 L16,14.5 L18.5,14.5 L18.5,4.25 C18.5,3.83578644 18.1642136,3.5 17.75,3.5 Z M14.5,12.4955246 L9.5,12.4955246 L9.5,14.5 L14.5,14.5 L14.5,12.4955246 Z M12,4.99552458 C13.3807119,4.99552458 14.5,6.11481271 14.5,7.49552458 C14.5,8.87623646 13.3807119,9.99552458 12,9.99552458 C10.6192881,9.99552458 9.5,8.87623646 9.5,7.49552458 C9.5,6.11481271 10.6192881,4.99552458 12,4.99552458 Z M12,6.49552458 C11.4477153,6.49552458 11,6.94323983 11,7.49552458 C11,8.04780933 11.4477153,8.49552458 12,8.49552458 C12.5522847,8.49552458 13,8.04780933 13,7.49552458 C13,6.94323983 12.5522847,6.49552458 12,6.49552458 Z"> </path> </g> </g> </g></svg>
            </button>
            <button class="editPatientBtn btn-highlight" <?= ($isEditor ?? false) ? '' : 'hidden'?>>
                <svg viewBox="0 0 24 24" class="svg sm-icon" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M2,21H8a1,1,0,0,0,0-2H3.071A7.011,7.011,0,0,1,10,13a5.044,5.044,0,1,0-3.377-1.337A9.01,9.01,0,0,0,1,20,1,1,0,0,0,2,21ZM10,5A3,3,0,1,1,7,8,3,3,0,0,1,10,5ZM20.207,9.293a1,1,0,0,0-1.414,0l-6.25,6.25a1.011,1.011,0,0,0-.241.391l-1.25,3.75A1,1,0,0,0,12,21a1.014,1.014,0,0,0,.316-.051l3.75-1.25a1,1,0,0,0,.391-.242l6.25-6.25a1,1,0,0,0,0-1.414Zm-5,8.583-1.629.543.543-1.629L19.5,11.414,20.586,12.5Z"></path></g></svg>
            </button>
            <button class="deletePatientBtn btn-critical" style="color: var(--font-color)" <?= ($isEditor ?? false) ? '' : 'hidden'?>>
                <svg viewBox="0 0 24 24" class="svg sm-icon" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M1,20a1,1,0,0,0,1,1h8a1,1,0,0,0,0-2H3.071A7.011,7.011,0,0,1,10,13a5.044,5.044,0,1,0-3.377-1.337A9.01,9.01,0,0,0,1,20ZM10,5A3,3,0,1,1,7,8,3,3,0,0,1,10,5Zm12.707,9.707L20.414,17l2.293,2.293a1,1,0,1,1-1.414,1.414L19,18.414l-2.293,2.293a1,1,0,0,1-1.414-1.414L17.586,17l-2.293-2.293a1,1,0,0,1,1.414-1.414L19,15.586l2.293-2.293a1,1,0,0,1,1.414,1.414Z"></path></g></svg>
            </button>
        </div>
    </li>
</template>
<?php require __DIR__ . "/../partials/footer.php"; ?>