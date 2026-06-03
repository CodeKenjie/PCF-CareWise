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
                    <button id="sort2" class="btn-highlight" type="button" value="first_name">Name</button>
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
<div id="carePanel" class="popup">
    <section id="patientCare">
        <section class="btn-highlight btn-close" onclick="closePopup()"></section>
        <div id="info">
            <div class="avatar" style="padding: 0">
                <span class="profile">
                    <img id="profpic" src="/assets/images/profile.png" alt="">
                </span>
            </div>
            <div class="fc" style="justify-content: center;">
                <span>
                    <label for="">Status:</label>
                    <h3 id="patientStatus"></h3>
                </span>
                <span>
                    <label for="">Name:</label>
                    <h3 id="patientName"></h3>
                </span>
                <span>
                    <label for="">Sex:</label>
                    <h3 id="patientSex"></h3>
                </span>
                <span>
                    <label for="">Age:</label>
                    <h3 id="patientAge"></h3>
                </span>
                <span>
                    <label for="">Birthdate:</label>
                    <h3 id="patientBirthdate"></h3>
                </span>
                <span>
                    <label for="">Contact:</label>
                    <h3 id="patientContact"></h3>
                </span>
                <span>
                    <label for="">Address:</label>
                    <h3 id="patientAddress"></h3>
                </span>
                <span>
                    <label for="">Allergies:</label>
                    <h3 id="patientAllergies"></h3>
                </span>
            </div>
        </div>
        <form id="diagnosisForm" action="/care/patient" method="post">
            <h5>Diagnosis:</h3>
            <input id="conditionName" name="conditionName" type="text" style="padding: 0.5em;" placeholder="Condition Name" <?= ($isEditor ?? false) ? '' : 'hidden'?>>
            <div class="rel" style="width: 100%">
                <input id="symptomsInput" name="symptoms" type="text" style="padding: 0.5em;" placeholder="Describe your Symptoms" <?= ($isEditor ?? false) ? '' : 'hidden'?>>
                <ul id="results" class="abs"></ul>
            </div>
            <button class="btn-borderless btn-highlight" type="submit" <?= ($isEditor ?? false) ? '' : 'hidden'?>>
                <svg class="sm-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g id="Edit / Add_Plus_Square"> <path id="Vector" d="M8 12H12M12 12H16M12 12V16M12 12V8M4 16.8002V7.2002C4 6.08009 4 5.51962 4.21799 5.0918C4.40973 4.71547 4.71547 4.40973 5.0918 4.21799C5.51962 4 6.08009 4 7.2002 4H16.8002C17.9203 4 18.4801 4 18.9079 4.21799C19.2842 4.40973 19.5905 4.71547 19.7822 5.0918C20.0002 5.51962 20.0002 6.07967 20.0002 7.19978V16.7998C20.0002 17.9199 20.0002 18.48 19.7822 18.9078C19.5905 19.2841 19.2842 19.5905 18.9079 19.7822C18.4805 20 17.9215 20 16.8036 20H7.19691C6.07899 20 5.5192 20 5.0918 19.7822C4.71547 19.5905 4.40973 19.2842 4.21799 18.9079C4 18.4801 4 17.9203 4 16.8002Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g> </g></svg>
            </button>
        </form>
        <ul id="diagnosis"></ul>
        <form class="p-sm" id="prescriptionForm" action="/care/prescription" method="post" style="display: flex;">
            <h5 style="flex: 1 1 0">Prescriptions:</h3>
            <button id="setSchedBtn" class="btn-borderless btn-highlight" type="button" <?= ($isEditor ?? false) ? '' : 'hidden'?>>
                <svg class="sm-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M9 20H6C3.79086 20 2 18.2091 2 16V7C2 4.79086 3.79086 3 6 3H17C19.2091 3 21 4.79086 21 7V10" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M8 2V4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M15 2V4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M2 8H21" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M18.5 15.6429L17 17.1429" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> <circle cx="17" cy="17" r="5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></circle> </g></svg>
            </button>
            <button class="btn-borderless btn-highlight" type="submit" <?= ($isEditor ?? false) ? '' : 'hidden'?>>
                <svg class="sm-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g id="Edit / Add_Plus_Square"> <path id="Vector" d="M8 12H12M12 12H16M12 12V16M12 12V8M4 16.8002V7.2002C4 6.08009 4 5.51962 4.21799 5.0918C4.40973 4.71547 4.71547 4.40973 5.0918 4.21799C5.51962 4 6.08009 4 7.2002 4H16.8002C17.9203 4 18.4801 4 18.9079 4.21799C19.2842 4.40973 19.5905 4.71547 19.7822 5.0918C20.0002 5.51962 20.0002 6.07967 20.0002 7.19978V16.7998C20.0002 17.9199 20.0002 18.48 19.7822 18.9078C19.5905 19.2841 19.2842 19.5905 18.9079 19.7822C18.4805 20 17.9215 20 16.8036 20H7.19691C6.07899 20 5.5192 20 5.0918 19.7822C4.71547 19.5905 4.40973 19.2842 4.21799 18.9079C4 18.4801 4 17.9203 4 16.8002Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g> </g></svg>
            </button>
        </form>
        <ul id="prescription"></ul>
    </section>
