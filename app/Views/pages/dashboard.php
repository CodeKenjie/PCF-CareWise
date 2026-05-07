<?php require __DIR__ . "/../partials/header.php"; ?>
<main id="dashboard">
    <section>
        <div class="acrylic-bg mini">
            <h1 id="activePatients"></h1>
            <h3>Active patients</h3>
        </div>
        <div class="acrylic-bg mini">
            <h1 id="inactivePatients"></h1>
            <h3>Inactive patients</h3>
        </div>
        <div class="acrylic-bg mini">
            <h1 id="totalPatients"></h1>
            <h3>Total patients</h3>
        </div>
    </section>
    <div class="sub-sec main-panel">
        <section class="acrylic-bg">
            <div style="display: flex; justify-content: space-between; align-items: center">
                <h3>Newly added patients:</h3>
                <a id="registerPatientBtn" class="btn-borderless btn-accent" style="padding: 0.5em; color: var(--alt-font-color);background: var(--button-color)" <?= ($isEditor ?? false) ? '' : 'hidden'?>>
                    <svg class="svg sm-icon" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M2,21h8a1,1,0,0,0,0-2H3.071A7.011,7.011,0,0,1,10,13a5.044,5.044,0,1,0-3.377-1.337A9.01,9.01,0,0,0,1,20,1,1,0,0,0,2,21ZM10,5A3,3,0,1,1,7,8,3,3,0,0,1,10,5ZM23,16a1,1,0,0,1-1,1H19v3a1,1,0,0,1-2,0V17H14a1,1,0,0,1,0-2h3V12a1,1,0,0,1,2,0v3h3A1,1,0,0,1,23,16Z"></path></g></svg>
                </a>
            </div>
            <ul id="newPatients"></ul>
        </section>
        <section class="acrylic-bg" style="flex: 1 1 0">
            <div style="display: flex; justify-content: space-between; align-items: center">
                <h3>Schedule today:</h3>
                <a class="btn-borderless btn-accent" style="padding: 0.5em; color: var(--alt-font-color);background: var(--button-color)" href="/schedule" <?= ($isEditor ?? false) ? '' : 'hidden'?>>
                    <svg viewBox="0 0 16 16" class="svg sm-icon" xmlns="http://www.w3.org/2000/svg" version="1.1" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <rect fill="none" height="10.5" width="12.5" y="3.75" x="1.75"></rect> <path d="m11.25 1.75v1.5m-6.5-1.5v1.5m-2.5 4h11.5"></path> </g></svg>
                </a>
            </div>
            <ul id="scheduleToday"></ul>
        </section>
    </div>
    <div class="sub-sec main-panel">
        <section class="acrylic-bg" style="flex-direction: row; flex-wrap: wrap;">
            <div style="flex: 1 1 0; display:flex; align-items:center; justify-content:center">
                <div class="rel donut-chart">
                    <svg viewbox="0 0 42 42" class="donut">
                        <circle fill="none" stroke="var(--sub-bg)" stroke-width="3" cx="21" cy="21" r="15.915"></circle>
                        <circle class="segment high" cx="21" cy="21" r="15.915"></circle>
                        <circle class="segment medium" cx="21" cy="21" r="15.915"></circle>
                        <circle class="segment low" cx="21" cy="21" r="15.915"></circle>
                    </svg>
                    <span class="abs ctr-text">
                        <h1 class="lrg-h" id="totalItems">0</h1>
                        <h3 id="label" style="font-size: var(--normal); font-weight: var(--bold); opacity: 50%">Items</h3>
                    </span>
                </div>
                <span class="info">
                    <p>High Stocks</p>
                    <p>Medium Stocks</p>
                    <p>Low Stocks</p>
                </span>
            </div>
            <div style="flex: 1 1 0; display:flex; align-items:center; justify-content: center">
                <div class="rel donut-chart">
                    <svg viewbox="0 0 42 42" class="donut">
                        <circle fill="none" stroke="var(--sub-bg)" stroke-width="3" cx="21" cy="21" r="15.915"></circle>
                        <circle class="segment good" cx="21" cy="21" r="15.915"></circle>
                        <circle class="segment soon" cx="21" cy="21" r="15.915"></circle>
                        <circle class="segment expired" cx="21" cy="21" r="15.915"></circle>
                    </svg>
                    <span class="abs ctr-text">
                        <h1 class="lrg-h" id="exp-status">0</h1>
                        <h3 id="explabel"style="font-size: var(--normal); font-weight: var(--bold); opacity: 50%">Items</h3>
                    </span>
                </div>
                <span class="info">
                    <p>Good Expiration</p>
                    <p>Expiring Soon</p>
                    <p>Expired</p>
                </span>
            </div>
        </section>
        <section class="acrylic-bg" style="flex: 1 1 0; min-height: 20rem">
            <h3>Need to be restocked:</h3>
            <ul id="inventoryRestock"></ul>
        </section>
    </div>
