<?php require __DIR__ . "/../partials/header.php"; ?>
<main id="inventory">
    <section class="actions acrylic-bg">
        <button id="addItemBtn" class="addBtn btn-accent">
            <svg class="icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M9 22H15C20 22 22 20 22 15V9C22 4 20 2 15 2H9C4 2 2 4 2 9V15C2 20 4 22 9 22Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M8.46997 10.6399L12 14.1599L15.53 10.6399" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
            <span>Add Item</span>
        </button>
        <div>
            <form action="/inventory/sort" method="get">
                <span class="sortsSpan">
                    <button id="sort1" class="btn-highlight" type="button" value="name">Name</button>
                    <button id="sort2" class="btn-highlight" type="button" value="quantity">Quantity</button>
                    <button id="sort3" class="btn-highlight" type="button" value="expiration_date">Expiration</button>
                    <button id="direction" class="btn-highlight" type="button" value="ASC">ASC</button>
                </span>
            </form>
            <form id="searchForm" action="/inventory/item" metohd="get">
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
        <div class="part p-sm">
            <button id="importBtn" class="btn-square btn-accent" type="reset" value="import" onclick="closePopup()">Import</button>
            <button id="exportBtn" class="btn-square btn-accent" type="reset" value="export" onclick="closePopup()">Export</button>
        </div>
    </form>
</div>
<div id="addItem" class="popup">
    <form id="addItemForm" class="form-ui" action="/inventory/add" method="post">
        <input id="medicineId" name="medicineId" type="text" required hidden>
        <span class="rel p-sm">
            <input id="itemName" name="itemName" type="text" required>
            <label>Item Name</label>
            <ul id="medicineOptn" class="dropdown"></ul>
        </span>
        <span class="p-sm">
            <input id="category" name="category" type="text" required>
            <label>Category</label>
        </span>
        <div class="p-sm" style="display: flex; gap: 1em;">
            <span>
                <input id="quantity" name="quantity" type="text" required>
                <label>Stocks</label>
            </span>
            <span>
                <input id="quantityType" name="quantityType" type="text" required>
                <label>per</label>
            </span>
            <span>
                <input id="minQuant" name="minQuant" type="text" required>
                <label>Min Stock</label>
            </span>
        </div>
        <span class="p-sm">
            <input id="description" name="description" type="text" required>
            <label>Description</label>
        </span>
        <div class="part p-sm">
            <span>
                <input id="expiration" name="expiration" type="date" required>
                <label>Expiration Date</label>
            </span>
            <span>
                <select id="isDonated" name="isDonated" id="isDonated" required>
                    <option value="" hidden></option>
                    <option value="true">Donated</option>
                    <option value="false">Not Donated</option>
                </select>
                <label>Donated:</label>
            </span>
        </div>
        <div class="part p-sm">
            <button class="btn-accent btn-pill" type="submit">Add</button>
            <button class="btn-highlight btn-pill" type="reset" onclick="closePopup()">Cancel</button>
        </div>
    </form>
</div>
<div id="itemPreview" class="popup">
    <section class="preview">
        <section class="btn-highlight btn-close" onclick="closePopup()"></section>
        <div>
            <span>
                <label for="iId"><strong>I.D:</strong></label>
                <h3 id="iId"></h3>
            </span>
            <span>
                <label for="iName"><strong>Name:</strong></label>
                <h3 id="iName"></h3>
            </span>
            <span>
                <label for="iCategory"><strong>Category:</strong></label>
                <h3 id="iCategory"></h3>
            </span>
        </div>
        <span>
            <label for="iDescription"><strong>Description:</strong></label>
            <h3 id="iDescription"></h3>
        </span>
        <div>
            <span>
                <label for="iQuantity"><strong>Stock:</strong></label>
                <h3 id="iQuantity"></h3>
            </span>
            <span>
                <label for="iMinQuant"><strong>Min:</strong></label>
                <h3 id="iMinQuant"></h3>
            </span>
            <span>
                <label for="iMinQuantStatus"><strong>Stocks Status:</strong></label>
                <h3 id="iQuantStatus"></h3>
            </span>
        </div>
        <div>
            <span>
                <label for="iExpiration"><strong>Expr Date:</strong></label>
                <h3 id="iExpiration"></h3>
            </span>
            <span>
                <label for="iExpirationStatus"><strong>Expr Status:</strong></label>
                <h3 id="iExpirationStatus"></h3>
            </span>
            <span>
                <label for="iIsDonated"><strong>Donated:</strong></label>
                <h3 id="iIsDonated"></h3>
            </span>
        </div>
    </section>
