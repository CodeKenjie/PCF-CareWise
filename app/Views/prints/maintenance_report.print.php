<div id="maintenanceReport" class="popup">
    <span class="abs">
        <button class="btn-borderless btn-accent" style="color: var(--alt-font-color); background: var(--button-color)" onclick="window.print()">
            <svg class="sm-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M7 17H5C3.89543 17 3 16.1046 3 15V11C3 9.34315 4.34315 8 6 8H7M7 17V14H17V17M7 17V18C7 19.1046 7.89543 20 9 20H15C16.1046 20 17 19.1046 17 18V17M17 17H19C20.1046 17 21 16.1046 21 15V11C21 9.34315 19.6569 8 18 8H17M7 8V6C7 4.89543 7.89543 4 9 4H15C16.1046 4 17 4.89543 17 6V8M7 8H17M15 11H17" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
            Print Report
        </button>
        <button class="btn-bordered btn-highlight" style="background: var(--bg);" onclick="closePopup()">Cancel</button>
    </span>
    <div id="printPage fc" style="gap: 1em">
        <header class="rel">
            <img class="abs" style="width: 4rem; height: 4rem; top: 0; left: 0;" src="/assets/images/logo.png" alt="">
            <span style="display: flex; flex-direction:column; gap: 0">
                <h4>Philadelphia Christcenter Fellowship</h6>
                <h6># 26 Lunas Street, Quezon City, Philippines, 1114</h6>
                <h6>pcfmainchurch@gmail.com</h6>
            </span>
            <h4 id="printDate" class="abs" style="top: 0; right: 0"></h4>
        </header>
        <h3 class="ctr-text" style="width: 100%;">Maintenance Records</h3>
        <ul id="recordCollection"></ul>
    </div>
</div>
<template id="reportCard">
    <li>
        <span class="profile">
            <img class="printAvatar" src="/assets/images/profile.png" alt="">
        </span>
        <div class="fc" style="flex: 1 1 0; gap: 0.5em">
            <div class="f" style="width: 100%;">
                <h3 class="name"></h3>
                <h3 class="age"></h3>
                <h3 class=""></h3>
            </div>
            <ul class="dates"></ul>
        </div>
    </li>
</template>
<template id="dateCard">
    <li class="fc">
        <h4 class="date ctr-text">date</h4>
        <h4 class="maintenanceReport ctr-text">status</h4>
    </li>
</template>