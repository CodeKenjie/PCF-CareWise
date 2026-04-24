<?php require __DIR__ . "/../partials/header.php"; ?>
<main id="medicines">
    <section class="actions acrylic-bg">
        <button id="addMedsBtn" class="addBtn btn-accent">
            <svg class="svg icon" height="200px" width="200px" version="1.1" id="_x32_" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" xml:space="preserve" fill="currentColor"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <style type="text/css"> .st0{fill:currentColor;} </style> <g> <path class="st0" d="M471.78,276.233l0.114,0.107l-237.5-234.786l0.008,0.016c-26.765-26.78-62.007-40.235-97.092-40.213 C102.222,1.335,66.988,14.789,40.216,41.57C13.431,68.341-0.024,103.584,0,138.673c-0.024,35.081,13.431,70.323,40.216,97.095 l237.439,234.732l-0.065-0.069c26.772,26.78,62.006,40.235,97.103,40.212c35.081,0.023,70.316-13.432,97.088-40.204 c26.788-26.78,40.242-62.022,40.22-97.111C512.023,338.239,498.568,302.997,471.78,276.233z M164.543,311.881 c-0.069,0.214-0.119,0.413-0.191,0.628L63.327,212.633l0.008,0.016c-20.454-20.47-30.62-47.15-30.636-73.976 c0.015-26.834,10.181-53.507,30.636-73.976c20.47-20.454,47.146-30.624,73.976-30.639c26.826,0.015,53.503,10.185,73.972,30.639 l0.108,0.108l104.753,103.55c-20.662,4.335-39.32,11.962-55.704,21.78c-35.46,21.274-60.67,52.043-77.273,80.876 C174.862,285.453,168.708,299.459,164.543,311.881z M448.66,447.311c-20.469,20.447-47.142,30.617-73.968,30.632 c-26.838-0.015-53.514-10.177-73.984-30.639l-0.061-0.061L191.238,339.081c0.326-2.105,0.808-4.58,1.508-7.321 c2.531-10.132,7.628-23.786,15.316-38.221c11.525-21.695,28.886-45.204,51.829-63.339c22.84-18.02,50.857-30.892,85.582-32.845 l103.142,101.958l0.045,0.038c20.462,20.47,30.624,47.15,30.64,73.976C479.285,400.153,469.123,426.834,448.66,447.311z"></path> <path class="st0" d="M81.477,170.66l35.747-85.456c-13.417,0-26.026,5.216-35.503,14.696 C62.148,119.473,62.148,151.331,81.477,170.66z"></path> </g> </g></svg>
            <span>Add Medicine</span>
        </button>
        <div>
            <form action="/patients/sort" method="get">
                <span class="sortsSpan">
                    <button id="sort1" class="btn-highlight" type="button" value="brand_name">Brand</button>
                    <button id="sort2" class="btn-highlight" type="button" value="generic_name">Generic</button>
                    <button id="sort3" class="btn-highlight" type="button" value="inventory.quantity">Quantity</button>
                    <button id="direction" class="btn-highlight" type="button" value="ASC">ASC</button>
                </span>
            </form>
            <form id="searchForm" action="/patients/patient" method="get">
                <span class="searchSpan">
                    <input id="search" name="search" style="padding-right: 4em;" type="text" placeholder="Search">
                    <button type="submit">
                        <svg viewBox="0 0 20 20" class="svg icon" xmlns="http://www.w3.org/2000/svg" fill="none"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path fill="currentColor" fill-rule="evenodd" d="M4 9a5 5 0 1110 0A5 5 0 014 9zm5-7a7 7 0 104.2 12.6.999.999 0 00.093.107l3 3a1 1 0 001.414-1.414l-3-3a.999.999 0 00-.107-.093A7 7 0 009 2z"></path> </g></svg>
                    </button>
                </span>
            </form>
        </div>
    </section>
    <section class="acrylic-bg">
        <ul id="collection"></ul>
    </section>
</main>
<div id="addMeds" class="popup">
    <form id="addMedsForm" class="form-ui" action="/medicines/add" method="post">
        <span class="p-sm">
            <input id="genName" name="genericName" type="text" required>
            <label for="">Generic Name</label>
        </span>
        <span class="p-sm">
            <input id="brndName" name="brandName" type="text" placeholder="N/A" required>
            <label for="">Brand Name</label>
        </span>
        <div class="part p-sm">
            <span>
                <input id="dosage" name="dosage" type="text" placeholder="N/A" required>
                <label for="">Dosage</label>
            </span>
            <span>
                <input id="form" name="form" type="text" placeholder="N/A" required>
                <label for="">Form</label>
            </span>
        </div>
        <div class="part">
            <button class="btn-pill btn-highlight" type="submit">Add</button>
            <button class="btn-pill btn-highlight" type="reset" onclick="closePopup()">Cancel</button>
        </div>
    </form>