</div>
<div id="registerPatient" class="popup">
    <form id="registerPatientForm" class="form-ui" action="/patients/register" method="post">
        <span class="p-sm">
            <input id="firstName" name="firstName" type="text" required>
            <label for="firstName">First Name</label>
        </span>
        <span class="p-sm">
            <input id="lastName" name="lastName" type="text" placeholder="N/A" required>
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
                    <option value="Active">Active</option>
                    <option value="Inactive">Inactive</option>
                    <option value="Follow up">Follow up</option>
                    <option value="Complete">Complete</option>
                    <option value="Deceased">Deceased</option>
                </select>
                <label for="status">Status</label>
            </span>
        </div>
        <span class="text-area p-sm">
            <textarea id="allergies" name="allergies" type="text" placeholder="None" required></textarea>
            <label>allergies</label>
        </span>
        <div class="part p-sm">
            <button class="btn-accent btn-pill" type="submit">Submit</button>
            <button class="btn-highlight btn-pill" type="reset" onclick="closePopup()">Cancel</button>
        </div>
    </form>
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
        <span class="text-area p-sm">
            <textarea id="updateAllergies" name="updateAllergies" type="text" placeholder="None" required></textarea>
            <label>Allergies</label>
        </span>
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
<div id="prescribedInfo" class="popup">
    <section class="preview">
        <section class="btn-highlight btn-close" onclick="closePop()"></section>
        <div>
            <span>
                <label for="presCreatedAt"><strong>Given Date:</strong></label>
                <h3 id="presCreatedAt"></h3>
            </span>
            <span>
                <label for="presValidUntil"><strong>Valid Until:</strong></label>
                <h3 id="presValidUntil"></h3>
            </span>
        </div>
        <div>
            <span style="flex: 0 0 fit-content">
                <label for="pmId"><strong>I.D:</strong></label>
                <h3 id="pmId" class="ctr-text"></h3>
            </span>
            <span>
                <label for="genericName"><strong>Generic Name:</strong></label>
                <h3 id="genericName"></h3>
            </span>
            <span>
                <label for="brandName"><strong>Brand Name:</strong></label>
                <h3 id="brandName"></h3>
            </span>
            <span style="flex: 0 0 fit-content;">
                <label for="quantity"><strong>Quantity:</strong></label>
                <h3 id="quantity" class="ctr-text"></h3>
            </span>
        </div>
        <div>
            <span>
                <label for="medDosage"><strong>Medicine Dosage:</strong></label>
                <h3 id="medDosage" class="ctr-text"></h3>
            </span>
            <span>
                <label for="medForm"><strong>Medicine Form:</strong></label>
                <h3 id="medForm"></h3>
            </span>
            <span>
                <label for="presFrequency"><strong>Frequency:</strong></label>
                <h3 id="presFrequency"></h3>
            </span>
        </div>
        <div>
            <span>
                <label for="presDose"><strong>Dose Amount:</strong></label>
                <h3 id="presDose"></h3>
            </span>
            <span>
                <label for="presDuration"><strong>Duration:</strong></label>
                <h3 id="presDuration"></h3>
            </span>
            <span>
                <label for="presExpirationdate"><strong>Medicine Exp.:</strong></label>
                <h3 id="presMedExp"></h3>
            </span>
        </div>
        <span>
            <label for="presInstructions"><strong>Instructions:</strong></label>
            <h3 id="presInstructions"></h3>
        </span>
    </section>
