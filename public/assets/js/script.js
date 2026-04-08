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

        clone.querySelector(`.name`).textContent = item.item_name;
        clone.querySelector(`.category`).textContent = item.category;
        clone.querySelector(`.quantity`).textContent = item.quantity;
        clone.querySelector(`.previewItemBtn`).addEventListener(`click`, () => {
            document.getElementById(`itemPreview`).classList.add(`active`);
            document.getElementById(`iId`).textContent = item.id;
            document.getElementById(`iName`).textContent = item.item_name;
            document.getElementById(`iCategory`).textContent = item.category;
            document.getElementById(`iDescription`).textContent = item.description;
            document.getElementById(`iQuantity`).textContent = item.quantity;
            document.getElementById(`iMinQuant`).textContent = item.minimum_quantity;
            document.getElementById(`iExpiration`).textContent = item.expiration_date;
            document.getElementById(`iIsDonated`).textContent = item.is_donated;
        });

        clone.querySelector(`.editItemBtn`).addEventListener(`click`, () => {
            id = item.id;
            document.getElementById(`editItemForm`).action = `/inventory/edit/${item.id}`;
            document.getElementById(`editItem`).classList.add(`active`);
            document.getElementById(`updateItemName`).value = item.item_name;
            document.getElementById(`updateCategory`).value = item.category;
            document.getElementById(`updateQuantity`).value = item.quantity;
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

async function loadPatientsList() {
    try {
        const res = await fetch(`/patients/all`, {
            method: "GET"
        });

        const data = await res.json();
        if (!data.ok) {
            responseMessage(data, data.error);
            return;
        }
        
        renderPatientsData(data);
    } catch (err) {
        console.error(err);
    } 
}

async function loadItemsList(){
    try {
        const res = await fetch(`/inventory/all`, {
            method: "GET"
        });

        const data = await res.json();

        if(!data.ok){
            responseMessage(data, data.error);
            return;
        }

        renderItemData(data);
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
        sort1.classList.add(`activeSort`);
        sort2.classList.remove(`activeSort`);
        sort3.classList.remove(`activeSort`);
        return sort();
    });

    sort2.addEventListener(`click`, (e) => {
        e.preventDefault();
        sort1.classList.remove(`activeSort`);
        sort2.classList.add(`activeSort`);
        sort3.classList.remove(`activeSort`);
        return sort();
    });

    sort3.addEventListener(`click`, (e) => {
        e.preventDefault();
        sort1.classList.remove(`activeSort`);
        sort2.classList.remove(`activeSort`);
        sort3.classList.add(`activeSort`);
        return sort();
    });
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
        loadPatientsList();
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

        const cancelPatientRegistration = document.getElementById(`cancelPatientRegistration`);
        cancelPatientRegistration.addEventListener(`click`, () => {
            registerPatient.classList.remove('active');
        });

        const closeDelete = document.getElementById(`closeDelete`);
        closeDelete.addEventListener(`click`, () => {
            document.getElementById(`deletePatient`).classList.remove(`active`);
        });

        const editPanel = document.getElementById(`editPatient`);
        const cancelPatientEdit = document.getElementById(`cancelPatientEdit`);
        cancelPatientEdit.addEventListener(`click`, () => {
            editPanel.classList.remove('active');
        });

        const editPatientForm = document.getElementById(`editPatientForm`);
        editPatientForm.addEventListener(`submit`, async (e) => {
            e.preventDefault();
            const formdata = new FormData(e.target);
            try {
                const res = await fetch(`/patients/edit/${selectedPatientId}`, {
                    method:'POST',
                    body: formdata
                });

                const data = await res.json();
                if(!data.ok){
                    responseMessage(data, data.error);
                }

                responseMessage(data, data.message);
                editPanel.classList.remove('active');
                loadPatientsList();
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
                loadPatientsList();
            } catch (err) {
                console.error(err);
            }
        });

        const closePreview = document.querySelector(`.btn-close`);
        closePreview.addEventListener(`click`, () => {
            document.getElementById(`patientPreview`).classList.remove(`active`);
        });

        document.getElementById(`deletePatientForm`).addEventListener(`submit`, async (e) => {
            e.preventDefault();
            try {
                const res = await fetch(`/patients/delete/${selectedPatientId}`, {
                    method: 'POST'
                });

                const data = await res.json();

                if(!data.ok){
                    responseMessage(data, data.error);
                }

                responseMessage(data, data.message);
                document.getElementById(`deletePatient`).classList.remove(`active`);
                loadPatientsList();
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
                loadPatientsList();
            }
        });
    }

    const inventory = document.getElementById(`inventory`);
    if (inventory){
        loadItemsList();
        sorts();
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
                loadItemsList();
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

        const cancelAddItem = document.getElementById(`cancelAddItem`);
        cancelAddItem.addEventListener(`click`, () => {
            addItem.classList.remove(`active`);
        });

        const deleteItemForm = document.getElementById(`deleteItemForm`);
        deleteItemForm.addEventListener(`submit`, async (e) => {
            e.preventDefault();
            try {
                const res = await fetch(`/inventory/delete/${id}`, {
                    method: 'POST'
                });

                const data = await res.json();
                if(!data.ok){
                    responseMessage(data, data.error);
                    return;
                }

                responseMessage(data, data.message);
                document.getElementById(`deleteItem`).classList.remove(`active`);
                loadItemsList();
            } catch (err){
                console.error(err);
            }
        });

        const closeDelete = document.getElementById(`closeDelete`);
        closeDelete.addEventListener(`click`, () => {
            document.getElementById(`deleteItem`).classList.remove(`active`);
        });

        const editItem = document.getElementById(`editItem`);
        const editItemForm = document.getElementById(`editItemForm`);
        editItemForm.addEventListener(`submit`, async (e) => {
            e.preventDefault();
            const updateItemName = document.getElementById(`updateItemName`); 
            const updateCategory = document.getElementById(`updateCategory`); 
            const updateQuantity = document.getElementById(`updateQuantity`); 
            const updateMinQuant = document.getElementById(`updateMinQuant`); 
            const updateDescription = document.getElementById(`updateDescription`); 
            const updateExpiration = document.getElementById(`updateExpiration`); 

            try {
                const formdata = new FormData(e.target);  
                const res = await fetch(`/inventory/edit/${id}`, {
                    method: 'POST',
                    body: formdata
                });

                const data = await res.json();

                if(!data.ok){
                    responseMessage(data, data.error);
                    return;
                }

                responseMessage(data, data.message);
                loadItemsList();
                editItem.classList.remove(`active`);
                updateItemName.value = "";
                updateCategory.value = "";
                updateQuantity.value = "";
                updateMinQuant.value = "";
                updateDescription.value = "";
                updateExpiration.value = "";
            } catch (err) {
                console.error(err);
            }
        });

        const cancelEditItem = document.getElementById(`cancelEditItem`);
        cancelEditItem.addEventListener(`click`, () => {
            editItem.classList.remove(`active`);
        });

        const closePreview = document.querySelector(`.btn-close`);
        closePreview.addEventListener(`click`, () => {
            document.getElementById(`itemPreview`).classList.remove(`active`);
        });
    }
})