</main>
<div id="adjust" class="popup">
    <form id="adjustQuantForm" class="form-ui">
        <span class="btn-close btn-highlight" style="align-items: center;" onclick="closePopup()"></span>
        <div class="part p-sm" style="align-items: center;">
            <div class="p-sm" style="display:flex; flex-direction: column; align-items: center; gap: 0.5em;">
                <h3 style="opacity: 75%; font-size: var(--small);">Item</h3>
                <h3 id="imName"></h3>
            </div>
            <div class="p-sm" style="display:flex; flex-direction: column; align-items: center; gap: 0.5em;">
                <h3 style="opacity: 75%; font-size: var(--small);">Stocks</h3>
                <h3 id="imCurrentQuant"></h3>
            </div>
        </div>
        <span class="p-sm">
            <input id="valueInput" type="text" required>
            <label for="value">Import/Export</label>
        </span>
        <span class="p-sm">
            <button id="importBtn" class="btn-square btn-accent" type="reset" value="import" onclick="closePopup()">Import</button>
        </span>
    </form>
</div>
<div id="deleteItem" class="delete popup">
    <form id="deleteItemForm" class="form-ui" action="/inventory/delete" method="post">
        <header>
            <svg class="svg icon" viewBox="-5.5 0 32 32" version="1.1" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <title>warning</title> <path d="M10.16 25.92c-2.6 0-8.72-0.24-9.88-2.24-1.28-2.28 2.040-8.24 3.080-10.040 1.040-1.76 4.64-7.56 7.12-7.56 2.8 0 7.24 7.48 8.56 10.12 1.92 3.84 2.48 6.4 1.56 7.6-1.52 2.040-8.96 2.12-10.44 2.12zM10.48 7.72c-0.72 0-3.080 2.36-5.64 6.76-2.76 4.68-3.48 7.72-3.080 8.4 0.32 0.56 3.2 1.4 8.4 1.4 5.44 0 8.64-0.88 9.080-1.48 0.28-0.36 0.040-2.28-1.72-5.84-2.64-5.28-6.12-9.24-7.040-9.24zM10.52 19.2c-0.48 0-0.84-0.36-0.84-0.84v-6.36c0-0.48 0.36-0.84 0.84-0.84s0.84 0.36 0.84 0.84v6.32c0 0.48-0.4 0.88-0.84 0.88zM11.36 21.36c0 0.464-0.376 0.84-0.84 0.84s-0.84-0.376-0.84-0.84c0-0.464 0.376-0.84 0.84-0.84s0.84 0.376 0.84 0.84z"></path> </g></svg>
            <h4>Delete Item</h4>
        </header>
        <hr style="height: 1px; color: var(--border-color);">
        <span class="p-md">
            <p>Are you sure that you want to delete 
                item: <strong style="color:var(--critical)" id="name"></strong> 
                id: <strong style="color: var(--critical);" id="id"></strong> from inventory?
            </p>
            <p>Reminder: You will not be able to recover deleted data.</p>
        </span>
        <div>
            <button class="btn-square btn-critical" type="submit">Delete</button>
            <button class="btn-square btn-highlight" type="button" onclick="closePopup()">Cancel</button>
        </div>
    </form>
