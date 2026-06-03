<div id="medicalReport" class="popup">
    <span class="abs">
        <button class="btn-borderless btn-accent f aj-c" style="color: var(--alt-font-color); background: var(--button-color)" onclick="window.print()">
            <svg class="sm-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M7 17H5C3.89543 17 3 16.1046 3 15V11C3 9.34315 4.34315 8 6 8H7M7 17V14H17V17M7 17V18C7 19.1046 7.89543 20 9 20H15C16.1046 20 17 19.1046 17 18V17M17 17H19C20.1046 17 21 16.1046 21 15V11C21 9.34315 19.6569 8 18 8H17M7 8V6C7 4.89543 7.89543 4 9 4H15C16.1046 4 17 4.89543 17 6V8M7 8H17M15 11H17" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
            Print Report
        </button>
        <button class="btn-bordered btn-highlight" style="background: var(--bg);" onclick="closePopup()">Cancel</button>
    </span>
    <div>
        <header class="rel">
            <img class="abs" style="width: 4rem; height: 4rem; top: 0; left: 0;" src="/assets/images/logo.png" alt="">
            <span style="display: flex; flex-direction:column; gap: 0">
                <h4>Philadelphia Christcenter Fellowship</h6>
                <h6># 26 Lunas Street, Quezon City, Philippines, 1114</h6>
                <h6>pcfmainchurch@gmail.com</h6>
            </span>
            <h4 id="printDate" class="abs" style="top: 0; right: 0"></h4>
        </header>
        <h3 class="ctr-text" style="width: 100%;">Medical Record</h3>
        <span>
            <span class="profile">
                <img id="printAvatar" src="/assets/images/profile.png" alt="">
            </span>
            <div style="flex: 1 1 0; display: grid; gap: 0.2em">
                <span style="display: flex; align-items: center">
                    <h5>Name:</h5>
                    <h4 id="printName"></h4>
                </span>
                <span style="display: flex; align-items: center">
                    <h5>Birthdate:</h5>
                    <h4 id="printBirthdate"></h4>
                </span>
                <span style="display: flex; align-items: center">
                    <h5>Age:</h5>
                    <h4 id="printAge"></h4>
                </span>
                <span style="display: flex; align-items: center">
                    <h5>Sex:</h5>
                    <h4 id="printSex"></h4>
                </span>
                <span style="display: flex; align-items: center">
                    <h5>Address:</h5>
                    <h4 id="printAddress"></h4>
                </span>
                <span style="display: flex; align-items: center">
                    <h5>Allergies:</h5>
                    <h4 id="printAllergies"></h4>
                </span>
                <span style="display: flex; align-items: center">
                    <h5>Contact/'s:</h5>
                    <h4 id="printContacts"></h4>
                </span>
            </div>
        </span>
        <div style="display: flex; flex-direction: column;">
            <h5>Diagnosis:</h5>
            <ul id="printDiagnosis"></ul>
        </div>
        <div style="display: flex; flex-direction: column;">
            <h5>Prescriptions:</h5>
            <ul id="printPrescriptions"></ul>
        </div>
    </div>
</div>