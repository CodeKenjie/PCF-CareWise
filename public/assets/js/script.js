let id = null;
let order = 'id';
let direction = 'ASC';

function view(id, type){
    const img = document.getElementById(id);
    const input = document.getElementById(type);
    
    if (img.src.match(`assets/images/hide.svg`)) {
        input.type = "text"; 
        input.style.paddingRight = "4em"; 
        img.src = "assets/images/view.svg";
    } else {
        input.type = "password";
        img.src = "assets/images/hide.svg";
    }
}

function responseMessage(res, message){
    const response = document.getElementById(`responseContainer`);
    const div = document.createElement(`div`);
    div.style.background = res.ok === true ? 'var(--good)' : 'var(--critical)';
    div.id = Date.now();
    const p = document.createElement(`p`);
    p.textContent = message;
    const span = document.createElement(`span`);
    span.setAttribute("role", "button");
    span.tabIndex = "0";
    span.addEventListener("click", () => div.remove());
            
    div.append(p, span);
    response.appendChild(div);

    setTimeout(() => { div.remove() }, 5000);
}

function closePopup(){
    const activePopup = document.querySelector(`.active`);
    if(activePopup){ 
        activePopup.classList.remove(`active`) 
    }
}

function renderPatientsData(data){
    const container = document.getElementById(`collection`);
    const template = document.getElementById(`patientsCard`);

    container.innerHTML = ``;

    data.collection.forEach( patient => {
        const clone = template.content.cloneNode(true);

        clone.querySelector(`.id`).textContent = patient.id;
        clone.querySelector(`.name`).textContent = patient.last_name + ", " + patient.first_name;
        clone.querySelector(`.address`).textContent = patient.address;
        clone.querySelector(`.birthdate`).textContent = patient.birthdate;
        clone.querySelector(`.age`).textContent = patient.age;
        clone.querySelector(`.sex`).textContent = patient.sex;
        clone.querySelector(`.contact`).textContent = patient.contact + " " + patient.extra_contact;
        clone.querySelector(`.referredBy`).textContent = patient.referred_by;
        clone.querySelector(`.patientPreviewBtn`).addEventListener(`click`, () => {
            document.getElementById(`patientPreview`).classList.add(`active`);
            document.getElementById(`pId`).textContent = patient.id;
            document.getElementById(`pName`).textContent = `${patient.last_name}, ${patient.first_name}`;
            document.getElementById(`pAge`).textContent = patient.age;
            document.getElementById(`pSex`).textContent = patient.sex;
            document.getElementById(`pBirthdate`).textContent = patient.birthdate;
            document.getElementById(`pAddress`).textContent = patient.address;
            document.getElementById(`pContacts`).textContent = patient.contact + " " + patient.extra_contact;
            document.getElementById(`pReferredBy`).textContent = patient.referred_by;
        });
        
        clone.querySelector(`.editPatientBtn`).addEventListener(`click`, () => {
            id = patient.id;
            document.getElementById(`editPatientForm`).action = `/patients/edit/${patient.id}`;
            document.getElementById(`editPatient`).classList.add(`active`);

            document.getElementById(`updateFirstName`).value = patient.first_name;
            document.getElementById(`updateLastName`).value = patient.last_name;
            document.querySelector(`.updateSex`).value = patient.sex;
            document.getElementById(`updateBirthdate`).value = patient.birthdate;
            document.getElementById(`updateAddress`).value = patient.address;
            document.getElementById(`updateContact`).value = patient.contact;
            document.getElementById(`updateExContact`).value = patient.extra_contact;
            document.getElementById(`updateReferredBy`).value = patient.referred_by;
        });

        clone.querySelector(`.deletePatientBtn`).addEventListener(`click`, () => {
            id = patient.id;
            document.getElementById(`deletePatientForm`).action = `/patients/delete/${patient.id}`;
            document.getElementById(`name`).textContent = patient.last_name + ", " + patient.first_name;
            document.getElementById(`id`).textContent = patient.id;
            document.getElementById(`deletePatient`).classList.add(`active`);
        });

        container.appendChild(clone);
    });
}

