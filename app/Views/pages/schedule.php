<?php require __DIR__ . "/../partials/header.php"; ?>
<main id="schedule">
    <section id="calendar" class="acrylic-bg">
        <div id="month">
            <button id="prev" class="btn-circle btn-highlight">
                <svg class="icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path fill-rule="evenodd" clip-rule="evenodd" d="M15.7071 4.29289C16.0976 4.68342 16.0976 5.31658 15.7071 5.70711L9.41421 12L15.7071 18.2929C16.0976 18.6834 16.0976 19.3166 15.7071 19.7071C15.3166 20.0976 14.6834 20.0976 14.2929 19.7071L7.29289 12.7071C7.10536 12.5196 7 12.2652 7 12C7 11.7348 7.10536 11.4804 7.29289 11.2929L14.2929 4.29289C14.6834 3.90237 15.3166 3.90237 15.7071 4.29289Z" fill="currentColor"></path> </g></svg>
            </button>
            <label id="date"></label>
            <button id="next" class="btn-circle btn-highlight">
                <svg class="icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path fill-rule="evenodd" clip-rule="evenodd" d="M8.29289 4.29289C8.68342 3.90237 9.31658 3.90237 9.70711 4.29289L16.7071 11.2929C17.0976 11.6834 17.0976 12.3166 16.7071 12.7071L9.70711 19.7071C9.31658 20.0976 8.68342 20.0976 8.29289 19.7071C7.90237 19.3166 7.90237 18.6834 8.29289 18.2929L14.5858 12L8.29289 5.70711C7.90237 5.31658 7.90237 4.68342 8.29289 4.29289Z" fill="currentColor"></path> </g></svg>
            </button>
            <button id="addSchedBtn" class="btn-square btn-accent hidden" style="background: var(--button-color); color: var(--alt-font-color); border: none">
                <span>Schedule a Patient</span>
            </button>
        </div>
        <div id="weekdays">
            <span>Sun</span>
            <span>Mon</span>
            <span>Tue</span>
            <span>Wed</span>
            <span>Thur</span>
            <span>Fri</span>
            <span>Sat</span>
        </div>
        <div id="days"></div>
        <div id="nav">
            <span class="goto">
                <input id="dateInput" type="text" style="width: fit-content;" placeholder="month/year" maxlength="7">
                <button id="dateGotoBtn">Go</button>
            </span>
            <button id="todayBtn" class="btn-square btn-highlight">Today</button>
        </div>
    </section>
    <section id="list" class="acrylic-bg">
        <ul id="collection"></ul>
    </section>
</main>
<div id="setSched" class="popup">
    <form id="setSchedForm" class="form-ui" action="/schedule/add" method="post">
        <div style="display:flex; justify-content: space-between; align-items: center; gap: 1em;">
            <h2 id="selectedDate" class="ctr-text"></h2>
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
        <span class="rel p-sm">
            <input id="find" class="btn-square" type="text">
            <label for="find">Find Patient</label>
            <ul id="patientOption" class="dropdown"></ul>
        </span>
        <div class="part p-sm">
            <span>
                <input id="getDate" name="getDate" type="date" required>
                <label for="getDate">Date</label>
            </span>
            <span>
                <input id="getTime" name="getTime" type="time" required>
                <label for="getTime">Time</label>
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
            <textarea id="scheduledFor" name="scheduledFor" placeholder="Scheduled for" required></textarea>
            <label>For</label>
        </span>
        <div class="part p-sm">
            <button class="btn-pill btn-accent" type="submit">Set</button>
            <button class="btn-pill btn-highlight" type="reset" onclick="closePopup()">Cancel</button>
        </div>
    </form>
</div>
<div id="editSched" class="popup">
    <form id="editSchedForm" class="form-ui">
        <h3 id="sDate" class="p-sm"></h3>
        <h3 id="patientName" class="p-sm"></h3>
        <div class="part">
            <span class="p-sm">
                <input id="updateTime" type="time" required>
                <label for="updateTime">Time</label>
            </span>
            <span class="p-sm">
                <select id="updateFrequency" required>
                    <option value="" hidden></option>
                    <option value="Once">Once</option>
                    <option value="Everyday">Everyday</option>
                    <option value="Every week">Every week</option>
                    <option value="Every 30 days">Every 30 days</option>
                </select>
                <label for="updateStatus">Frequency</label>
            </span>
        </div>
        <span class="text-area p-sm">
            <textarea id="updateSchedFor" type="text" placeholder="Scheduled for" required></textarea>
            <label>For</label>
        </span>
        <div class="part p-sm">
            <button class="btn-pill btn-accent" type="submit">Set</button>
            <button class="btn-pill btn-highlight" type="reset" onclick="closePopup()">Cancel</button>
        </div>
    </form>