</div>
<div id="prescribeMed" class="popup">
    <form id="prescribeMedForm" class="form-ui" action="/care/prescribe/" method="post">
        <span class="btn-close btn-circle btn-highlight" onclick="closePop()"></span>
        <input id="medicineId" name="medicineId" type="text" readonly hidden>
        <span class="rel p-sm">
            <input id="medicineName" type="text" required>
            <label>Medicine</label>
            <ul id="medicineOptn" class="dropdown"></ul>
        </span>
        <div class="flx p-sm">
            <span>
                <input id="doseAmount" name="doseAmount" type="number" style="max-width: 12rem" required>
                <label>Dose amount</label>
            </span>
            <span>
                <input id="doseUnit" name="doseUnit" type="text" style="max-width: 7rem" required>

                <label>Unit</label>
            </span>
            <span>
                <input id="frequencyPerDay" name="frequencyPerDay" type="number" style="max-width: 12rem" required>
                <label>Frequency</label>
            </span>
        </div>
        <div class="flx p-sm">
            <span>
                <input id="duration" name="duration" type="text" style="max-width: 12rem">
                <label>Duration</label>
            </span>
            <span>
                <input id="durationUnit" name="durationUnit" type="text" style="max-width: 7rem">
                <label>Unit</label>
            </span>
            <span>
                <input id="validUntil" name="validUntil" type="date">
                <label>Valid until</label>
            </span>
        </div>
        <span class="text-area p-sm">
            <textarea id="instructions" name="instructions" placeholder="N/A" required></textarea>
            <label>Instructions</label>
        </span>
        <span class="fr p-sm" style="flex-direction: row; gap: 1em">
            <button class="btn-square btn-accent" type="submit" style="flex: 1 1 0">Prescribe</button>
            <button id="maintenanceBtn" class="btn-square btn-accent" type="button" style="flex: 1 1 0">Maintenance</button>
        </span>
    </form>
</div>
<div id="editMed" class="popup">
    <form id="editMedForm" class="form-ui" method="post">
        <span class="p-md" style="text-align: center">
            <h3 id="otherInfo">kello</h3>
        </span>
        <div class="flx p-sm">
            <span>
                <input id="updateDoseAmount" type="number" style="max-width: 12rem" required>
                <label>Dose amount</label>
            </span>
            <span>
                <input id="updateDoseUnit" type="text" style="max-width: 7rem" required>
                <label>Unit</label>
            </span>
            <span>
                <input id="updateFrequencyPerDay" type="number" style="max-width: 12rem" required>
                <label>Frequency</label>
            </span>
        </div>
        <div class="flx p-sm">
            <span>
                <input id="updateDuration" type="number" style="max-width: 12rem">
                <label>Duration</label>
            </span>
            <span>
                <input id="updateDurationUnit" type="text" style="max-width: 7rem">
                <label>Unit</label>
            </span>
            <span>
                <input id="updateValidUntil" type="date">
                <label>Until</label>
            </span>
        </div>
        <span class="text-area p-sm">
            <textarea id="updateInstructions" type="text" placeholder="N/A" required></textarea>
            <label>Instructions</label>
        </span>
        <div class="part p-sm">
            <button class="btn-pill btn-accent" type="submit">Save</button>
            <button class="btn-pill btn-highlight" type="reset" onclick="closePop()">Cancel</button>
        </div>
    </form>