</div>
<div id="registerPatient" class="popup">
    <form id="registerPatientForm" class="form-ui" action="/patients/register" method="post">
        <div class="avatar">
            <span class="profile">
                <img src="assets/images/profile.png" alt="">
            </span>
            <input id="avatar" type="file" accept="image/*" hidden>
            <label for="avatar">
                <svg viewBox="0 0 32 32" class="svg sm-icon" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g fill="none" fill-rule="evenodd"> <path d="m0 0h32v32h-32z"></path> <path d="m24 2c4.418278 0 8 3.581722 8 8v12c0 4.418278-3.581722 8-8 8h-16c-4.418278 0-8-3.581722-8-8v-12c0-4.418278 3.581722-8 8-8zm-15.15704017 11.3933983-6.84295983 6.8426017v1.764c0 3.2383969 2.56557489 5.8775718 5.77506174 5.9958615l.22493826.0041385h15.45zm21.15704017-1.8643983-10.096 10.097 6.048224 6.0492469c2.2878684-.7868384 3.9503124-2.9181728 4.0436375-5.4503086l.0041385-.2249383zm-6-7.529h-16c-3.23839694 0-5.87757176 2.56557489-5.99586153 5.77506174l-.00413847.22493826v7.407l5.42874627-5.4278153c.74554637-.7455464 1.93326028-.7794348 2.71900373-.1016654l.1094234.1016654 8.2318266 8.2318153 11.3946671-11.39268045c-.5346164-2.67667729-2.8501212-4.71066623-5.6587288-4.81418108zm-5.4 2c2.209139 0 4 1.790861 4 4s-1.790861 4-4 4-4-1.790861-4-4 1.790861-4 4-4zm0 2c-1.1045695 0-2 .8954305-2 2s.8954305 2 2 2 2-.8954305 2-2-.8954305-2-2-2z" fill="currentColor" fill-rule="nonzero"></path> </g> </g></svg>
            </label>
        </div>
        <span class="p-sm">
            <input id="firstName" name="firstName" type="text" required>
            <label for="firstName">First Name</label>
        </span>
        <span class="p-sm">
            <input id="lastName" name="lastName" type="text" required>
            <label for="lastName">Last Name</label>
        </span>
        <div class="part p-sm">
            <span>
                <input id="birthdate" name="birthdate" type="date" required>
                <label for="birthdate">Birthdate</label>
            </span>
            <span>
                <select id="sex" name="sex" required>
                    <option value="" hidden></option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                </select>
                <label for="sex">Sex</label>
            </span>
        </div>
        <span class="p-sm">
            <input id="address" name="address" type="text" required>
            <label for="address">Address</label>
        </span>
        <div class="part p-sm">
            <span>
                <input id="contact" name="contact" type="text" maxlength="11" required>
                <label for="contact">Contact</label>
            </span>
            <span>
                <input id="exContact" name="exContact" type="text" placeholder="N/A" required>
                <label for="exContact">Contact#2(N/A)</label>
            </span>
        </div>
        <div class="part p-sm">
            <span>
                <input id="referredBy" name="referredBy" type="text" placeholder="N/A" required>
                <label for="referredBy">Referred by</label>
            </span>
            <span>
                <select id="status" name="status" required>
                    <option value="" hidden></option>
                    <option value="" hidden></option>
                    <option value="Active">Active</option>
                    <option value="Inactive">Inactive</option>
                    <option value="Follow up">Follow up</option>
                    <option value="Complete">Complete</option>
                    <option value="Deceased">Deceased</option>
                </select>
                <label for="status">Status</label>
            </span>
        </div>
        <div class="part p-sm">
            <button class="btn-accent btn-pill" type="submit">Submit</button>
            <button class="btn-highlight btn-pill" type="reset" onclick="closePopup()">Cancel</button>
        </div>
    </form>
</div>
<template id="newPatientCard">
    <li>
        <h3 class="patientName"></h3>
        <h3 class="patientSex"></h3>
        <h3 class="addedDate"></h3>
    </li>
</template>
<template id="todaySchedCard">
    <li>
        <div style="display:flex; gap: 1em; font-size: var(--small);">
            <h3 class="schedDate"></h3>
            <h3 class="schedTime" style="opacity: 50%"></h3>
        </div>
        <h3 class="clientName"></h3>
        <span class="scheduledFor"></span>
    </li>