</div>
<div id="schedInfo" class="popup">
    <section class="preview">
        <section class="btn-close btn-highlight" onclick="closePopup()"></section>
        <div>
            <span>
                <label for="">Schedule ID:</label>
                <h3 id="sId"></h3>
            </span>
            <span>
                <label for="">Date:</label>
                <h3 id="vDate"></h3>
            </span>
            <span>
                <label for="">Time:</label>
                <h3 id="vTime"></h3>
            </span>
        </div>
        <span>
            <label for="">Patient Name:</label>
            <h3 id="sName"></h3>
        </span>
        <div>
            <span>
                <label for="">Patient Contact:</label>
                <h3 id="sContact"></h3>
            </span>
            <span>
                <label for="">Additional Contact:</label>
                <h3 id="sExContact"></h3>
            </span>
        </div>
    </section>
</div>
<div id="deleteSched" class="delete popup">
    <form id="deleteSchedForm" class="form-ui" action="/schedule/delete" method="post">
        <header>
            <svg class="svg icon" viewBox="-5.5 0 32 32" version="1.1" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <title>warning</title> <path d="M10.16 25.92c-2.6 0-8.72-0.24-9.88-2.24-1.28-2.28 2.040-8.24 3.080-10.040 1.040-1.76 4.64-7.56 7.12-7.56 2.8 0 7.24 7.48 8.56 10.12 1.92 3.84 2.48 6.4 1.56 7.6-1.52 2.040-8.96 2.12-10.44 2.12zM10.48 7.72c-0.72 0-3.080 2.36-5.64 6.76-2.76 4.68-3.48 7.72-3.080 8.4 0.32 0.56 3.2 1.4 8.4 1.4 5.44 0 8.64-0.88 9.080-1.48 0.28-0.36 0.040-2.28-1.72-5.84-2.64-5.28-6.12-9.24-7.040-9.24zM10.52 19.2c-0.48 0-0.84-0.36-0.84-0.84v-6.36c0-0.48 0.36-0.84 0.84-0.84s0.84 0.36 0.84 0.84v6.32c0 0.48-0.4 0.88-0.84 0.88zM11.36 21.36c0 0.464-0.376 0.84-0.84 0.84s-0.84-0.376-0.84-0.84c0-0.464 0.376-0.84 0.84-0.84s0.84 0.376 0.84 0.84z"></path> </g></svg>
            <h4>Delete Schedule</h4>
        </header>
        <hr style="height: 1px; color: var(--border-color);">
        <span class="p-md">
            <p>Are you sure that you want to delete
                <strong style="color:var(--critical)" id="name"></strong>
                scheduled: <strong style="color: var(--critical);" id="schedDate"></strong>?
            </p>
            <p>Reminder: You will not be able to recover deleted data.</p>
        </span>
        <div>
            <button class="btn-square btn-critical" type="submit">Delete</button>
            <button class="btn-square btn-highlight" type="button" onclick="closePopup()">Cancel</button>
        </div>
    </form>
</div>
<template id="patientOptnTemplate">
    <li class="patient p-sm">
        <div class="profile">
            <img src="/assets/images/profile.png" alt="">
        </div>
        <span>
            <h4 class="id"></h4>
            <h4 class="name"></h4>
        </span>
    </li>