function renderItemData(data){
    const container = document.getElementById(`collection`);
    const template = document.getElementById(`itemCard`);

    container.innerHTML = ``;
    data.collection.forEach(item => {
        const clone = template.content.cloneNode(true);
        const stockStatus = clone.querySelector(`.stockStatus`);
        const exprStatus = clone.querySelector(`.exprStatus`);

        clone.querySelector(`.name`).textContent = item.item_name;
        clone.querySelector(`.category`).textContent = item.category;
        clone.querySelector(`.stockStatus`).textContent = item.stock_status;
        if (item.stock_status === "High Stocks"){
            stockStatus.classList.add(`good`);
        } else if (item.stock_status === "Medium Stocks") {
            stockStatus.classList.add(`moderate`);
        } else {
            stockStatus.classList.add(`critical`);
        }

        clone.querySelector(`.exprStatus`).textContent = item.expiration_status;
        if (item.expiration_status === "Good"){
            exprStatus.classList.add(`good`);
        } else if (item.expiration_status === "Expring Soon") {
            exprStatus.classList.add(`moderate`);
        } else {
            exprStatus.classList.add(`critical`);
        }
        clone.querySelector(`.adjustBtn`).addEventListener(`click`, () => {
            id = item.id;
            document.getElementById(`adjust`).classList.add(`active`);
            document.getElementById(`imCurrentQuant`).textContent = item.quantity;
            document.getElementById(`imName`).textContent = item.item_name;
        });

        clone.querySelector(`.previewItemBtn`).addEventListener(`click`, () => {
            document.getElementById(`itemPreview`).classList.add(`active`);
            document.getElementById(`iId`).textContent = item.id;
            document.getElementById(`iName`).textContent = item.item_name;
            document.getElementById(`iCategory`).textContent = item.category;
            document.getElementById(`iDescription`).textContent = item.description;
            document.getElementById(`iQuantity`).textContent = item.quantity;
            document.getElementById(`iMinQuant`).textContent = item.minimum_quantity;
            document.getElementById(`iQuantStatus`).textContent = item.stock_status;
            document.getElementById(`iExpiration`).textContent = item.expiration_date;
            document.getElementById(`iExpirationStatus`).textContent = item.expiration_status;
            document.getElementById(`iIsDonated`).textContent = item.is_donated;
        });

        clone.querySelector(`.editItemBtn`).addEventListener(`click`, () => {
            id = item.id;
            document.getElementById(`editItemForm`).action = `/inventory/edit/${item.id}`;
            document.getElementById(`editItem`).classList.add(`active`);
            document.getElementById(`updateItemName`).value = item.item_name;
            document.getElementById(`updateCategory`).value = item.category;
            document.getElementById(`updateMinQuant`).value = item.minimum_quantity;
            document.getElementById(`updateDescription`).value = item.description;
            document.getElementById(`updateExpiration`).value = item.expiration_date;
        });
        clone.querySelector(`.deleteItemBtn`).addEventListener(`click`, () => {
            id = item.id;
            document.getElementById(`deleteItem`).classList.add(`active`);
            document.getElementById(`deleteItemForm`).action = `/inventory/delete/${item.id}`
            document.getElementById(`name`).textContent = item.item_name;
            document.getElementById(`id`).textContent = item.id;
        });

        container.appendChild(clone);
    });

}

async function loadList(page, render) {
    try {
        const res = await fetch(`/${page}/all`, {
            method: "GET"
        });

        const data = await res.json();
        if (!data.ok) {
            responseMessage(data, data.error);
            return;
        }
        
        return render(data);
    } catch (err) {
        console.error(err);
    } 
}

async function sortPatients() {
    try {
        const res = await fetch(`/patients/sort?order=${order}&direction=${direction}`, {
            method: "GET"
        });

        const data = await res.json();
        if (!data.ok) {
            responseMessage(data, data.error);
            return;
        }
        
        responseMessage(data, data.message);
        renderPatientsData(data);
    } catch (err) {
        console.error(err);
    } 
}

async function sortInventory() {
    try{
        const res = await fetch(`/inventory/sort?order=${order}&direction=${direction}`, {
            method: 'GET'
        });

        const data = await res.json();
        if(!data.ok){
            responseMessage(data, data.error);
            return;
        }

        responseMessage(data, data.message);
        renderItemData(data);
    } catch (err){
        console.error(err);
    }
}

