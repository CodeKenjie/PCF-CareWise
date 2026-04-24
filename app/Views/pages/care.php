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
    <div class="fw">
        <section class="acrylic-bg">
            <ul id="collection"></ul>
        </section>
        <section id="diagnose" class="acrylic-bg">
            <div id="info">
                <div class="avatar">
                    <span class="profile">
                        <img src="/assets/images/profile.png" alt="">
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
                </div>
            </div>
            <form id="diagnosisForm" action="/care/patient" method="post">
                <h5>Diagnosis:</h3>
                <input id="conditionName" name="conditionName" type="text" style="padding: 0.5em;" placeholder="Condition Name">
                <button class="btn-borderless btn-highlight" type="submit">
                    <svg class="sm-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g id="Edit / Add_Plus_Square"> <path id="Vector" d="M8 12H12M12 12H16M12 12V16M12 12V8M4 16.8002V7.2002C4 6.08009 4 5.51962 4.21799 5.0918C4.40973 4.71547 4.71547 4.40973 5.0918 4.21799C5.51962 4 6.08009 4 7.2002 4H16.8002C17.9203 4 18.4801 4 18.9079 4.21799C19.2842 4.40973 19.5905 4.71547 19.7822 5.0918C20.0002 5.51962 20.0002 6.07967 20.0002 7.19978V16.7998C20.0002 17.9199 20.0002 18.48 19.7822 18.9078C19.5905 19.2841 19.2842 19.5905 18.9079 19.7822C18.4805 20 17.9215 20 16.8036 20H7.19691C6.07899 20 5.5192 20 5.0918 19.7822C4.71547 19.5905 4.40973 19.2842 4.21799 18.9079C4 18.4801 4 17.9203 4 16.8002Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g> </g></svg>
                </button>
            </form>
            <ul id="diagnosis"></ul>
            <div class="p-sm" style="flex: 1 1 0; display:flex; flex-direction: column; justify-content: space-between; gap: 0.5em">
                <form id="prescriptionForm" action="/care/prescription" method="post" style="display: flex; justify-content: space-between; padding: 0;">
                    <h5>Prescriptions:</h3>
                    <button class="btn-borderless btn-highlight" type="submit">
                        <svg class="sm-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g id="Edit / Add_Plus_Square"> <path id="Vector" d="M8 12H12M12 12H16M12 12V16M12 12V8M4 16.8002V7.2002C4 6.08009 4 5.51962 4.21799 5.0918C4.40973 4.71547 4.71547 4.40973 5.0918 4.21799C5.51962 4 6.08009 4 7.2002 4H16.8002C17.9203 4 18.4801 4 18.9079 4.21799C19.2842 4.40973 19.5905 4.71547 19.7822 5.0918C20.0002 5.51962 20.0002 6.07967 20.0002 7.19978V16.7998C20.0002 17.9199 20.0002 18.48 19.7822 18.9078C19.5905 19.2841 19.2842 19.5905 18.9079 19.7822C18.4805 20 17.9215 20 16.8036 20H7.19691C6.07899 20 5.5192 20 5.0918 19.7822C4.71547 19.5905 4.40973 19.2842 4.21799 18.9079C4 18.4801 4 17.9203 4 16.8002Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g> </g></svg>
                    </button>
                </form>
                <ul id="prescription"></ul>
            </div>
        </section>
    </div>
</main>
<div id="prescribeMed" class="popup">
    <form class="form-ui" action="/care/prescribe/" method="post">
        <span class="btn-close" onclick="closePopup()"></span>
        <input id="medicineId" name="medicineId" type="text" readonly hidden>
        <span class="rel p-sm">
            <input id="medicineName" name="medicineName" type="text">
            <label>Medicine</label>
            <ul id="medicineOptn" class="dropdown"></ul>
        </span>
        <span class="p-sm">
            <input id="prescribedDosage" name="prescribedDosage" type="text">
            <label>Dosage</label>
        </span>
        <span class="p-sm">
            <input id="prescribed" name="medicineName" type="text">
            <label>Dosage</label>
        </span>
    </form>
