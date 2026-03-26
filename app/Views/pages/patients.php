<?php require __DIR__ . "/../partials/header.php"; ?>
<main>
    <?php require __DIR__ . "/../partials/sidebar.php"; ?>
    <main id="patients">
        <section class="actions">
            <button id="registerPatientBtn">
                <svg class="svg icon" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M2,21h8a1,1,0,0,0,0-2H3.071A7.011,7.011,0,0,1,10,13a5.044,5.044,0,1,0-3.377-1.337A9.01,9.01,0,0,0,1,20,1,1,0,0,0,2,21ZM10,5A3,3,0,1,1,7,8,3,3,0,0,1,10,5ZM23,16a1,1,0,0,1-1,1H19v3a1,1,0,0,1-2,0V17H14a1,1,0,0,1,0-2h3V12a1,1,0,0,1,2,0v3h3A1,1,0,0,1,23,16Z"></path></g></svg>
                <span>Register Patient</span>
            </button>
            <form action="/patients?search=" method="get">
                <div id="sorts">
                    <span>
                        <button id="byId" type="button" value="id">I.D</button>
                        <button id="byName" type="button" value="name">Name</button>
                        <button id="byAge" type="button" value="age">Age</button>
                    </span>
                    <span>
                        <button id="direction" type="button" value="ASC">ASC</button>
                    </span>
                </div>
                <span>
                    <input name="search" style="padding-right: 4em;" type="text" placeholder="Search">
                    <button id="searchBtn" type="submit">
                        <svg viewBox="0 0 20 20" class="svg icon" xmlns="http://www.w3.org/2000/svg" fill="none"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path fill="currentColor" fill-rule="evenodd" d="M4 9a5 5 0 1110 0A5 5 0 014 9zm5-7a7 7 0 104.2 12.6.999.999 0 00.093.107l3 3a1 1 0 001.414-1.414l-3-3a.999.999 0 00-.107-.093A7 7 0 009 2z"></path> </g></svg>
                    </button>
                </span>
            </form>
        </section>
        <section>
            <ul id="collection">
                <li>
                    <span class="profile">
                        <img src="assets/images/profile.png" alt="">
                    </span>
                    <table>
                        <tbody>
                            <tr>
                                <td><strong>I.D:</strong></td>
                                <td>patients name</td>
                            </tr>
                            <tr>
                                <td><strong>Name:</strong></td>
                                <td>patients name</td>
                            </tr>
                            <tr>
                                <td><strong>Age:</strong></td>
                                <td>patients name</td>
                            </tr>
                            <tr>
                                <td><strong>Sex:</strong></td>
                                <td>patients name</td>
                            </tr>
                        </tbody>
                        <tbody>
                            <tr>
                                <td><strong>Birthdate:</strong></td>
                                <td>patients name</td>
                            </tr>
                            <tr>
                                <td><strong>Address:</strong></td>
                                <td>patients name</td>
                            </tr>
                            <tr>
                                <td><strong>Contact:</strong></td>
                                <td>patients name</td>
                            </tr>
                            <tr>
                                <td><strong>Referred by:</strong></td>
                                <td>patients name</td>
                            </tr>
                        </tbody>
                    </table>
                    <div>
                        <button>
                            <svg viewBox="0 0 24 24" class="svg sm-icon" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="currentColor"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><g id="🔍-Product-Icons" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"> <g id="ic_fluent_patient_24_regular" fill="currentColor" fill-rule="nonzero"> <path d="M17.75,2 C18.9926407,2 20,3.00735931 20,4.25 L20,19.754591 C20,20.9972317 18.9926407,22.004591 17.75,22.004591 L6.25,22.004591 C5.00735931,22.004591 4,20.9972317 4,19.754591 L4,4.25 C4,3.05913601 4.92516159,2.08435508 6.09595119,2.00519081 L6.25,2 L17.75,2 Z M18.5,16 L5.5,16 L5.5,19.754591 C5.5,20.1688046 5.83578644,20.504591 6.25,20.504591 L17.75,20.504591 C18.1642136,20.504591 18.5,20.1688046 18.5,19.754591 L18.5,16 Z M7.75128856,17.5 L16.25,17.5 C16.6642136,17.5 17,17.8357864 17,18.25 C17,18.6296958 16.7178461,18.943491 16.3517706,18.9931534 L16.25,19 L7.75128856,19 C7.337075,19 7.00128856,18.6642136 7.00128856,18.25 C7.00128856,17.8703042 7.28344245,17.556509 7.64951801,17.5068466 L7.75128856,17.5 L16.25,17.5 L7.75128856,17.5 Z M17.75,3.5 L6.25,3.5 L6.14822944,3.50684662 C5.78215388,3.55650904 5.5,3.87030423 5.5,4.25 L5.5,14.5 L8,14.5 L8,12.2455246 C8,11.5983159 8.49187466,11.0659907 9.12219476,11.0019782 L9.25,10.9955246 L14.75,10.9955246 C15.3972087,10.9955246 15.9295339,11.4873992 15.9935464,12.1177193 L16,12.2455246 L16,14.5 L18.5,14.5 L18.5,4.25 C18.5,3.83578644 18.1642136,3.5 17.75,3.5 Z M14.5,12.4955246 L9.5,12.4955246 L9.5,14.5 L14.5,14.5 L14.5,12.4955246 Z M12,4.99552458 C13.3807119,4.99552458 14.5,6.11481271 14.5,7.49552458 C14.5,8.87623646 13.3807119,9.99552458 12,9.99552458 C10.6192881,9.99552458 9.5,8.87623646 9.5,7.49552458 C9.5,6.11481271 10.6192881,4.99552458 12,4.99552458 Z M12,6.49552458 C11.4477153,6.49552458 11,6.94323983 11,7.49552458 C11,8.04780933 11.4477153,8.49552458 12,8.49552458 C12.5522847,8.49552458 13,8.04780933 13,7.49552458 C13,6.94323983 12.5522847,6.49552458 12,6.49552458 Z"> </path> </g> </g> </g></svg>
                        </button>
                        <button>
                            <svg viewBox="0 0 24 24" class="svg sm-icon" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M2,21H8a1,1,0,0,0,0-2H3.071A7.011,7.011,0,0,1,10,13a5.044,5.044,0,1,0-3.377-1.337A9.01,9.01,0,0,0,1,20,1,1,0,0,0,2,21ZM10,5A3,3,0,1,1,7,8,3,3,0,0,1,10,5ZM20.207,9.293a1,1,0,0,0-1.414,0l-6.25,6.25a1.011,1.011,0,0,0-.241.391l-1.25,3.75A1,1,0,0,0,12,21a1.014,1.014,0,0,0,.316-.051l3.75-1.25a1,1,0,0,0,.391-.242l6.25-6.25a1,1,0,0,0,0-1.414Zm-5,8.583-1.629.543.543-1.629L19.5,11.414,20.586,12.5Z"></path></g></svg>
                        </button>
                        <button>
                            <svg viewBox="0 0 24 24" class="svg sm-icon" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M1,20a1,1,0,0,0,1,1h8a1,1,0,0,0,0-2H3.071A7.011,7.011,0,0,1,10,13a5.044,5.044,0,1,0-3.377-1.337A9.01,9.01,0,0,0,1,20ZM10,5A3,3,0,1,1,7,8,3,3,0,0,1,10,5Zm12.707,9.707L20.414,17l2.293,2.293a1,1,0,1,1-1.414,1.414L19,18.414l-2.293,2.293a1,1,0,0,1-1.414-1.414L17.586,17l-2.293-2.293a1,1,0,0,1,1.414-1.414L19,15.586l2.293-2.293a1,1,0,0,1,1.414,1.414Z"></path></g></svg>
                        </button>
                    </div>
                </li>
            </ul>
        </section>
    </main>
    <?php require __DIR__ . "/../partials/registerPatient.php"; ?>
    <?php require __DIR__ . "/../partials/viewPatient.php"; ?>
</main>
<?php require __DIR__ . "/../partials/footer.php"; ?>