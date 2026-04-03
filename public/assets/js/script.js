let selectedPatientId = null;
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

    container.innerHTML = "";

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
            document.getElementById(`previewForm`).action = `/patients/view/${patient.id}`;
            patientPreview(patient.id);
            document.getElementById(`patientPreview`).classList.add(`active`);
        });
        
        clone.querySelector(`.editPatientBtn`).addEventListener(`click`, () => {
            document.getElementById(`editPatientForm`).action = `/patients/edit/${patient.id}`;
            document.getElementById(`editPatient`).classList.add(`active`);
            selectedPatientId = patient.id;

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
            document.getElementById(`deletePatientForm`).action = `/patients/delete/${patient.id}`;
            document.getElementById(`deletePatient`).classList.add(`active`);
            selectedPatientId = patient.id;
        });

        container.appendChild(clone);
    });
}

async function patientPreview(id){
    const previewPanel = document.getElementById(`patientPreview`);
    try{
        const res = await fetch(`/patients/view/${id}`, {
            method: "GET"
        });
        const data = await res.json();

        if(previewPanel){
            document.getElementById(`pId`).textContent = data.information.id;
            document.getElementById(`pName`).textContent = `${data.information.last_name}, ${data.information.first_name}`;
            document.getElementById(`pAge`).textContent = data.information.age;
            document.getElementById(`pSex`).textContent = data.information.sex;
            document.getElementById(`pBirthdate`).textContent = data.information.birthdate;
            document.getElementById(`pAddress`).textContent = data.information.address;
            document.getElementById(`pContacts`).textContent = data.information.contact + data.information.extra_contact;
            document.getElementById(`pReferredBy`).textContent = data.information.referred_by;
        }
    } catch(err) {
        console.error(err);
    }
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

        const sortDirection = document.getElementById(`direction`);
        const sortByName = document.getElementById(`byName`);
        const sortByAge = document.getElementById(`byAge`);
        const sortById = document.getElementById(`byId`);

        sortDirection.addEventListener(`click`, (e) => {
            e.preventDefault();
            direction = direction === 'DESC' ? 'ASC' : 'DESC';
            sortDirection.textContent = direction;
            sortPatients();
        });
        
        sortByName.addEventListener(`click`, (e) => {
            e.preventDefault();
            order = 'last_name';
            sortByName.classList.add(`activeSort`);
            sortById.classList.remove(`activeSort`);
            sortByAge.classList.remove(`activeSort`);
            sortPatients();
        });

        sortByAge.addEventListener(`click`, (e) => {
            e.preventDefault();
            order = 'age';
            sortByName.classList.remove(`activeSort`);
            sortById.classList.remove(`activeSort`);
            sortByAge.classList.add(`activeSort`);
            sortPatients();
        });
        sortById.addEventListener(`click`, (e) => {
            e.preventDefault();
            order = 'id';
            sortByName.classList.remove(`activeSort`);
            sortById.classList.add(`activeSort`);
            sortByAge.classList.remove(`activeSort`);
            sortPatients();
        });

        const closePreview = document.getElementById(`closePreview`);
        closePreview.addEventListener(`click`, () => {
            document.getElementById(`patientPreview`).classList.remove(`active`);
        });

        const closeDelete = document.getElementById(`closeDelete`);
        closeDelete.addEventListener(`click`, () => {
            document.getElementById(`deletePatient`).classList.remove(`active`);
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
                const res = await fetch(`/patients/find?search=${keyword}`, {
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

    
})