function sorts(sort){
    const sortDirection = document.getElementById(`direction`);
    const sort1 = document.getElementById(`sort1`);
    const sort2 = document.getElementById(`sort2`);
    const sort3 = document.getElementById(`sort3`);

    sortDirection.addEventListener(`click`, (e) => {
        e.preventDefault();
        direction = direction === 'DESC' ? 'ASC' : 'DESC';
        sortDirection.textContent = direction;
        return sort();
    });
    
    sort1.addEventListener(`click`, (e) => {
        e.preventDefault();
        order = sort1.value;
        sort1.classList.add(`activeSort`);
        sort2.classList.remove(`activeSort`);
        sort3.classList.remove(`activeSort`);
        return sort();
    });

    sort2.addEventListener(`click`, (e) => {
        e.preventDefault();
        order = sort2.value;
        sort1.classList.remove(`activeSort`);
        sort2.classList.add(`activeSort`);
        sort3.classList.remove(`activeSort`);
        return sort();
    });

    sort3.addEventListener(`click`, (e) => {
        e.preventDefault();
        order = sort3.value;
        sort1.classList.remove(`activeSort`);
        sort2.classList.remove(`activeSort`);
        sort3.classList.add(`activeSort`);
        return sort();
    });
}

async function adjustQuantity(value, type){
    try{
        const res = await fetch(`/inventory/adjust/${id}`, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ id: id, value: value, type: type })
        });

        const data = await res.json();
        if(!data.ok){
            responseMessage(data, data.error);
            return;
        }

        responseMessage(data, data.message);
        document.getElementById(`valueInput`).value = "";
        loadList('inventory', renderItemData);
    } catch(err) {
        console.error(err);
    }
}