</div>
<div id="deletePrescription" class="delete popup">
    <form id="deletePrescriptionForm" class="form-ui">
        <header>
            <svg class="svg icon" viewBox="-5.5 0 32 32" version="1.1" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <title>warning</title> <path d="M10.16 25.92c-2.6 0-8.72-0.24-9.88-2.24-1.28-2.28 2.040-8.24 3.080-10.040 1.040-1.76 4.64-7.56 7.12-7.56 2.8 0 7.24 7.48 8.56 10.12 1.92 3.84 2.48 6.4 1.56 7.6-1.52 2.040-8.96 2.12-10.44 2.12zM10.48 7.72c-0.72 0-3.080 2.36-5.64 6.76-2.76 4.68-3.48 7.72-3.080 8.4 0.32 0.56 3.2 1.4 8.4 1.4 5.44 0 8.64-0.88 9.080-1.48 0.28-0.36 0.040-2.28-1.72-5.84-2.64-5.28-6.12-9.24-7.040-9.24zM10.52 19.2c-0.48 0-0.84-0.36-0.84-0.84v-6.36c0-0.48 0.36-0.84 0.84-0.84s0.84 0.36 0.84 0.84v6.32c0 0.48-0.4 0.88-0.84 0.88zM11.36 21.36c0 0.464-0.376 0.84-0.84 0.84s-0.84-0.376-0.84-0.84c0-0.464 0.376-0.84 0.84-0.84s0.84 0.376 0.84 0.84z"></path> </g></svg>
            <h4>Delete Prescription</h4>
        </header>
        <hr style="height: 1px; color: var(--border-color);">
        <span class="p-md">
            <p>Are you sure that you want to delete 
                Prescription: <strong style="color:var(--critical)" id="name"></strong> 
                id: <strong style="color: var(--critical);" id="id"></strong> from Prescriptions?
            </p>
            <p>Reminder: You will not be able to recover deleted data.</p>
        </span>
        <div>
            <button class="btn-square btn-critical" type="submit">Delete</button>
            <button class="btn-square btn-highlight" type="button" onclick="closePop()">Cancel</button>
        </div>
    </form>
</div>
<div id="deletePrescribedMed" class="delete popup">
    <form id="deletePrescribedMedForm" class="form-ui">
        <header>
            <svg class="svg icon" viewBox="-5.5 0 32 32" version="1.1" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <title>warning</title> <path d="M10.16 25.92c-2.6 0-8.72-0.24-9.88-2.24-1.28-2.28 2.040-8.24 3.080-10.040 1.040-1.76 4.64-7.56 7.12-7.56 2.8 0 7.24 7.48 8.56 10.12 1.92 3.84 2.48 6.4 1.56 7.6-1.52 2.040-8.96 2.12-10.44 2.12zM10.48 7.72c-0.72 0-3.080 2.36-5.64 6.76-2.76 4.68-3.48 7.72-3.080 8.4 0.32 0.56 3.2 1.4 8.4 1.4 5.44 0 8.64-0.88 9.080-1.48 0.28-0.36 0.040-2.28-1.72-5.84-2.64-5.28-6.12-9.24-7.040-9.24zM10.52 19.2c-0.48 0-0.84-0.36-0.84-0.84v-6.36c0-0.48 0.36-0.84 0.84-0.84s0.84 0.36 0.84 0.84v6.32c0 0.48-0.4 0.88-0.84 0.88zM11.36 21.36c0 0.464-0.376 0.84-0.84 0.84s-0.84-0.376-0.84-0.84c0-0.464 0.376-0.84 0.84-0.84s0.84 0.376 0.84 0.84z"></path> </g></svg>
            <h4>Delete Prescribed Medicine</h4>
        </header>
        <hr style="height: 1px; color: var(--border-color);">
        <span class="p-md">
            <p>Are you sure that you want to delete 
                Prescription: <strong style="color:var(--critical)" id="medName"></strong> 
                id: <strong style="color: var(--critical);" id="medId"></strong> from Prescribed Medicines?
            </p>
            <p>Reminder: You will not be able to recover deleted data.</p>
        </span>
        <div>
            <button class="btn-square btn-critical" type="submit">Delete</button>
            <button class="btn-square btn-highlight" type="button" onclick="closePop()">Cancel</button>
        </div>
    </form>