</div>
<div id="medsPreview" class="popup">
    <section class="preview">
        <section class="btn-highlight btn-close" onclick="closePopup()"></section>
        <div>
            <span>
                <label for="mId"><strong>I.D:</strong></label>
                <h3 id="mId"></h3>
            </span>
            <span>
                <label for="mGenericName"><strong>Generic Name:</strong></label>
                <h3 id="mGenericName"></h3>
            </span>
            <span>
                <label for="mBrandName"><strong>Brand Name:</strong></label>
                <h3 id="mBrandName"></h3>
            </span>
        </div>
        <div>
            <span>
                <label for="mDosage"><strong>Dosage:</strong></label>
                <h3 id="mDosage"></h3>
            </span>
            <span>
                <label for="mForm"><strong>Form:</strong></label>
                <h3 id="mForm"></h3>
            </span>
            <span>
                <label for="mCategory"><strong>Category:</strong></label>
                <h3 id="mCategory"></h3>
            </span>
        </div>
        <div>
            <span>
                <label for="mQuantity"><strong>Stock:</strong></label>
                <h3 id="mQuantity"></h3>
            </span>
            <span>
                <label for="mMinQuant"><strong>Min:</strong></label>
                <h3 id="mMinQuant"></h3>
            </span>
        </div>
        <div>
            <span>
                <label for="mExpiration"><strong>Expr Date:</strong></label>
                <h3 id="mExpiration"></h3>
            </span>
            <span>
                <label for="mIsDonated"><strong>Donated:</strong></label>
                <h3 id="mIsDonated"></h3>
            </span>
        </div>
    </section>
</div>
<div id="editMeds" class="popup">
    <form id="editMedsForm" class="form-ui" action="/medicines/edit" method="post">
        <span class="p-sm">
            <input id="genericName" type="text" required>
            <label for="">Generic Name</label>
        </span>
        <span class="p-sm">
            <input id="brandName" type="text" placeholder="N/A" required>
            <label for="">Brand Name</label>
        </span>
        <div class="part p-sm">
            <span>
                <input id="dosage" type="text" placeholder="N/A" required>
                <label for="">Dosage</label>
            </span>
            <span>
                <input id="form" type="text" placeholder="N/A" required>
                <label for="">Form</label>
            </span>
        </div>
        <div class="part">
            <button class="btn-pill btn-highlight" type="submit">Update</button>
            <button class="btn-pill btn-highlight" type="reset" onclick="closePopup()">Cancel</button>
        </div>
    </form>
