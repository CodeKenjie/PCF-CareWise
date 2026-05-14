<?php require __DIR__ . "/../partials/header.php"; ?>
<main id="care">
    <section class="actions acrylic-bg">
        <div>
            <form action="/care/patients/sort" method="get">
                <span class="sortsSpan">
                    <button id="sort1" class="btn-highlight activeSort" type="button" value="id">Id</button>
                    <button id="sort2" class="btn-highlight" type="button" value="last_name">Name</button>
                    <button id="sort3" class="btn-highlight" type="button" value="age">Age</button>
                    <button id="direction" class="btn-highlight" type="button" value="ASC">ASC</button>
                </span>
            </form>
            <form id="searchForm" action="/care/patients/patient" method="get">
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
    <section id="diagnose" class="acrylic-bg main-panel">
        <div id="info">
            <div class="avatar">
                <span class="profile">
                    <img id="profpic" src="/assets/images/profile.png" alt="">
                </span>
            </div>
            <div>
                <span>
                    <label for="">I.D:</label>
                    <h3 id="patientId"></h3>
                </span>
                <span>
                    <label for="">Name:</label>
                    <h3 id="patientName"></h3>
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
                    <label for="">status:</label>
                    <h3 id="patientStatus"></h3>
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
</main>
<div id="prescribedInfo" class="popup">
    <section class="preview">
        <section class="btn-highlight btn-close" onclick="closePopup()"></section>
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
        <span class="btn-close btn-circle" onclick="closePopup()"></span>
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
                <input id="duration" name="duration" type="number" style="max-width: 12rem" required>
                <label>Duration</label>
            </span>
            <span>
                <input id="durationUnit" name="durationUnit" type="text" style="max-width: 7rem" required>
                <label>Unit</label>
            </span>
            <span>
                <input id="validUntil" name="validUntil" type="date" required>
                <label>Valid until</label>
            </span>
        </div>
        <span class="text-area p-sm">
            <textarea id="instructions" name="instructions" placeholder="N/A" required></textarea>
            <label>Instructions</label>
        </span>
        <span class="p-lg">
            <button class="btn-square btn-accent" type="submit">Prescribe</button>
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
                <input id="updateDuration" type="number" style="max-width: 12rem" required>
                <label>Duration</label>
            </span>
            <span>
                <input id="updateDurationUnit" type="text" style="max-width: 7rem" required>
                <label>Unit</label>
            </span>
            <span>
                <input id="updateValidUntil" type="date" required>
                <label>Until</label>
            </span>
        </div>
        <span class="text-area p-sm">
            <textarea id="updateInstructions" type="text" placeholder="N/A" required></textarea>
            <label>Instructions</label>
        </span>
        <div class="part p-sm">
            <button class="btn-pill btn-accent" type="submit">Save</button>
            <button class="btn-pill btn-highlight" type="reset" onclick="closePopup()">Cancel</button>
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
            <button class="btn-square btn-highlight" type="button" onclick="closePopup()">Cancel</button>
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
            <button class="btn-square btn-highlight" type="button" onclick="closePopup()">Cancel</button>
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
                <input id="firstName" name="firstName" type="text" required>
                <label for="firstName">First Name</label>
            </span>
            <span>
                <input id="lastName" name="lastName" type="text" required>
                <label for="lastName">Last Name</label>
            </span>
            <span>
                <input id="contact" name="contact" type="text" required>
                <label for="contact">Contact</label>
            </span>
            <span>
                <input id="exContact" name="exContact" type="text" required>
                <label for="exContact">Additional Contact</label>
            </span>
        </div>
        <span class="text-area p-sm">
            <textarea id="scheduledFor" name="scheduledFor" type="text" placeholder="Scheduled for" required></textarea>
            <label>Instructions</label>
        </span>
        <div class="part p-sm">
            <button class="btn-pill btn-accent" type="submit" <?= ($isEditor ?? false) ? '' : 'hidden'?>>Set</button>
            <button class="btn-pill btn-highlight" type="reset" onclick="closePopup()">Cancel</button>
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
    <li class="patient">
        <h3 class="name"></h3>
        <h3 style="flex: fit-content">Age: <span class="age"></span></h3>
        <h3 class="pstatus"></h3>
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
<?php require __DIR__ . "/../partials/footer.php"; ?>