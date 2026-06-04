<?php require __DIR__ . "/../partials/header.php"; ?>
<main id="distribution">
    <section id="unassignedPatientsPanel" class="acrylic-bg main-panel fc" style="gap: 0.5em">
        <h3>Unassigned Patients</h3>
        <ul id="unassignedPatients"></ul>
    </section>
    <section class="acrylic-bg main-panel fc" style="gap: 0.5em">
        <h3>Distribute</h3>
        <ul id="distribute"></ul>
    </section>
    <section class="acrylic-bg main-panel fc" style="gap: 0.5em">
        <div class="f" style="justify-content: space-between">
            <h3>Maintenance</h3>
            <div class="f">
                <button id="todayBtn" class="btn-bordered btn-highlight">Today</button>
                <button id="viewReportBtn" class="btn-bordered btn-highlight f aj-c">
                    <svg class="sm-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M7 17H5C3.89543 17 3 16.1046 3 15V11C3 9.34315 4.34315 8 6 8H7M7 17V14H17V17M7 17V18C7 19.1046 7.89543 20 9 20H15C16.1046 20 17 19.1046 17 18V17M17 17H19C20.1046 17 21 16.1046 21 15V11C21 9.34315 19.6569 8 18 8H17M7 8V6C7 4.89543 7.89543 4 9 4H15C16.1046 4 17 4.89543 17 6V8M7 8H17M15 11H17" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                    View Report
                </button>
            </div>
        </div>
        <div class="f" style="justify-content: space-between;">
            <button id="prev" class="btn-circle btn-highlight">
                <svg class="icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path fill-rule="evenodd" clip-rule="evenodd" d="M15.7071 4.29289C16.0976 4.68342 16.0976 5.31658 15.7071 5.70711L9.41421 12L15.7071 18.2929C16.0976 18.6834 16.0976 19.3166 15.7071 19.7071C15.3166 20.0976 14.6834 20.0976 14.2929 19.7071L7.29289 12.7071C7.10536 12.5196 7 12.2652 7 12C7 11.7348 7.10536 11.4804 7.29289 11.2929L14.2929 4.29289C14.6834 3.90237 15.3166 3.90237 15.7071 4.29289Z" fill="currentColor"></path> </g></svg>
            </button>
            <h2 id="date">June 2026</h2>
            <button id="next" class="btn-circle btn-highlight">
                <svg class="icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path fill-rule="evenodd" clip-rule="evenodd" d="M8.29289 4.29289C8.68342 3.90237 9.31658 3.90237 9.70711 4.29289L16.7071 11.2929C17.0976 11.6834 17.0976 12.3166 16.7071 12.7071L9.70711 19.7071C9.31658 20.0976 8.68342 20.0976 8.29289 19.7071C7.90237 19.3166 7.90237 18.6834 8.29289 18.2929L14.5858 12L8.29289 5.70711C7.90237 5.31658 7.90237 4.68342 8.29289 4.29289Z" fill="currentColor"></path> </g></svg>
            </button>
        </div>
        <div class="f" style="flex-wrap: wrap;">
            <button class="day-btn btn-bordered btn-highlight flswb selected" value="Sunday" data-day="0">Sun</button>
            <button class="day-btn btn-bordered btn-highlight flswb" value="Monday" data-day="1">Mon</button>
            <button class="day-btn btn-bordered btn-highlight flswb" value="Tuesday" data-day="2">Tue</button>
            <button class="day-btn btn-bordered btn-highlight flswb" value="Wednesday" data-day="3">Wed</button>
            <button class="day-btn btn-bordered btn-highlight flswb" value="Thursday" data-day="4">Thu</button>
            <button class="day-btn btn-bordered btn-highlight flswb" value="Friday" data-day="5">Fri</button>
            <button class="day-btn btn-bordered btn-highlight flswb" value="Saturday" data-day="6">Sat</button>
        </div>
        <ul id="collection"></ul>
    </section>
