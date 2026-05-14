<div id="activityPanel" class="popup">
    <div id="activityLogs" class="acrylic-bg" style="padding: 1em">
        <span class="btn-close btn-highlight" onclick="closePopup()"></span>
        <h4>Activities: </h4>
        <div>
            <ul id="collection"></ul>
            <button id="deleteAll" class="btn-borderless btn-critical" id="delete" style="color: var(--alt-font-color); background: var(--critical)">
                <svg class="sm-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M6 5H18M9 5V5C10.5769 3.16026 13.4231 3.16026 15 5V5M9 20H15C16.1046 20 17 19.1046 17 18V9C17 8.44772 16.5523 8 16 8H8C7.44772 8 7 8.44772 7 9V18C7 19.1046 7.89543 20 9 20Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                Delete all
            </button>
        </div>
    </div>
</div>
<template id="logCard">
    <li class="rel">
        <h3 class="ipAddress"></h3>
        <h3 class="name"></h3>
        <h3 class="action"></h3>
        <h3 class="agent"></h3>
        <h3 class="date"></h3>
        <h3 class="details abs"></h3>
    </li>
</template>