</div>
<div id="deleteMeds" class="delete popup">
    <form id="deleteMedsForm" class="form-ui" action="/medicines/delete" method="post">
        <header>
            <svg class="svg icon" viewBox="-5.5 0 32 32" version="1.1" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <title>warning</title> <path d="M10.16 25.92c-2.6 0-8.72-0.24-9.88-2.24-1.28-2.28 2.040-8.24 3.080-10.040 1.040-1.76 4.64-7.56 7.12-7.56 2.8 0 7.24 7.48 8.56 10.12 1.92 3.84 2.48 6.4 1.56 7.6-1.52 2.040-8.96 2.12-10.44 2.12zM10.48 7.72c-0.72 0-3.080 2.36-5.64 6.76-2.76 4.68-3.48 7.72-3.080 8.4 0.32 0.56 3.2 1.4 8.4 1.4 5.44 0 8.64-0.88 9.080-1.48 0.28-0.36 0.040-2.28-1.72-5.84-2.64-5.28-6.12-9.24-7.040-9.24zM10.52 19.2c-0.48 0-0.84-0.36-0.84-0.84v-6.36c0-0.48 0.36-0.84 0.84-0.84s0.84 0.36 0.84 0.84v6.32c0 0.48-0.4 0.88-0.84 0.88zM11.36 21.36c0 0.464-0.376 0.84-0.84 0.84s-0.84-0.376-0.84-0.84c0-0.464 0.376-0.84 0.84-0.84s0.84 0.376 0.84 0.84z"></path> </g></svg>
            <h4>Delete Medicine</h4>
        </header>
        <hr style="height: 1px; color: var(--border-color);">
        <span class="p-md">
            <p>Are you sure that you want to delete 
                Medicine: <strong style="color:var(--critical)" id="name"></strong> 
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
<template id="medicineCard">
    <li>
        <span>
            <h2 class="genericName"></h3>
            <h3 class="brandName" style="opacity: 75%;"></h3>
            <h3 class="dosage" style="opacity: 75%;"></h3>
            <h4 class="form" style="opacity: 75%;"></h4>
        </span>
        <span style="text-align: end;">
            <h2 class="quantity"></h2>
            <h4 class="minQuant" style="opacity: 75%;"></h4>
            <h4 class="isDonated" style="opacity: 75%;"></h4>
            <h4 class="expiration" style="opacity: 75%;"></h4>
        </span>
        <span style="display: grid; gap: 0.5em;">
            <button class="previewBtn btn-highlight">
                <svg class="svg sm-icon" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g fill="currentColor"> <path d="M8 16a8 8 0 0 1-8-8 8 8 0 0 1 8-8 8 8 0 0 1 8 8 8 8 0 0 1-8 8zm0-1a7 7 0 0 0 7-7 7 7 0 0 0-7-7 7 7 0 0 0-7 7 7 7 0 0 0 7 7z"></path> <path d="M8 3.75c-.386 0-.69.124-.914.373A1.269 1.269 0 0 0 6.75 5c0 .336.112.628.336.877.224.249.528.373.914.373s.69-.124.914-.373c.224-.249.336-.541.336-.877 0-.336-.112-.628-.336-.877C8.69 3.874 8.386 3.75 8 3.75zM7 7v5h2V7z" font-family="Ubuntu" font-weight="400" letter-spacing="0" style="line-height:1000%;-inkscape-font-specification:Ubuntu" word-spacing="0"></path> </g> </g></svg>
            </button>
            <button class="editBtn btn-highlight">
                <svg class="sm-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M11 2H9C4 2 2 4 2 9V15C2 20 4 22 9 22H15C20 22 22 20 22 15V13" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M16.04 3.02001L8.16 10.9C7.86 11.2 7.56 11.79 7.5 12.22L7.07 15.23C6.91 16.32 7.68 17.08 8.77 16.93L11.78 16.5C12.2 16.44 12.79 16.14 13.1 15.84L20.98 7.96001C22.34 6.60001 22.98 5.02001 20.98 3.02001C18.98 1.02001 17.4 1.66001 16.04 3.02001Z" stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M14.91 4.1499C15.58 6.5399 17.45 8.4099 19.85 9.0899" stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
            </button>
            <button class="deleteBtn btn-critical">
                <svg class="sm-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M18.7069 7.79289C19.0974 8.18342 19.0974 8.81658 18.7069 9.20711L15.914 12L18.7069 14.7929C19.0974 15.1834 19.0974 15.8166 18.7069 16.2071C18.3163 16.5976 17.6832 16.5976 17.2926 16.2071L14.4998 13.4142L11.7069 16.2071C11.3163 16.5976 10.6832 16.5976 10.2926 16.2071C9.90212 15.8166 9.90212 15.1834 10.2926 14.7929L13.0855 12L10.2926 9.20711C9.90212 8.81658 9.90212 8.18342 10.2926 7.79289C10.6832 7.40237 11.3163 7.40237 11.7069 7.79289L14.4998 10.5858L17.2926 7.79289C17.6832 7.40237 18.3163 7.40237 18.7069 7.79289Z" fill="currentColor"></path> <path fill-rule="evenodd" clip-rule="evenodd" d="M6.30958 3.54424C7.06741 2.56989 8.23263 2 9.46699 2H20.9997C21.8359 2 22.6103 2.37473 23.1614 2.99465C23.709 3.61073 23.9997 4.42358 23.9997 5.25V18.75C23.9997 19.5764 23.709 20.3893 23.1614 21.0054C22.6103 21.6253 21.8359 22 20.9997 22H9.46699C8.23263 22 7.06741 21.4301 6.30958 20.4558L0.687897 13.2279C0.126171 12.5057 0.126169 11.4943 0.687897 10.7721L6.30958 3.54424ZM9.46699 4C8.84981 4 8.2672 4.28495 7.88829 4.77212L2.2666 12L7.88829 19.2279C8.2672 19.7151 8.84981 20 9.46699 20H20.9997C21.2244 20 21.4674 19.9006 21.6665 19.6766C21.8691 19.4488 21.9997 19.1171 21.9997 18.75V5.25C21.9997 4.88294 21.8691 4.5512 21.6665 4.32337C21.4674 4.09938 21.2244 4 20.9997 4H9.46699Z" fill="currentColor"></path> </g></svg>
            </button>
        </span>
    </li>
</template>
<?php require __DIR__ . "/../partials/footer.php"; ?>