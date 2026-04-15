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
            <button id="todayBtn" class="btn-pill btn-highlight">Today</button>
        </div>
    </section>
    <section id="list" class="acrylic-bg">
        <ul id="collection">
        </ul>
    </section>
</main>
<div id="setSched" class="popup">
    <form id="setSchedForm" class="form-ui" action="/schedule/add" method="post">
        <span class="p-sm">
            <h2 id="selectedDate" class="ctr-text">selecteddated</h2>
        </span>
        <span class="rel p-sm">
            <button id="pickPatient" class="btn-square" type="button">
                <svg class="sm-icon" viewBox="0 0 20 20" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="currentColor"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <title>profile [#1339]</title> <desc>Created with Sketch.</desc> <defs> </defs> <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"> <g id="Dribbble-Light-Preview" transform="translate(-260.000000, -2159.000000)" fill="currentColor"> <g id="icons" transform="translate(56.000000, 160.000000)"> <path d="M218,2005 C218,2002.794 216.206,2001 214,2001 C211.794,2001 210,2002.794 210,2005 C210,2007.206 211.794,2009 214,2009 C216.206,2009 218,2007.206 218,2005 L218,2005 Z M224,2019 L219,2019 L219,2017 L221.784,2017 C220.958,2013.214 217.785,2011 214,2011 C210.215,2011 207.042,2013.214 206.216,2017 L209,2017 L209,2019 L204,2019 C204,2014.445 206.583,2011.048 210.242,2009.673 C208.876,2008.574 208,2006.89 208,2005 C208,2001.686 210.686,1999 214,1999 C217.314,1999 220,2001.686 220,2005 C220,2006.89 219.124,2008.574 217.758,2009.673 C221.417,2011.048 224,2014.445 224,2019 L224,2019 Z M216.414,2013.757 L217.828,2015.172 L214,2019 L211.172,2016.172 L212.586,2014.757 L214,2016.172 L216.414,2013.757 Z"> </path> </g> </g> </g> </g></svg>
                <span>Patients List</span>
            </button>
            <ul id="patientOption"></ul>
        </span>
        <span>
            <input id="getDate" name="getDate" type="date" required hidden>
        </span>
        <div class="part p-sm">
            <span>
                <input id="firstName" name="firstName" type="text" required>
                <label for="firstName">First Name</label>
            </span>
            <span>
                <input id="lastName" name="lastName" type="text" required>
                <label for="lastName">Last Name</label>
            </span>
        </div>
        <div class="part p-sm">
            <span>
                <input id="contact" name="contact" type="text" required>
                <label for="contact">Contact</label>
            </span>
            <span>
                <input id="exContact" name="exContact" type="text" required>
                <label for="exContact">Additional Contact</label>
            </span>
        </div>
        <span class="p-sm">
            <input id="scheduledFor" name="scheduledFor" type="text" required>
            <label for="scheduledFor">For</label>
        </span>
        <div class="part p-sm">
            <button class="btn-pill btn-accent" type="submit">Set</button>
            <button class="btn-pill btn-highlight" type="reset" onclick="closePopup()">Cancel</button>
        </div>
    </form>
</div>
<div id="editSched" class="popup">
    <form id="editSchedForm" class="form-ui">
        <span class="p-sm">
            <input id="updateSchedFor" type="text" required>
            <label for="updateSchedFor">For</label>
        </span>
        <div class="part p-sm">
            <button class="btn-pill btn-accent" type="submit">Set</button>
            <button class="btn-pill btn-highlight" type="reset" onclick="closePopup()">Cancel</button>
        </div>
    </form>
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
            <h3 class="schedDate" style="font-size: var(--normal); opacity: 75%">nov 21, 2026</h3>
            <h3 class="patientName" style="font-size: var(--normal); opacity: 75%">firstname, lastname</h3>
            <h3 class="schedFor" style="background: var(--bg-dim); padding: 0.5em; border-radius: var(--radius)">for:</h3>
        </span>
        <div>
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