</template>
<template id="scheduleCard">
    <li>
        <span>
            <div class="part">
                <h3 class="schedDate" style="font-size: var(--normal); opacity: 75%"></h3>
                <h3 class="schedTime" style="font-size: var(--normal); opacity: 75%"></h3>
            </div>
            <h3 class="patientName" style="font-size: var(--normal); opacity: 75%"></h3>
            <h3 class="schedFor" style="background: var(--bg-dim); padding: 0.5em; border-radius: var(--radius)"></h3>
        </span>
        <div>
            <button class="reSched btn-accent hidden">
                <svg class="sm-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M19.7341 16.0598C18.8808 17.778 17.5087 19.1725 15.8192 20.0384C14.1297 20.9043 12.212 21.1959 10.3476 20.8705C8.48325 20.545 6.77057 19.6196 5.46115 18.2302C4.15172 16.8407 3.31456 15.0606 3.07263 13.1511C2.8307 11.2416 3.19676 9.30348 4.11703 7.6214C5.0373 5.93933 6.46329 4.60195 8.18552 3.80573C9.90776 3.0095 11.8355 2.79638 13.6855 3.19769C15.5355 3.59899 17.0517 4.51138 18.3053 5.95312C18.4571 6.11323 19.0407 6.75937 19.5258 7.73437" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M15.0687 7.81298L20.109 8.71974L21 3.58952" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
            </button>
            <button class="editBtn btn-highlight">
                <svg class="sm-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M7 3V5M17 3V5M6.2 21H17.8C18.9201 21 19.4802 21 19.908 20.782C20.2843 20.5903 20.5903 20.2843 20.782 19.908C21 19.4802 21 18.9201 21 17.8V8.2C21 7.07989 21 6.51984 20.782 6.09202C20.5903 5.71569 20.2843 5.40973 19.908 5.21799C19.4802 5 18.9201 5 17.8 5H6.2C5.0799 5 4.51984 5 4.09202 5.21799C3.71569 5.40973 3.40973 5.71569 3.21799 6.09202C3 6.51984 3 7.07989 3 8.2V17.8C3 18.9201 3 19.4802 3.21799 19.908C3.40973 20.2843 3.71569 20.5903 4.09202 20.782C4.51984 21 5.07989 21 6.2 21ZM8 16.5L10.025 16.095C10.2015 16.0597 10.2898 16.042 10.3721 16.0097C10.4452 15.9811 10.5147 15.9439 10.579 15.899C10.6516 15.8484 10.7152 15.7848 10.8426 15.6574L15 11.5C15.5523 10.9477 15.5523 10.0523 15 9.5C14.4477 8.94772 13.5523 8.94772 13 9.5L8.84255 13.6574C8.71523 13.7848 8.65157 13.8484 8.60098 13.921C8.55608 13.9853 8.51891 14.0548 8.49025 14.1279C8.45796 14.2102 8.44031 14.2985 8.40499 14.475L8 16.5Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
            </button>
            <button class="viewBtn btn-highlight">
                <svg class="sm-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M12 9V14M12 17H12.01M7 3V5M17 3V5M6.2 21H17.8C18.9201 21 19.4802 21 19.908 20.782C20.2843 20.5903 20.5903 20.2843 20.782 19.908C21 19.4802 21 18.9201 21 17.8V8.2C21 7.07989 21 6.51984 20.782 6.09202C20.5903 5.71569 20.2843 5.40973 19.908 5.21799C19.4802 5 18.9201 5 17.8 5H6.2C5.0799 5 4.51984 5 4.09202 5.21799C3.71569 5.40973 3.40973 5.71569 3.21799 6.09202C3 6.51984 3 7.07989 3 8.2V17.8C3 18.9201 3 19.4802 3.21799 19.908C3.40973 20.2843 3.71569 20.5903 4.09202 20.782C4.51984 21 5.07989 21 6.2 21Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
            </button>
            <button class="deleteBtn btn-critical">
                <svg class="sm-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M16 13.0011L8 13M7 3V5M17 3V5M6.2 21H17.8C18.9201 21 19.4802 21 19.908 20.782C20.2843 20.5903 20.5903 20.2843 20.782 19.908C21 19.4802 21 18.9201 21 17.8V8.2C21 7.07989 21 6.51984 20.782 6.09202C20.5903 5.71569 20.2843 5.40973 19.908 5.21799C19.4802 5 18.9201 5 17.8 5H6.2C5.0799 5 4.51984 5 4.09202 5.21799C3.71569 5.40973 3.40973 5.71569 3.21799 6.09202C3 6.51984 3 7.07989 3 8.2V17.8C3 18.9201 3 19.4802 3.21799 19.908C3.40973 20.2843 3.71569 20.5903 4.09202 20.782C4.51984 21 5.07989 21 6.2 21Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
            </button>
        </div>
        </li>
</template>
<?php require __DIR__ . "/../partials/footer.php"; ?>