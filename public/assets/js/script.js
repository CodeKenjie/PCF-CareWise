let selectedPatientId = null;
let selectedItemId = null;

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

    setTimeout(() => { div.remove() }, 10000);
}

function closePopup(){
    const activePopup = document.querySelector(`.popup.active`);
    if(activePopup){ 
        activePopup.classList.remove(`active`) 
    }
}

function renderPatientsData(data){
    const container = document.getElementById(`patientsCollection`);
    const template = document.getElementById(`patientsTemplate`);
    const confirmPatient = document.getElementById(`confirmPopUp`);
    const editPatientPanel = document.getElementById(`editPatientPanel`);

    container.innerHTML = "";

    data.collection.forEach( patient => {
        const clone = template.content.cloneNode(true);

        clone.querySelector(`.pId`).textContent = patient.id;
        clone.querySelector(`.pName`).textContent = patient.last_name + ", " + patient.first_name;
        clone.querySelector(`.pAddress`).textContent = patient.address;
        clone.querySelector(`.pBirthdate`).textContent = patient.birthdate;
        clone.querySelector(`.pAge`).textContent = patient.age ?? '';
        clone.querySelector(`.pSex`).textContent = patient.sex;
        clone.querySelector(`.pContact`).textContent = patient.contact;
        clone.querySelector(`.pReferredBy`).textContent = patient.referred_by;

        const deletePatient = clone.querySelector(`.deletePatient`);
        deletePatient.addEventListener("click", ()=> {
            selectedPatientId = patient.id;
            confirmPatient.classList.add(`active`);
        });

        const editPatient = clone.querySelector(`.editPatient`);
        editPatient.addEventListener("click", () => {
            document.getElementById(`editTitle`).textContent = "Update " + patient.last_name +"'s " + " Details";
            document.getElementById(`updateFirstName`).value = patient.first_name;
            document.getElementById(`updateLastName`).value = patient.last_name;
            document.getElementById(`updateAddress`).value = patient.address;
            document.getElementById(`updateBirth`).value = patient.birthdate;
            document.getElementById(`updateSex`).value = patient.sex;
            document.getElementById(`updateContact`).value = patient.contact;
            selectedPatientId = patient.id;
            editPatientPanel.classList.add(`active`);
        });
        
        container.appendChild(clone);
    });
}

function renderPatientsForCare(data){
    const container = document.getElementById(`patientsCollection`); 
    const template = document.getElementById(`patientsTemplate`);
    const preview = document.querySelector(`.popup`);

    container.innerHTML = "";

    data.collection.forEach(patient => {
        const clone = template.content.cloneNode(true);
        clone.querySelector(`.patientName`).textContent = patient.last_name + ", " + patient.first_name;
        clone.querySelector(`.patientAge`).textContent = patient.age;
        const selectedPatient = clone.querySelector(`.selectedPatient`);
        selectedPatient.addEventListener("click", () => {
            selectedPatientId = patient.id;
            preview.classList.add(`active`);
            document.getElementById(`pvwPatientId`).textContent = patient.id;
            document.getElementById(`pvwPatientName`).textContent = patient.last_name + ", " + patient.first_name;
            document.getElementById(`pvwPatientAge`).textContent = patient.age;
            document.getElementById(`pvwPatientBirthdate`).textContent = patient.birthdate;
        });

        container.appendChild(clone);
    });

}

function renderInventoryItem(data){
    const container = document.getElementById(`itemCollection`);
    const donationContainer = document.getElementById(`donatedCollection`);
    const template = document.getElementById(`itemTemplate`);

    container.innerHTML = "";

    data.collection.forEach(item => {
        const clone = template.content.cloneNode(true);

        const li = clone.querySelector(`li`);
        li.addEventListener("click", () => {
            selectedItemId = item.id;    
        });
        clone.querySelector(`.itemName`).textContent = item.item_name;
        clone.querySelector(`.category`).textContent = item.category;
        clone.querySelector(`.quantity`).textContent = item.quantity;
        clone.querySelector(`.minQuant`).textContent = item.minimum_quantity;
        const itemStatus = clone.querySelector(`.itemStatus`);
        itemStatus.textContent = item.quantity_status;

        if (item.quantity_status === "Critical") {
            itemStatus.classList.add(`statusCritical`);
        } else if (item.quantity_status === "Moderate") {
            itemStatus.classList.add(`statusModerate`);
        } else {
            itemStatus.classList.add(`statusGood`);
        }

        clone.querySelector(`.expirationDate`).textContent = item.expiration_date;
        const expirationStatus = clone.querySelector(`.expirationStatus`);
        expirationStatus.textContent = item.expiration_status;

        if(item.expiration_status === "Expired") {
            expirationStatus.classList.add(`statusCritical`);
        } else if (item.expiration_status === "Expiring Soon") {
            expirationStatus.classList.add(`statusModerate`);
        } else {
            expirationStatus.classList.add(`statusGood`);
        }
        
        container.appendChild(clone)
    });
}