</div>
<div id="setSched" class="popup">
    <form id="setSchedForm" class="form-ui" action="/schedule/add" method="post">
        <div style="display:flex; justify-content: space-between; align-items: center; gap: 1em;">
            <h3>Set Schedule: </h3>
            <span>
                <select id="frequency" name="frequency" required>
                    <option value="" hidden></option>
                    <option value="Once">Once</option>
                    <option value="Everyday">Everyday</option>
                    <option value="Every week">Every week</option>
                    <option value="Every 30 days">Every 30 days</option>
                </select>
                <label for="frequency">Frequency</label>
            </span>
        </div>
        <div class="part p-sm">
            <span>
                <input id="getDate" name="getDate" type="date" required>
                <label for="firstName">Date</label>
            </span>
            <span>
                <input id="getTime" name="getTime" type="time" required>
                <label for="firstName">Time</label>
            </span>
            <span>
                <input id="schedFirstName" name="firstName" type="text" required>
                <label for="firstName">First Name</label>
            </span>
            <span>
                <input id="schedLastName" name="lastName" type="text" required>
                <label for="lastName">Last Name</label>
            </span>
            <span>
                <input id="schedContact" name="contact" type="text" required>
                <label for="contact">Contact</label>
            </span>
            <span>
                <input id="schedExContact" name="exContact" type="text" required>
                <label for="exContact">Additional Contact</label>
            </span>
        </div>
        <span class="text-area p-sm">
            <textarea id="schedScheduledFor" name="scheduledFor" type="text" placeholder="Scheduled for" required></textarea>
            <label>For</label>
        </span>
        <div class="part p-sm">
            <button class="btn-pill btn-accent" type="submit" <?= ($isEditor ?? false) ? '' : 'hidden'?>>Set</button>
            <button class="btn-pill btn-highlight" type="reset" onclick="closePop()">Cancel</button>
        </div>
    </form>
</div>
<template id="prescriptionCard">
    <li>
        <div>
            <div class="expand" style="flex: 1 1 0; display: flex;">
                <span style="display: flex; align-items: center; padding: 0 1em;">
                    <svg class="svg sm-icon"viewBox="0 0 256 256" id="Flat" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M188.9707,188l19.51465-19.51465a12.0001,12.0001,0,0,0-16.9707-16.9707L172,171.0293l-34.01074-34.01062A55.99228,55.99228,0,0,0,120,28H72A12,12,0,0,0,60,40V192a12,12,0,0,0,24,0V140h23.0293l48,48-19.51465,19.51465a12.0001,12.0001,0,0,0,16.9707,16.9707L172,204.9707l19.51465,19.51465a12.0001,12.0001,0,0,0,16.9707-16.9707ZM84,52h36a32,32,0,0,1,0,64H84Z"></path> </g></svg>
                </span>
                <h4 class="createdAt" style="flex: 1 1 0;"></h4>
                <h4 class="conditionName" style="flex: 1 1 0;"></h4>
                <span>
                    <svg class="btn-expand icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M7 10L12 15L17 10" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                </span>
            </div>
            <button class="prescribeBtn btn-borderless btn-highlight" <?= ($isEditor ?? false) ? '' : 'hidden'?>>
                <svg class="sm-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g id="Edit / Add_Plus_Square"> <path id="Vector" d="M8 12H12M12 12H16M12 12V16M12 12V8M4 16.8002V7.2002C4 6.08009 4 5.51962 4.21799 5.0918C4.40973 4.71547 4.71547 4.40973 5.0918 4.21799C5.51962 4 6.08009 4 7.2002 4H16.8002C17.9203 4 18.4801 4 18.9079 4.21799C19.2842 4.40973 19.5905 4.71547 19.7822 5.0918C20.0002 5.51962 20.0002 6.07967 20.0002 7.19978V16.7998C20.0002 17.9199 20.0002 18.48 19.7822 18.9078C19.5905 19.2841 19.2842 19.5905 18.9079 19.7822C18.4805 20 17.9215 20 16.8036 20H7.19691C6.07899 20 5.5192 20 5.0918 19.7822C4.71547 19.5905 4.40973 19.2842 4.21799 18.9079C4 18.4801 4 17.9203 4 16.8002Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g> </g></svg>
            </button>
            <button class="deletePrescription btn-borderless btn-critical" style="flex: 0 0 fit-content" <?= ($isEditor ?? false) ? '' : 'hidden'?>>
                <svg class="sm-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g id="Edit / Add_Minus_Square"> <path id="Vector" d="M8 12H16M4 16.8002V7.2002C4 6.08009 4 5.51962 4.21799 5.0918C4.40973 4.71547 4.71547 4.40973 5.0918 4.21799C5.51962 4 6.08009 4 7.2002 4H16.8002C17.9203 4 18.4801 4 18.9079 4.21799C19.2842 4.40973 19.5905 4.71547 19.7822 5.0918C20.0002 5.51962 20.0002 6.07967 20.0002 7.19978V16.7998C20.0002 17.9199 20.0002 18.48 19.7822 18.9078C19.5905 19.2841 19.2842 19.5905 18.9079 19.7822C18.4805 20 17.9215 20 16.8036 20H7.19691C6.07899 20 5.5192 20 5.0918 19.7822C4.71547 19.5905 4.40973 19.2842 4.21799 18.9079C4 18.4801 4 17.9203 4 16.8002Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g> </g></svg>
            </button>
        </div>
        <ul class="prescribedMeds"></ul>
    </li>