</div>
<div id="deletePrescription" class="delete popup">
    <form id="deletePrescriptionForm" class="form-ui" action="/medicines/delete">
        <header>
            <svg class="svg icon" viewBox="-5.5 0 32 32" version="1.1" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <title>warning</title> <path d="M10.16 25.92c-2.6 0-8.72-0.24-9.88-2.24-1.28-2.28 2.040-8.24 3.080-10.040 1.040-1.76 4.64-7.56 7.12-7.56 2.8 0 7.24 7.48 8.56 10.12 1.92 3.84 2.48 6.4 1.56 7.6-1.52 2.040-8.96 2.12-10.44 2.12zM10.48 7.72c-0.72 0-3.080 2.36-5.64 6.76-2.76 4.68-3.48 7.72-3.080 8.4 0.32 0.56 3.2 1.4 8.4 1.4 5.44 0 8.64-0.88 9.080-1.48 0.28-0.36 0.040-2.28-1.72-5.84-2.64-5.28-6.12-9.24-7.040-9.24zM10.52 19.2c-0.48 0-0.84-0.36-0.84-0.84v-6.36c0-0.48 0.36-0.84 0.84-0.84s0.84 0.36 0.84 0.84v6.32c0 0.48-0.4 0.88-0.84 0.88zM11.36 21.36c0 0.464-0.376 0.84-0.84 0.84s-0.84-0.376-0.84-0.84c0-0.464 0.376-0.84 0.84-0.84s0.84 0.376 0.84 0.84z"></path> </g></svg>
            <h4>Delete Prescription</h4>
        </header>
        <hr style="height: 1px; color: var(--border-color);">
        <span class="p-md">
            <p>Are you sure that you want to delete 
                Prescription: <strong style="color:var(--critical)" id="name"></strong> 
                id: <strong style="color: var(--critical);" id="id"></strong> from Medicines?
            </p>
            <p>Reminder: You will not be able to recover deleted data.</p>
        </span>
        <div>
            <button class="btn-square btn-critical" type="submit">Delete</button>
            <button class="btn-square btn-highlight" type="button" onclick="closePopup()">Cancel</button>
        </div>
    </form>
</div>
<template id="prescriptionCard">
    <li>
        <div style="flex: 1 1 0; display: flex;">
            <h3 class="createdAt" style="flex: 1 1 0;"></h3>
            <h3 class="conditionName" style="flex: 1 1 0;"></h3>
        </div>
        <button class="deletePrescription btn-borderless btn-critical" style="padding: 0.2em; flex: 0 0 fit-content">
            <svg class="sm-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g id="Edit / Add_Minus_Square"> <path id="Vector" d="M8 12H16M4 16.8002V7.2002C4 6.08009 4 5.51962 4.21799 5.0918C4.40973 4.71547 4.71547 4.40973 5.0918 4.21799C5.51962 4 6.08009 4 7.2002 4H16.8002C17.9203 4 18.4801 4 18.9079 4.21799C19.2842 4.40973 19.5905 4.71547 19.7822 5.0918C20.0002 5.51962 20.0002 6.07967 20.0002 7.19978V16.7998C20.0002 17.9199 20.0002 18.48 19.7822 18.9078C19.5905 19.2841 19.2842 19.5905 18.9079 19.7822C18.4805 20 17.9215 20 16.8036 20H7.19691C6.07899 20 5.5192 20 5.0918 19.7822C4.71547 19.5905 4.40973 19.2842 4.21799 18.9079C4 18.4801 4 17.9203 4 16.8002Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g> </g></svg>
        </button>
    </li>
</template>
<template id="medicineCard">
    <li class="medicine">
        <span class="p-sm">
            <h4 class="genericName">testing testing</h4>
            <h5 class="dosage" style="opacity: 50%;">dosage</h5>
            <h5 class="form" style="opacity: 50%;">form</h5>
        </span>
    </li>
</template>
<template id="patientCareCard">
    <li class="patient">
        <h3 class="name"></h3>
        <h3 class="age"></h3>
        <h3 class="modified">August 12, 2026</h3>
    </li>
</template>
<template id="conditionCard">
    <li>
        <div style="flex: 1 1 0; display: flex; align-items: center; padding: 1em">
            <span class="condition" style="flex: 1 1 0"></span>
            <span class="date" style="flex: 1 1 0;"></span>
        </div>
        <button class="removeCondition btn-borderless btn-critical" style="padding: 0.2em">
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
<?php require __DIR__ . "/../partials/footer.php"; ?>