document.addEventListener(`DOMContentLoaded`, function(e) {
    e.preventDefault();

    document.addEventListener('keydown', (event) => {
        if (event.key === "Escape"){
            closePopup();
        }
    })

    const sidebar = document.querySelector(`#sidebar`);
    if(sidebar){
        const hamMenu = document.getElementById(`ham-menu`);
        hamMenu.addEventListener(`click`, () => {
            sidebar.classList.toggle(`close`);
        });

        const profilePop = document.querySelector(`.additional`);
        const profile = document.getElementById(`profile`);
        profile.addEventListener(`click`, () => {
            profilePop.classList.toggle(`active`);
        });

        const currentPage = document.querySelectorAll(`#sidebar ul a`);
        currentPage.forEach(page => {
            if(page.href === window.location.href) {
                page.classList.add(`currentPage`);
            }
        });
    }

    const register = document.getElementById(`register`);
    if (register) {
        const strength = document.getElementById(`strength`);
        strength.classList.add(`hidden`);
        
        const displayName = document.getElementById(`displayName`);
        displayName.addEventListener("input", () => {
            if(displayName.value.length >= 6 || displayName.value === "") {
                displayName.style.borderColor = "var(--border-color)";
            }
        });

        const email = document.getElementById(`email`);
        email.addEventListener("input", () => {
            if(/^(?=.*[@])/.test(email.value)) {
                email.style.borderColor = "var(--border-color)";
            }
        });

        const pass = document.getElementById(`password`);
        const confPass = document.getElementById(`confPass`);
        pass.addEventListener('input', function(e) {
            const value = pass.value;
            const hasUpper = /[A-Z]/.test(value);
            const hasDigit = /\d/.test(value);
            const hasSpecial = /[!@#$%^&*]/.test(value);
            const longEnough = value.length >= 6;

            if (value === "" || value.length === 0) {
                strength.classList.add(`hidden`);
                pass.style.borderColor = "var(--border-color)";
                confPass.style.borderColor = "var(--border-color)";
                return;
            }

            if (longEnough && hasUpper && hasDigit && hasSpecial) {
                strength.classList.remove('hidden');
                strength.textContent = "STRONG (please take note of your password to avoid forgetting)";
                strength.style.color = "var(--good)";
                pass.style.borderColor = "var(--good)";
            } else if (longEnough && (hasDigit || hasUpper || hasSpecial)){
                strength.classList.remove('hidden');
                strength.textContent = "Medium (to further enhance protection must have number, uppercase, and special character)";
                strength.style.color = "var(--moderate)";
                pass.style.borderColor = "var(--moderate)";
            } else if(value.length > 0) {
                strength.classList.remove('hidden');
                strength.textContent = "weak (should have number, uppercase letter, or special character)";
                strength.style.color = "var(--critical)";
                pass.style.borderColor = "var(--critical)";
            }
        });

        register.addEventListener('submit', async (e) => {
            e.preventDefault();

            try {
                const formdata = new FormData(e.target);
                const res = await fetch(`/register`, {
                    method: "POST",
                    body: formdata
                });

                const data = await res.json();
                console.log(data);

                if (!data.ok) {
                    responseMessage(data, data.error);
                    return;
                }

                if (data.code === 401) {
                    displayName.classList.add(`critical`);
                } 

                if(confPass.value !== pass.value) {
                    confPass.classList.add(`critical`);
                    pass.classList.add(`critical`);
                }

                if (data.code === 400) {
                    email.classList.add(`critical`);
                }

                responseMessage(data, data.message);
                window.location = "/login";
            } catch(err){
                console.error(err);    
            }
        });
    } 

    const login = document.getElementById(`login`);
    if (login) {
        const email = document.getElementById(`email`);
        email.addEventListener("input", () => {
            if(email.value === "") {
                email.style.borderColor = "";
            }
        });

        const password = document.getElementById(`password`);
        password.addEventListener("input", () => {
            if(password.value === "") {
                password.style.borderColor = "";
            }
        });
        
        login.addEventListener("submit", async (e) => {
            e.preventDefault();

            try {
                const formdata = new FormData(e.target);
                const res = await fetch("/login", {
                    method: "POST",
                    body: formdata
                });

                const data = await res.json();
                
                if(!data.ok){
                    responseMessage(data, data.error);
                }

                if(data.code === 400 || data.code === 404 ) {
                    email.style.borderColor = "var(--critical)";
                    return;
                }

                if(data.code === 401){
                    email.style.borderColor = "";
                    password.style.borderColor = "var(--critical)";
                    return;
                }

                responseMessage(data, data.message);
                window.location = '/dashboard';
            } catch(err) {
                console.error(err);
            }
        });
    }

    const patients = document.getElementById(`patients`);
    if(patients){
        loadList('patients', renderPatientsData);
        sorts(sortPatients);
        const firstName = document.getElementById(`firstName`);
        const lastName = document.getElementById(`lastName`);
        const birthdate = document.getElementById(`birthdate`);
        const address = document.getElementById(`address`);
        const sex = document.getElementById(`sex`);
        const contact = document.getElementById(`contact`);
        const exContact = document.getElementById(`exContact`);
        const referredBy = document.getElementById(`referredBy`);

        const registerPatientBtn = document.getElementById(`registerPatientBtn`);
        registerPatientBtn.addEventListener(`click`, () => {
            const registerPatient = document.querySelector(`#registerPatient`);
            registerPatient.classList.add('active');
        }); 

        const editPanel = document.getElementById(`editPatient`);
        const editPatientForm = document.getElementById(`editPatientForm`);
        editPatientForm.addEventListener(`submit`, async (e) => {
            e.preventDefault();
            const updateFirstName = document.getElementById(`updateFirstName`).value;
            const updateLastName = document.getElementById(`updateLastName`).value;
            const updateSex = document.getElementById(`updateSex`).value;
            const updateBirthdate = document.getElementById(`updateBirthdate`).value;
            const updateAddress = document.getElementById(`updateAddress`).value;
            const updateContact = document.getElementById(`updateContact`).value;
            const updateExContact = document.getElementById(`updateExContact`).value;
            const updateReferredBy = document.getElementById(`updateReferredBy`).value;
            const formdata = new FormData(e.target);
            try {
                const res = await fetch(`/patients/edit/${id}`, {
                    method:'PUT',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ id: id, firstName: updateFirstName, lastName: updateLastName, birthdate: updateBirthdate, address: updateAddress, sex: updateSex, contact: updateContact, exContact: updateExContact, referredBy: updateReferredBy })
                });

                const data = await res.json();
                if(!data.ok){
                    responseMessage(data, data.error);
                    return;
                }

                responseMessage(data, data.message);
                editPanel.classList.remove('active');
                loadList('patients', renderPatientsData);
            } catch (err) {
                console.error(err);
            }
        });

        const registerPatientForm = document.getElementById(`registerPatientForm`);
        registerPatientForm.addEventListener(`submit`, async (e) => {
            e.preventDefault();
            const formdata = new FormData(e.target);
            try {
                const res = await fetch('/patients/register', {
                    method:'POST',
                    body: formdata
                });

                const data = await res.json();
                if(!data.ok){
                    responseMessage(data, data.error);
                }

                responseMessage(data, data.message);
                registerPatient.classList.remove('active');
                firstName.value = '';
                lastName.value = '';
                birthdate.value = '';
                sex.value = '';
                address.value = '';
                contact.value = '';
                exContact.value = '';
                referredBy.value = '';
                loadList('patients', renderPatientsData);
            } catch (err) {
                console.error(err);
            }
        });

        document.getElementById(`deletePatientForm`).addEventListener(`submit`, async (e) => {
            e.preventDefault();
            try {
                const res = await fetch(`/patients/delete/${id}`, {
                    method: 'DELETE'
                });

                const data = await res.json();

                if(!data.ok){
                    responseMessage(data, data.error);
                }

                responseMessage(data, data.message);
                document.getElementById(`deletePatient`).classList.remove(`active`);
                loadList('patients', renderPatientsData);
            } catch (err) {
                console.error(err)
            }
        });

        document.getElementById(`searchForm`).addEventListener('submit', async (e) => {
            e.preventDefault();
            const keyword = document.getElementById(`search`).value;
            try{
                const res = await fetch(`/patients/patient?search=${keyword}`, {
                    method: "GET"
                });

                const data = await res.json();
                renderPatientsData(data);
            } catch(err) {
                console.error(err);
            }
        })

        document.getElementById(`search`).addEventListener(`input`, (e) => {
            const search = document.getElementById(`search`).value;
            e.preventDefault();
            if(search === "") {
                loadList('patients', renderPatientsData);
            }
        });
    }

    const inventory = document.getElementById(`inventory`);
    if (inventory){
        loadList('inventory', renderItemData);
        sorts(sortInventory);
        const itemName = document.getElementById(`itemName`); 
        const category = document.getElementById(`category`); 
        const quantity = document.getElementById(`quantity`); 
        const minQuant = document.getElementById(`minQuant`); 
        const descrition = document.getElementById(`description`); 
        const expiration = document.getElementById(`expiration`); 
        const isDonated = document.getElementById(`isDonated`); 

        const addItem = document.getElementById(`addItem`);
        const addItemBtn = document.getElementById(`addItemBtn`);
        addItemBtn.addEventListener(`click`, () => {
            addItem.classList.add(`active`);
        });

        const addItemForm = document.getElementById(`addItemForm`);
        addItemForm.addEventListener(`submit`, async (e) => {
            e.preventDefault();
            try {
                const formdata = new FormData(e.target);  
                const res = await fetch(`/inventory/add`, {
                    method: 'POST',
                    body: formdata
                });

                const data = await res.json();

                if(!data.ok){
                    responseMessage(data, data.error);
                    return;
                }

                responseMessage(data, data.message);
                loadList('inventory', renderItemData);
                addItem.classList.remove(`active`);
                itemName.value = "";
                category.value = "";
                quantity.value = "";
                minQuant.value = "";
                descrition.value = "";
                expiration.value = "";
                isDonated.value = "";
            } catch (err) {
                console.error(err);
            }
        });

        const deleteItemForm = document.getElementById(`deleteItemForm`);
        deleteItemForm.addEventListener(`submit`, async (e) => {
            e.preventDefault();
            try {
                const res = await fetch(`/inventory/delete/${id}`, {
                    method: 'DELETE'
                });

                const data = await res.json();
                if(!data.ok){
                    responseMessage(data, data.error);
                    return;
                }

                responseMessage(data, data.message);
                document.getElementById(`deleteItem`).classList.remove(`active`);
                loadList('inventory', renderItemData);
            } catch (err){
                console.error(err);
            }
        });

        const editItem = document.getElementById(`editItem`);
        const editItemForm = document.getElementById(`editItemForm`);
        editItemForm.addEventListener(`submit`, async (e) => {
            e.preventDefault();
            const updateItemName = document.getElementById(`updateItemName`).value; 
            const updateCategory = document.getElementById(`updateCategory`).value; 
            const updateMinQuant = document.getElementById(`updateMinQuant`).value; 
            const updateDescription = document.getElementById(`updateDescription`).value; 
            const updateExpiration = document.getElementById(`updateExpiration`).value; 
            try {
                const res = await fetch(`/inventory/edit/${id}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ id: id, itemName: updateItemName, category:updateCategory, minQuant: updateMinQuant, description: updateDescription, expiration: updateExpiration })
                });

                const data = await res.json();

                if(!data.ok){
                    responseMessage(data, data.error);
                    return;
                }

                responseMessage(data, data.message);
                loadList('inventory', renderItemData);
                editItem.classList.remove(`active`);
            } catch (err) {
                console.error(err);
            }
        });

        document.getElementById(`searchForm`).addEventListener('submit', async (e) => {
            e.preventDefault();
            const keyword = document.getElementById(`search`).value;
            try{
                const res = await fetch(`/inventory/item?search=${keyword}`, {
                    method: "GET"
                });

                const data = await res.json();
                renderItemData(data);
            } catch(err) {
                console.error(err);
            }
        })

        document.getElementById(`search`).addEventListener(`input`, (e) => {
            const search = document.getElementById(`search`).value;
            e.preventDefault();
            if(search === "") {
                loadList('inventory', renderItemData);
            }
        });

        document.getElementById(`exportBtn`).addEventListener(`click`, (e)=> {
            e.preventDefault();
            const valueInput = document.getElementById(`valueInput`).value;
            adjustQuantity(Number(valueInput), 'export');
        });

        document.getElementById(`importBtn`).addEventListener(`click`, (e) => {
            e.preventDefault();
            const valueInput = document.getElementById(`valueInput`).value;
            adjustQuantity(Number(valueInput), 'import');
        });

    }

    const schedule = document.getElementById(`schedule`);
    if(schedule){
        const date = document.getElementById(`date`);
        const daysContainer = document.getElementById(`days`);
        let today = new Date();
        let month = today.getMonth();
        let year = today.getFullYear();
        const months = [ `January`, `February`, `March`, `April`, `May`, `June`, `July`, `August`, `September`, `Octover`, `November`, `December` ];

        function initCalendar(){ 
            const firstDay = new Date(year, month, 1).getDay();
            const lastDate = new Date(year, month + 1, 0).getDate();
            const prevLastDate = new Date(year, month, 0).getDate();
            const lastDay = new Date(year, month + 1, 0).getDay();
            const totalCells = firstDay + lastDate + (6 - lastDay);

            date.textContent = months[month] + ` ` + year; 
            daysContainer.innerHTML = "";

            for(let i = 0; i < totalCells; i++){
                const daySpan = document.createElement(`span`);
                const currentDate = i - firstDay + 1;

                if(i < firstDay) {
                    daySpan.textContent = prevLastDate - firstDay + i + 1;
                    daySpan.classList.add(`prev-days`);
                } else if (i < firstDay + lastDate) {
                    daySpan.textContent = currentDate;
                    if(currentDate === new Date().getDate() && year === new Date().getFullYear() && month === new Date().getMonth()){
                        daySpan.classList.add(`current`);
                    }
                } else {
                    daySpan.textContent = i - (firstDay + lastDate) + 1;
                    daySpan.classList.add(`next-days`);
                }

                daySpan.addEventListener(`click`, () => {
                    console.log(`${months[month]} ${currentDate}, ${year}`);
                });
                daysContainer.append(daySpan);
            }
        }

        initCalendar();

        document.getElementById(`prev`).addEventListener(`click`, () => {
            month--;
            if(month < 0){
                month = 11;
                year--;
            }
            initCalendar();
        });

        document.getElementById(`next`).addEventListener(`click`, () => {
            month++;
            if(month > 11){
                month = 0;
                year++;
            }
            initCalendar();
        });

        document.getElementById(`todayBtn`).addEventListener(`click`, () => {
            today = new Date();
            month = today.getMonth();
            year = today.getFullYear();
            initCalendar();
        });

        document.getElementById(`dateInput`).addEventListener(`input`, (e)=> {
            const input = document.getElementById(`dateInput`);
            input.value = input.value.replace(/[^0-9/]/g, "");

            if(input.value.length === 2){
                input.value += "/";
            }

            if(e.inputType === "deleteContentBackward") {
                if(input.value.length === 3){
                    input.value = input.value.slice(0, 2);
                }
            }
        });
        
        document.getElementById(`dateGotoBtn`).addEventListener(`click`, () => {
            const input = document.getElementById(`dateInput`);
            const date = input.value.split(`/`)
            if(date.length === 2){
                if(date[0] > 0 && date[0] < 13 && date[1].length === 4){
                    month = date[0] - 1;
                    year = date[1];
                    initCalendar();
                    return;
                }
                responseMessage(false, `Please enter a proper date`);
            }
        });
    }
})