</template>
<template id="prescribedCard">
    <li>
        <div class="setSched" style="flex: 1 1 0; display: flex;">
            <svg class="sm-icon" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" fill="currentColor"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <defs> <style>.cls-1{fill:none;stroke:currentColor;stroke-linecap:round;stroke-linejoin:round;stroke-width:1.5px;}</style> </defs> <g id="ic-medicine-pill"> <rect class="cls-1" x="7" y="2" width="10" height="20" rx="5" transform="translate(12 -4.97) rotate(45)"></rect> <line class="cls-1" x1="8.46" y1="8.46" x2="15.54" y2="15.54"></line> </g> </g></svg>
            <h3 class="medicineName"></h3>
            <h3 class="doseAmount"></h3>
            <h3><span class="frequency"></span>x a day</h3>
            <h3 class="duration"></h3>
        </div>
        <div style="flex: 0 0 auto; gap: 0">
            <button class="info btn-borderless btn-highlight">
                <svg class="svg sm-icon" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g fill="currentColor"> <path d="M8 16a8 8 0 0 1-8-8 8 8 0 0 1 8-8 8 8 0 0 1 8 8 8 8 0 0 1-8 8zm0-1a7 7 0 0 0 7-7 7 7 0 0 0-7-7 7 7 0 0 0-7 7 7 7 0 0 0 7 7z"></path> <path d="M8 3.75c-.386 0-.69.124-.914.373A1.269 1.269 0 0 0 6.75 5c0 .336.112.628.336.877.224.249.528.373.914.373s.69-.124.914-.373c.224-.249.336-.541.336-.877 0-.336-.112-.628-.336-.877C8.69 3.874 8.386 3.75 8 3.75zM7 7v5h2V7z" font-family="Ubuntu" font-weight="400" letter-spacing="0" style="line-height:1000%;-inkscape-font-specification:Ubuntu" word-spacing="0"></path> </g> </g></svg>
            </button>
            <button class="edit btn-borderless btn-highlight" <?= ($isEditor ?? false) ? '' : 'hidden'?>>
                <svg class="sm-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M11 2H9C4 2 2 4 2 9V15C2 20 4 22 9 22H15C20 22 22 20 22 15V13" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M16.04 3.02001L8.16 10.9C7.86 11.2 7.56 11.79 7.5 12.22L7.07 15.23C6.91 16.32 7.68 17.08 8.77 16.93L11.78 16.5C12.2 16.44 12.79 16.14 13.1 15.84L20.98 7.96001C22.34 6.60001 22.98 5.02001 20.98 3.02001C18.98 1.02001 17.4 1.66001 16.04 3.02001Z" stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M14.91 4.1499C15.58 6.5399 17.45 8.4099 19.85 9.0899" stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
            </button>
            <button class="deletePrescribedMed btn-borderless btn-critical" <?= ($isEditor ?? false) ? '' : 'hidden'?>>
                <svg class="sm-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g id="Edit / Add_Minus_Square"> <path id="Vector" d="M8 12H16M4 16.8002V7.2002C4 6.08009 4 5.51962 4.21799 5.0918C4.40973 4.71547 4.71547 4.40973 5.0918 4.21799C5.51962 4 6.08009 4 7.2002 4H16.8002C17.9203 4 18.4801 4 18.9079 4.21799C19.2842 4.40973 19.5905 4.71547 19.7822 5.0918C20.0002 5.51962 20.0002 6.07967 20.0002 7.19978V16.7998C20.0002 17.9199 20.0002 18.48 19.7822 18.9078C19.5905 19.2841 19.2842 19.5905 18.9079 19.7822C18.4805 20 17.9215 20 16.8036 20H7.19691C6.07899 20 5.5192 20 5.0918 19.7822C4.71547 19.5905 4.40973 19.2842 4.21799 18.9079C4 18.4801 4 17.9203 4 16.8002Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g> </g></svg>
            </button>
        </div>
    </li>
