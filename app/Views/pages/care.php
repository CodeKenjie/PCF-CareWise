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
        </section>
    </div>
</main>
<template id="patientCareCard">
    <li class="patient">
        <h3 class="name"></h3>
        <h3 class="age"></h3>
        <h3 class="modified">August 12, 2026</h3>
    </li>
</template>
<?php require __DIR__ . "/../partials/footer.php"; ?>