</template>
<template id="lowItemCard">
    <li>
        <h3 class="itemName"></h3>
        <h3 class="itemCategory"></h3>
        <span class="rel" style="flex: 1 1 0; display: flex; justify-content: center">
            <h5 class="quantities abs itemQuant"></h5>
            <h3 class="itemStatus" style="cursor: pointer"></h3>
        </span>
        <button class="adjustBtn btn-borderless btn-accent" <?= ($isEditor ?? false) ? '' : 'hidden'?>>
            <svg class="svg sm-icon" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path fill-rule="evenodd" d="M19.7903934,18.6127185 L19.7072026,18.7069258 L16.7071326,21.7069258 C16.6801187,21.7339397 16.6515664,21.7594153 16.6216183,21.7832098 L16.500353,21.8659223 L16.500353,21.8659223 L16.427064,21.9043128 L16.427064,21.9043128 L16.3400271,21.9405322 L16.3400271,21.9405322 L16.2335653,21.9723902 L16.2335653,21.9723902 L16.116647,21.9930913 L16.033029,21.9992768 L16.033029,21.9992768 L15.9409671,21.9980859 L15.8251966,21.9845213 L15.8251966,21.9845213 L15.6878494,21.9500809 L15.6878494,21.9500809 L15.5767675,21.9061457 L15.5767675,21.9061457 L15.4792778,21.8538236 L15.4792778,21.8538236 L15.3832241,21.7870331 L15.2928749,21.7069258 L12.2927974,18.7069258 C11.902263,18.3164015 11.902263,17.6832365 12.2927974,17.2927122 C12.6532907,16.9322283 13.2205364,16.9044987 13.6128377,17.2095236 L13.7070475,17.2927122 L14.9998966,18.584819 L14.9999741,8.99981902 C14.9999741,8.48698318 15.3860143,8.06431186 15.883353,8.00654675 L16.0000259,7.99981902 C16.5523106,7.99981902 17.0000259,8.44753427 17.0000259,8.99981902 L16.9998966,18.584819 L18.2929525,17.2927122 C18.6534458,16.9322283 19.2206915,16.9044987 19.6129929,17.2095236 L19.7072026,17.2927122 C20.0376548,17.6231559 20.0884936,18.1273245 19.859719,18.511222 L19.7903934,18.6127185 L19.7903934,18.6127185 Z M4.29279737,5.29255711 L7.29286736,2.29255711 L7.40481484,2.1959774 L7.51569719,2.12453966 L7.51569719,2.12453966 L7.62891562,2.07076785 L7.62891562,2.07076785 L7.73413453,2.03538486 L7.73413453,2.03538486 L7.82519664,2.01496161 L7.82519664,2.01496161 L7.94096709,2.00139699 L8.05914398,2.00139699 L8.05914398,2.00139699 L8.17466132,2.0149356 L8.17466132,2.0149356 L8.31274961,2.04953478 L8.31274961,2.04953478 L8.36670687,2.06905084 L8.45385903,2.10832658 L8.45385903,2.10832658 L8.52068604,2.14573132 L8.52068604,2.14573132 L8.60170489,2.20078783 L8.60170489,2.20078783 L8.66547577,2.25320781 L8.66547577,2.25320781 L8.70713264,2.29255711 L11.7072026,5.29255711 L11.7903934,5.38676445 C12.0700068,5.74636472 12.0700068,6.25296306 11.7903934,6.61256333 L11.7072026,6.70677067 L11.6129929,6.78995928 C11.2533833,7.06956543 10.7467718,7.06956543 10.3871623,6.78995928 L10.2929525,6.70677067 L8.99989658,5.41466389 L9.00002585,14.9996639 C9.00002585,15.5124997 8.61398566,15.9351711 8.11664698,15.9929362 L8.00002585,15.9996639 L7.88335302,15.9929362 C7.42427116,15.9396145 7.06002351,15.5753669 7.00670188,15.116285 L6.99997415,14.9996639 L6.99989658,5.41466389 L5.7070475,6.70677067 L5.61283773,6.78995928 C5.22053638,7.09498417 4.65329066,7.06725463 4.29279737,6.70677067 C3.93230409,6.34628671 3.90457384,5.77905565 4.20960662,5.38676445 L4.29279737,5.29255711 Z"></path> </g></svg>
        </button>
        <button class="deleteBtn btn-borderless btn-critical" <?= ($isEditor ?? false) ? '' : 'hidden'?>>
            <svg class="sm-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M18.7069 7.79289C19.0974 8.18342 19.0974 8.81658 18.7069 9.20711L15.914 12L18.7069 14.7929C19.0974 15.1834 19.0974 15.8166 18.7069 16.2071C18.3163 16.5976 17.6832 16.5976 17.2926 16.2071L14.4998 13.4142L11.7069 16.2071C11.3163 16.5976 10.6832 16.5976 10.2926 16.2071C9.90212 15.8166 9.90212 15.1834 10.2926 14.7929L13.0855 12L10.2926 9.20711C9.90212 8.81658 9.90212 8.18342 10.2926 7.79289C10.6832 7.40237 11.3163 7.40237 11.7069 7.79289L14.4998 10.5858L17.2926 7.79289C17.6832 7.40237 18.3163 7.40237 18.7069 7.79289Z" fill="currentColor"></path> <path fill-rule="evenodd" clip-rule="evenodd" d="M6.30958 3.54424C7.06741 2.56989 8.23263 2 9.46699 2H20.9997C21.8359 2 22.6103 2.37473 23.1614 2.99465C23.709 3.61073 23.9997 4.42358 23.9997 5.25V18.75C23.9997 19.5764 23.709 20.3893 23.1614 21.0054C22.6103 21.6253 21.8359 22 20.9997 22H9.46699C8.23263 22 7.06741 21.4301 6.30958 20.4558L0.687897 13.2279C0.126171 12.5057 0.126169 11.4943 0.687897 10.7721L6.30958 3.54424ZM9.46699 4C8.84981 4 8.2672 4.28495 7.88829 4.77212L2.2666 12L7.88829 19.2279C8.2672 19.7151 8.84981 20 9.46699 20H20.9997C21.2244 20 21.4674 19.9006 21.6665 19.6766C21.8691 19.4488 21.9997 19.1171 21.9997 18.75V5.25C21.9997 4.88294 21.8691 4.5512 21.6665 4.32337C21.4674 4.09938 21.2244 4 20.9997 4H9.46699Z" fill="currentColor"></path> </g></svg>
        </button>
    </li>
</template>
<?php require __DIR__ . "/../partials/footer.php"; ?>