</template>
<template id="medicineCard">
    <li class="medicine">
        <span class="p-sm">
            <h4 class="genericName" style="display: flex; gap: 0.5em">testing testing</h4>
            <h5 class="dosage" style="opacity: 50%;">dosage</h5>
            <h5 class="form" style="opacity: 50%;">form</h5>
        </span>
    </li>
</template>
<template id="patientCareCard">
    <li>
        <div class="patient" style="flex: 1 1 0; display:flex">
            <h3 class="name"></h3>
            <h3 style="flex: fit-content">Age: <span class="age"></span></h3>
            <h3 class="pstatus"></h3>
        </div>
    </li>
</template>
<template id="conditionCard">
    <li class="p-sm">
        <span style="padding: 0 1em">
            <svg class="sm-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M5 4H4C3.44772 4 3 4.44772 3 5V9C3 11.7614 5.23858 14 8 14V14C10.7614 14 13 11.7614 13 9V5C13 4.44772 12.5523 4 12 4H11" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M8 14V15.5C8 18.5376 10.4624 21 13.5 21V21C16.5376 21 19 18.5376 19 15.5V14" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M10 3V5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M6 3V5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> <circle cx="19" cy="12" r="2" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></circle> </g></svg>
        </span>
        <div style="flex: 1 1 0; display: flex; align-items: center;">
            <span class="condition" style="flex: 1 1 0"></span>
            <span class="date" style="flex: 1 1 0;"></span>
        </div>
        <button class="prescribe btn-borderless btn-highlight" <?= ($isEditor ?? false) ? '' : 'hidden'?>>
            <svg class="svg sm-icon"viewBox="0 0 256 256" id="Flat" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M188.9707,188l19.51465-19.51465a12.0001,12.0001,0,0,0-16.9707-16.9707L172,171.0293l-34.01074-34.01062A55.99228,55.99228,0,0,0,120,28H72A12,12,0,0,0,60,40V192a12,12,0,0,0,24,0V140h23.0293l48,48-19.51465,19.51465a12.0001,12.0001,0,0,0,16.9707,16.9707L172,204.9707l19.51465,19.51465a12.0001,12.0001,0,0,0,16.9707-16.9707ZM84,52h36a32,32,0,0,1,0,64H84Z"></path> </g></svg>
        </button>
        <button class="removeCondition btn-borderless btn-critical" <?= ($isEditor ?? false) ? '' : 'hidden'?>>
            <svg class="sm-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g id="Edit / Add_Minus_Square"> <path id="Vector" d="M8 12H16M4 16.8002V7.2002C4 6.08009 4 5.51962 4.21799 5.0918C4.40973 4.71547 4.71547 4.40973 5.0918 4.21799C5.51962 4 6.08009 4 7.2002 4H16.8002C17.9203 4 18.4801 4 18.9079 4.21799C19.2842 4.40973 19.5905 4.71547 19.7822 5.0918C20.0002 5.51962 20.0002 6.07967 20.0002 7.19978V16.7998C20.0002 17.9199 20.0002 18.48 19.7822 18.9078C19.5905 19.2841 19.2842 19.5905 18.9079 19.7822C18.4805 20 17.9215 20 16.8036 20H7.19691C6.07899 20 5.5192 20 5.0918 19.7822C4.71547 19.5905 4.40973 19.2842 4.21799 18.9079C4 18.4801 4 17.9203 4 16.8002Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g> </g></svg>
        </button>
    </li>
</template>
<template id="medicineCard">
    <li>
        <h3>medicine given</h3>
        <h3>take every / per day</h3>
        <button class="btn-borderless btn-critical" style="padding: 0.2em">
            <svg class="sm-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g id="Edit / Add_Minus_Square"> <path id="Vector" d="M8 12H16M4 16.8002V7.2002C4 6.08009 4 5.51962 4.21799 5.0918C4.40973 4.71547 4.71547 4.40973 5.0918 4.21799C5.51962 4 6.08009 4 7.2002 4H16.8002C17.9203 4 18.4801 4 18.9079 4.21799C19.2842 4.40973 19.5905 4.71547 19.7822 5.0918C20.0002 5.51962 20.0002 6.07967 20.0002 7.19978V16.7998C20.0002 17.9199 20.0002 18.48 19.7822 18.9078C19.5905 19.2841 19.2842 19.5905 18.9079 19.7822C18.4805 20 17.9215 20 16.8036 20H7.19691C6.07899 20 5.5192 20 5.0918 19.7822C4.71547 19.5905 4.40973 19.2842 4.21799 18.9079C4 18.4801 4 17.9203 4 16.8002Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g> </g></svg>
        </button>
    </li>