</main>
<template id="unassignedCard">
    <li class="f flswb" style="flex-wrap: wrap;">
        <h4 class="name">Patient Name</h4>
        <form class="assignForm" style="margin-left: auto;">
            <select class="day">
                <option value="Sunday">Sunday</option>
                <option value="Monday">Monday</option>
                <option value="Tuesday">Tuesday</option>
                <option value="Wednesday">Wednesday</option>
                <option value="Thursday">Thursday</option>
                <option value="Friday">Friday</option>
                <option value="Saturday">Saturday</option>
            </select>
            <button class="btn-bordered btn-accent"type="submit" style="font-weight: var(--bold);">Confirm</button>
        </form>
    </li>
</template>
<template id="distributeCard">
    <li class="fc">
        <h3 class="name">name</h3>
        <ul class="medicineGivenList needs"></ul>
    </li>
</template>
<template id="medicineGivenCard">
    <li class="fr" style="flex-wrap: wrap; gap: 1em;">
        <div class="meds">
            <h3 class="medicineName">medicine(brand)</h3>
            <h3 class="medicineDosage">dosage</h3>
            <h3 class="medicineForm">form</h3>
            <h3 class="medicineIsMaintenance hidden">Maintenance</h3>
        </div>
        <div class="f fit" style="align-items: center; margin-left: auto">
            <input class="quantity" type="number" style="width:6rem;" maxlength="2">
            <button class="giveBtn btn-bordered btn-accent">Give</button>
        </div>
    </li>
</template>
<template id="maintenanceCard">
    <li class="rel">
        <form class="maintenanceForm maintenance-list fc" method="post">
            <div class="f" style="flex-wrap: wrap; justify-content: space-between">
                <div class="f">
                    <input class="date" type="date" required>
                    <h4 class="day" style="opacity: 50%;"></h4>
                </div>
                <form class="assignForm">
                    <select class="newDay" style="padding: 0.5em">
                        <option value="Sunday">Sunday</option>
                        <option value="Monday">Monday</option>
                        <option value="Tuesday">Tuesday</option>
                        <option value="Wednesday">Wednesday</option>
                        <option value="Thursday">Thursday</option>
                        <option value="Friday">Friday</option>
                        <option value="Saturday">Saturday</option>
                    </select>
                    <button class="btn-bordered btn-accent"type="submit" style="font-weight: var(--bold);">Confirm</button>
                </form>
            </div>
            <div class="f" style="justify-content: space-between;">
                <h3 class="name"></h3>
                <h4 class="age"></h4>
            </div>
            <ul class="maintenanceMeds"></ul>
            <div style="display: flex; gap: 0.5em; margin-left:auto">
                <button class="given btn-bordered btn-accent" value="true">Given</button>
                <button class="notGiven btn-bordered btn-critical" value="false">Not Given</button>
            </div>
        </form>
        <div class="maintenanceStatus">
            <h1 class="isGiven"></h1>
            <div class="f aj-c" style="flex-wrap: wrap;">
                <div class="f">
                    <input class="updateDate" type="date" style="background: var(--bg); padding: 0.5em; width:fit-content; color: var(--font-color)" required>
                    <button class="updateGiven btn-bordered btn-accent" value="true">Given</button>
                </div>
                <form class="updateAssignForm f">
                    <select class="updateDay" style="background: var(--bg); padding: 0.5em">
                        <option value="Sunday">Sunday</option>
                        <option value="Monday">Monday</option>
                        <option value="Tuesday">Tuesday</option>
                        <option value="Wednesday">Wednesday</option>
                        <option value="Thursday">Thursday</option>
                        <option value="Friday">Friday</option>
                        <option value="Saturday">Saturday</option>
                    </select>
                    <button class="btn-bordered btn-accent"type="submit" style="font-weight: var(--bold);">Confirm</button>
                </form>
            </div>
        </div>
    </li>
</template>
<template id="maintenanceMedsCard">
    <li class="meds">
        <h3 class="medicineName"></h3>
        <h3 class="dosage"></h3>
    </li>
</template>
<?php 
    require __DIR__ . '/../prints/maintenance_report.print.php';
    require __DIR__ . "/../partials/footer.php"; 
?>