async function loadPatientsData() {
    const patients = document.getElementById(`patientsInfo`);
    const care = document.getElementById(`patientsCare`);
    try {
        const res = await fetch(`api/get_patients.php`);

        const data = await res.json();
        if (!data.ok) {
            responseMessage(data, data.error);
            return;
        }
        
        if(patients){
            renderPatientsData(data);
        }

        if (care) {
            renderPatientsForCare(data);
        }
    } catch (err) {
        console.error(err);
    } 
}

async function sortPatient(sort = `id`, direction = 'ASC') {
    try {
        const res = await fetch(`api/get_patients.php`, {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({ sort: sort, direction: direction })
        });
        
        const data = await res.json();
        if (!data.ok){
            responseMessage(data, data.error);
            return;
        }

        renderPatientsData(data);
    } catch (err) {
        console.log(err);
    }
    
}

async function loadInventoryItem() {
    try {
        const res = await fetch(`api/get_items.php`);
        const data = await res.json();
        if (!data.ok) {
            responseMessage(data, data.error);
            return;
        }
    
        renderInventoryItem(data);
    } catch (err) {
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
    const hamMenu = document.getElementById(`ham-menu`);
    hamMenu.addEventListener(`click`, () => {
        sidebar.classList.toggle(`close`);
    });

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

                if (data.code === 409) {
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

    const patientsInfo = document.getElementById(`patientsInfo`);
    if(patientsInfo){
        loadPatientsData();

        const addPatient = document.getElementById(`addPatient`);
        addPatient.addEventListener(`click`, () => {
            registerPatient.classList.add(`active`);
        });      

        const registerPatient = document.getElementById(`registerPatient`);
        if (registerPatient) {
            const pFirstName = document.getElementById(`pFirstName`);
            const pLastName = document.getElementById(`pLastName`);
            const pAddress = document.getElementById(`pAddress`);
            const pBirth = document.getElementById(`pBirth`);
            const pSex = document.getElementById(`pSex`);
            const pContact = document.getElementById(`pContact`);
            const pReferredBy = document.getElementById(`pReferredBy`);

            const closeRegisterForm = document.getElementById(`closeRegisterForm`);
            closeRegisterForm.addEventListener(`click`, () => {
                pFirstName.value = "";
                pLastName.value = "";
                pAddress.value = "";
                pBirth.value = "";
                pSex.value = "";
                pContact.value = "";
                pReferredBy.value = "";
                registerPatient.classList.remove(`active`);
            });
            
            const registrationForm = document.getElementById(`registrationForm`);
            registrationForm.addEventListener("submit", async (e) => {
                e.preventDefault();

                pBirth.addEventListener("input", () => {
                    if(pBirth.value !== ""){
                        pBirth.style.borderColor = "var(--border-color)";
                    }
                });

                try{
                    const formdata = new FormData(e.target);
                    const res = await fetch("api/add_patient.php", {
                        method: "POST",
                        body: formdata
                    });

                    const data = await res.json();

                    if(!data.ok){
                        responseMessage(data, data.error);
                    } else {
                        pFirstName.value = "";
                        pLastName.value = "";
                        pAddress.value = "";
                        pBirth.value = "";
                        pSex.value = "";
                        pContact.value = "";
                        pReferredBy.value = "";
                        responseMessage(data, data.message);
                        registerPatient.classList.remove(`active`);
                        loadPatientsData();
                    }

                    if(!data.birthdate){
                        pBirth.style.borderColor = "red";
                    } else {
                        pBirth.style.borderColor = "var(--border-color)";
                    }
                } catch(err){
                    console.error(err);
                }
            });
        }

        const editPatientPanel = document.getElementById(`editPatientPanel`);
        if (editPatientPanel) {
            const updateFirstName = document.getElementById(`updateFirstName`);
            const updateLastName = document.getElementById(`updateLastName`);
            const updateAddress = document.getElementById(`updateAddress`);
            const updateBirth = document.getElementById(`updateBirth`);
            const updateSex = document.getElementById(`updateSex`);
            const updateContact = document.getElementById(`updateContact`);

            const editPatientForm = document.getElementById(`editPatientForm`);
            editPatientForm.addEventListener("submit", async (e) => {
                e.preventDefault();

                updateBirth.addEventListener("input", () => {
                    if(updateBirth.value !== ""){
                        updateBirth.style.borderColor = "var(--border-color)";
                    }
                });

                try{
                    const res = await fetch("api/edit_patient.php", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json"
                        },
                        body: JSON.stringify({ first_name: updateFirstName.value, last_name: updateLastName.value, address: updateAddress.value, birthdate: updateBirth.value, sex: updateSex.value, contact: updateContact.value, id: selectedPatientId })
                    });

                    const data = await res.json();

                    if(!data.ok){
                        responseMessage(data, data.error);
                    } else {
                        updateFirstName.value = "";
                        updateLastName.value = "";
                        updateAddress.value = "";
                        updateBirth.value = "";
                        updateSex.value = "";
                        updateContact.value = "";
                        responseMessage(data, data.message);
                        editPatientPanel.classList.remove(`active`);
                        loadPatientsData();
                    }

                    if(!data.birthdate){
                        updateBirth.style.borderColor = "red";
                    }
                } catch(err){
                    console.error(err);
                }
            });

            const closeEditForm = document.getElementById(`closeEditForm`);
            closeEditForm.addEventListener("click", () => {
                updateFirstName.value = "";
                updateLastName.value = "";
                updateAddress.value = "";
                updateBirth.value = "";
                updateSex.value = "";
                updateContact.value = "";
                editPatientPanel.classList.remove(`active`);
            });

        }
        
        const sortDirection = document.getElementById(`sortDirection`);
        const sortByName = document.getElementById(`sortByName`);
        const sortByAge = document.getElementById(`sortByAge`);
        const sortById = document.getElementById(`sortById`);
        let currentSort = `id`;
        let currentDirection = `ASC`;

        sortDirection.addEventListener(`click`, (e) => {
            e.preventDefault();
            if (sortDirection.value === `DESC`){
                sortDirection.innerText = `ASC`;
                sortDirection.value = `ASC`;
                currentDirection = 'ASC';
                sortPatient(currentSort, currentDirection);
            } else {
                sortDirection.innerText = `DESC`;
                sortDirection.value = `DESC`;
                currentDirection = 'DESC';
                sortPatient(currentSort, currentDirection);
            }
        });
        
        sortByName.addEventListener(`click`, (e) => {
            e.preventDefault();
            currentSort = 'last_name';
            sortByName.classList.add(`generalSort`);
            sortById.classList.remove(`generalSort`);
            sortByAge.classList.remove(`generalSort`);
            sortPatient(currentSort, currentDirection);
        });
        sortByAge.addEventListener(`click`, (e) => {
            e.preventDefault();
            currentSort = 'age';
            sortByName.classList.remove(`generalSort`);
            sortById.classList.remove(`generalSort`);
            sortByAge.classList.add(`generalSort`);
            sortPatient(currentSort, currentDirection);
        });
        sortById.addEventListener(`click`, (e) => {
            e.preventDefault();
            currentSort = 'id';
            sortByName.classList.remove(`generalSort`);
            sortById.classList.add(`generalSort`);
            sortByAge.classList.remove(`generalSort`);
            sortPatient(currentSort, currentDirection);
        });

        const confirmPatient = document.getElementById(`confirmPopUp`);
        const cancel = document.getElementById(`cancel`);
        cancel.addEventListener("click", () => {
            confirmPatient.classList.remove(`active`);
        });

        const confirm = document.getElementById(`confirm`);
        confirm.addEventListener("click", async (e) => {
            e.preventDefault();
            try {
                const res = await fetch(`api/delete_patient.php`, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({ patient: selectedPatientId })
                });

                const data = await res.json();

                if (!data.ok){
                    responseMessage(data, data.error);
                    return;
                }

                responseMessage(data, data.message);
                confirmPatient.classList.remove(`active`);
                loadPatientsData();
            } catch (err) {
                console.error(err);
            }
        });

    }

    const care = document.getElementById(`patientsCare`);
    if (care) {
        loadPatientsData();
    }

    const inventory = document.getElementById(`inventory`);
    if (inventory) {
        loadInventoryItem();
        const addItem = document.getElementById(`addItem`);
        addItem.addEventListener("click", () => {
            document.querySelector(`.popup`).classList.add(`active`);
        });

        const cancel = document.getElementById(`cancel`);
        cancel.addEventListener("click", () => {
            document.querySelector(`.popup`).classList.remove(`active`);
        });
        
        const addItemForm = document.getElementById(`addItemForm`);
        addItemForm.addEventListener("submit", async (e) => {
            e.preventDefault();

            try{
                const formdata = new FormData(e.target);
                const res = await fetch(`api/add_item.php`, {
                    method: "POST",
                    body: formdata
                })

                const data = await res.json();
                if(!data.ok) {
                    responseMessage(data, data.error);
                    return;
                }

                responseMessage(data, data.message);
                document.querySelector(`.popup`).classList.remove(`active`);
                loadInventoryItem();
            } catch (err) {
                console.error(err);
            }
            loadInventoryItem();
        });
    }
})