</div>
<div id="editItem" class="popup">
    <form id="editItemForm" class="form-ui" action="/inventory/edit" method="post">
        <span class="p-sm">
            <input id="updateItemName" name="updateItemName" type="text" required>
            <label>Item Name</label>
        </span>
        <div class="part p-sm">
            <span>
                <input id="updateCategory" type="text" required>
                <label>Category</label>
            </span>
            <span>
                <input id="updateExpiration" type="date" required>
                <label>Expiration Date</label>
            </span>
        </div>
        <div class="part p-sm">
            <span>
                <input id="updateMinQuant" type="text" required>
                <label>Minimum Stock</label>
            </span>
            <span>
                <input id="updateQuantityType" type="text" required>
                <label>per</label>
            </span>
        </div>
        <span class="p-sm">
            <input id="updateDescription" type="text" required>
            <label>Description</label>
        </span>
        <div class="part p-sm">
            <button class="btn-accent btn-pill" type="submit">Update</button>
            <button class="btn-highlight btn-pill" type="reset" onclick="closePopup()">Cancel</button>
        </div>
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
<template id="medicineCard">
    <li class="medicine p-sm">
        <h4 class="genericName"></h4>
        <h4 class="dosage"></h4>
        <h4 class="form"></h4>
    </li>
</template>
<template id="itemCard">
    <li>
        <table>
            <tr>
                <td class="rel name"></td>
                <td class="category"></td>
                <td class="stockStatus"></td>
                <td class="exprStatus"></td>
                <td>
                    <button class="adjustBtn btn-accent">
                        <svg class="svg sm-icon" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path fill-rule="evenodd" d="M19.7903934,18.6127185 L19.7072026,18.7069258 L16.7071326,21.7069258 C16.6801187,21.7339397 16.6515664,21.7594153 16.6216183,21.7832098 L16.500353,21.8659223 L16.500353,21.8659223 L16.427064,21.9043128 L16.427064,21.9043128 L16.3400271,21.9405322 L16.3400271,21.9405322 L16.2335653,21.9723902 L16.2335653,21.9723902 L16.116647,21.9930913 L16.033029,21.9992768 L16.033029,21.9992768 L15.9409671,21.9980859 L15.8251966,21.9845213 L15.8251966,21.9845213 L15.6878494,21.9500809 L15.6878494,21.9500809 L15.5767675,21.9061457 L15.5767675,21.9061457 L15.4792778,21.8538236 L15.4792778,21.8538236 L15.3832241,21.7870331 L15.2928749,21.7069258 L12.2927974,18.7069258 C11.902263,18.3164015 11.902263,17.6832365 12.2927974,17.2927122 C12.6532907,16.9322283 13.2205364,16.9044987 13.6128377,17.2095236 L13.7070475,17.2927122 L14.9998966,18.584819 L14.9999741,8.99981902 C14.9999741,8.48698318 15.3860143,8.06431186 15.883353,8.00654675 L16.0000259,7.99981902 C16.5523106,7.99981902 17.0000259,8.44753427 17.0000259,8.99981902 L16.9998966,18.584819 L18.2929525,17.2927122 C18.6534458,16.9322283 19.2206915,16.9044987 19.6129929,17.2095236 L19.7072026,17.2927122 C20.0376548,17.6231559 20.0884936,18.1273245 19.859719,18.511222 L19.7903934,18.6127185 L19.7903934,18.6127185 Z M4.29279737,5.29255711 L7.29286736,2.29255711 L7.40481484,2.1959774 L7.51569719,2.12453966 L7.51569719,2.12453966 L7.62891562,2.07076785 L7.62891562,2.07076785 L7.73413453,2.03538486 L7.73413453,2.03538486 L7.82519664,2.01496161 L7.82519664,2.01496161 L7.94096709,2.00139699 L8.05914398,2.00139699 L8.05914398,2.00139699 L8.17466132,2.0149356 L8.17466132,2.0149356 L8.31274961,2.04953478 L8.31274961,2.04953478 L8.36670687,2.06905084 L8.45385903,2.10832658 L8.45385903,2.10832658 L8.52068604,2.14573132 L8.52068604,2.14573132 L8.60170489,2.20078783 L8.60170489,2.20078783 L8.66547577,2.25320781 L8.66547577,2.25320781 L8.70713264,2.29255711 L11.7072026,5.29255711 L11.7903934,5.38676445 C12.0700068,5.74636472 12.0700068,6.25296306 11.7903934,6.61256333 L11.7072026,6.70677067 L11.6129929,6.78995928 C11.2533833,7.06956543 10.7467718,7.06956543 10.3871623,6.78995928 L10.2929525,6.70677067 L8.99989658,5.41466389 L9.00002585,14.9996639 C9.00002585,15.5124997 8.61398566,15.9351711 8.11664698,15.9929362 L8.00002585,15.9996639 L7.88335302,15.9929362 C7.42427116,15.9396145 7.06002351,15.5753669 7.00670188,15.116285 L6.99997415,14.9996639 L6.99989658,5.41466389 L5.7070475,6.70677067 L5.61283773,6.78995928 C5.22053638,7.09498417 4.65329066,7.06725463 4.29279737,6.70677067 C3.93230409,6.34628671 3.90457384,5.77905565 4.20960662,5.38676445 L4.29279737,5.29255711 Z"></path> </g></svg>
                    </button>
                    <button class="previewItemBtn btn-highlight">
                        <svg class="svg sm-icon" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g fill="currentColor"> <path d="M8 16a8 8 0 0 1-8-8 8 8 0 0 1 8-8 8 8 0 0 1 8 8 8 8 0 0 1-8 8zm0-1a7 7 0 0 0 7-7 7 7 0 0 0-7-7 7 7 0 0 0-7 7 7 7 0 0 0 7 7z"></path> <path d="M8 3.75c-.386 0-.69.124-.914.373A1.269 1.269 0 0 0 6.75 5c0 .336.112.628.336.877.224.249.528.373.914.373s.69-.124.914-.373c.224-.249.336-.541.336-.877 0-.336-.112-.628-.336-.877C8.69 3.874 8.386 3.75 8 3.75zM7 7v5h2V7z" font-family="Ubuntu" font-weight="400" letter-spacing="0" style="line-height:1000%;-inkscape-font-specification:Ubuntu" word-spacing="0"></path> </g> </g></svg>
                    </button>
                    <button class="editItemBtn btn-highlight">
                        <svg class="sm-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M11 2H9C4 2 2 4 2 9V15C2 20 4 22 9 22H15C20 22 22 20 22 15V13" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M16.04 3.02001L8.16 10.9C7.86 11.2 7.56 11.79 7.5 12.22L7.07 15.23C6.91 16.32 7.68 17.08 8.77 16.93L11.78 16.5C12.2 16.44 12.79 16.14 13.1 15.84L20.98 7.96001C22.34 6.60001 22.98 5.02001 20.98 3.02001C18.98 1.02001 17.4 1.66001 16.04 3.02001Z" stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M14.91 4.1499C15.58 6.5399 17.45 8.4099 19.85 9.0899" stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                    </button>
                    <button class="deleteItemBtn btn-critical">
                        <svg class="sm-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M18.7069 7.79289C19.0974 8.18342 19.0974 8.81658 18.7069 9.20711L15.914 12L18.7069 14.7929C19.0974 15.1834 19.0974 15.8166 18.7069 16.2071C18.3163 16.5976 17.6832 16.5976 17.2926 16.2071L14.4998 13.4142L11.7069 16.2071C11.3163 16.5976 10.6832 16.5976 10.2926 16.2071C9.90212 15.8166 9.90212 15.1834 10.2926 14.7929L13.0855 12L10.2926 9.20711C9.90212 8.81658 9.90212 8.18342 10.2926 7.79289C10.6832 7.40237 11.3163 7.40237 11.7069 7.79289L14.4998 10.5858L17.2926 7.79289C17.6832 7.40237 18.3163 7.40237 18.7069 7.79289Z" fill="currentColor"></path> <path fill-rule="evenodd" clip-rule="evenodd" d="M6.30958 3.54424C7.06741 2.56989 8.23263 2 9.46699 2H20.9997C21.8359 2 22.6103 2.37473 23.1614 2.99465C23.709 3.61073 23.9997 4.42358 23.9997 5.25V18.75C23.9997 19.5764 23.709 20.3893 23.1614 21.0054C22.6103 21.6253 21.8359 22 20.9997 22H9.46699C8.23263 22 7.06741 21.4301 6.30958 20.4558L0.687897 13.2279C0.126171 12.5057 0.126169 11.4943 0.687897 10.7721L6.30958 3.54424ZM9.46699 4C8.84981 4 8.2672 4.28495 7.88829 4.77212L2.2666 12L7.88829 19.2279C8.2672 19.7151 8.84981 20 9.46699 20H20.9997C21.2244 20 21.4674 19.9006 21.6665 19.6766C21.8691 19.4488 21.9997 19.1171 21.9997 18.75V5.25C21.9997 4.88294 21.8691 4.5512 21.6665 4.32337C21.4674 4.09938 21.2244 4 20.9997 4H9.46699Z" fill="currentColor"></path> </g></svg>
                    </button>
                </td>
            </tr>
        </table>
    </li>
</template>
<?php require __DIR__ . "/../partials/footer.php"; ?>