</template>
<template id="possibleConditionCard">
    <li>
        <span>
            <h3 class="condition"></h3>
            <h4 class="confidence"></h4>
        </span>
        <p class="description"></p>
        <h6>suggestions:</h6>
        <div class="medications"></div>
    </li>
</template>
<template id="patientsCard">
    <li>
        <span class="fr" style="flex-direction: row; gap: 1em; cursor: pointer; flex-wrap:wrap; justify-content:center">
            <div class="rel" style="display: flex; flex-direction: column; align-items:center;">
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
            <table class="careBtn">
                <tbody>
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
                    <tr>
                        <td><strong>Birthdate:</strong></td>
                        <td class="birthdate"></td>
                    </tr>
                </tbody>
                <tbody>
                    <tr>
                        <td><strong>Address:</strong></td>
                        <td class="address"></td>
                    </tr>
                    <tr>
                        <td><strong>Contacts:</strong></td>
                        <td class="contact"></td>
                    </tr>
                    <tr>
                        <td><strong>Allergies:</strong></td>
                        <td class="allergies"></td>
                    </tr>
                    <tr>
                        <td><strong>Referred by:</strong></td>
                        <td class="referredBy" ></td>
                    </tr>
                </tbody>
            </table>
        </span>
        <div>
            <button class="editPatientBtn btn-highlight" <?= ($isEditor ?? false) ? '' : 'hidden'?>>
                <svg viewBox="0 0 24 24" class="svg sm-icon" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M2,21H8a1,1,0,0,0,0-2H3.071A7.011,7.011,0,0,1,10,13a5.044,5.044,0,1,0-3.377-1.337A9.01,9.01,0,0,0,1,20,1,1,0,0,0,2,21ZM10,5A3,3,0,1,1,7,8,3,3,0,0,1,10,5ZM20.207,9.293a1,1,0,0,0-1.414,0l-6.25,6.25a1.011,1.011,0,0,0-.241.391l-1.25,3.75A1,1,0,0,0,12,21a1.014,1.014,0,0,0,.316-.051l3.75-1.25a1,1,0,0,0,.391-.242l6.25-6.25a1,1,0,0,0,0-1.414Zm-5,8.583-1.629.543.543-1.629L19.5,11.414,20.586,12.5Z"></path></g></svg>
            </button>
            <button class="medicalReport btn-highlight">
                <svg class="sm-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M7 17H5C3.89543 17 3 16.1046 3 15V11C3 9.34315 4.34315 8 6 8H7M7 17V14H17V17M7 17V18C7 19.1046 7.89543 20 9 20H15C16.1046 20 17 19.1046 17 18V17M17 17H19C20.1046 17 21 16.1046 21 15V11C21 9.34315 19.6569 8 18 8H17M7 8V6C7 4.89543 7.89543 4 9 4H15C16.1046 4 17 4.89543 17 6V8M7 8H17M15 11H17" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
            </button>
            <button class="deletePatientBtn btn-critical" <?= ($isEditor ?? false) ? '' : 'hidden'?>>
                <svg viewBox="0 0 24 24" class="svg sm-icon" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M1,20a1,1,0,0,0,1,1h8a1,1,0,0,0,0-2H3.071A7.011,7.011,0,0,1,10,13a5.044,5.044,0,1,0-3.377-1.337A9.01,9.01,0,0,0,1,20ZM10,5A3,3,0,1,1,7,8,3,3,0,0,1,10,5Zm12.707,9.707L20.414,17l2.293,2.293a1,1,0,1,1-1.414,1.414L19,18.414l-2.293,2.293a1,1,0,0,1-1.414-1.414L17.586,17l-2.293-2.293a1,1,0,0,1,1.414-1.414L19,15.586l2.293-2.293a1,1,0,0,1,1.414,1.414Z"></path></g></svg>
            </button>
        </div>
    </li>
</template>
<?php 
    require __DIR__ . '/../prints/medical_report.print.php';
    require __DIR__ . "/../partials/footer.php"; 
?>