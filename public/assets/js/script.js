let url = null;


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
    const previewForm = document.getElementById(`previewForm`);
    const previewPanel = document.getElementById(`patientPreview`);
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
        clone.querySelector(`.contact`).textContent = patient.contacts;
        clone.querySelector(`.referredBy`).textContent = patient.referred_by;
        clone.querySelector(`.patientPreviewBtn`).addEventListener(`click`, () => {
            previewForm.action = `/patients/patient/view?id=${patient.id}`;
            patientPreview(patient.id);
            previewPanel.classList.add(`active`);
        });
        container.appendChild(clone);
    });
}

async function patientPreview(id){
    const previewPanel = document.getElementById(`patientPreview`);
    try{
        const res = await fetch(`/patients/patient/view?id=${id}`, {
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
            document.getElementById(`pContacts`).textContent = data.information.contacts;
            document.getElementById(`pReferredBy`).textContent = data.information.referred_by;
        }
    } catch(err) {
        console.error(err);
    }
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

        const profilePop = document.querySelector(`.popup`);
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

        const registerPatientForm = document.getElementById(`registerPatientForm`);
        registerPatientForm.addEventListener(`submit`, async (e) => {
            e.preventDefault();
            const formdata = new FormData(e.target);
            try {
                const res = await fetch('/patients/patient/register', {
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
            sortByName.classList.add(`activeSort`);
            sortById.classList.remove(`activeSort`);
            sortByAge.classList.remove(`activeSort`);
            sortPatient(currentSort, currentDirection);
        });

        sortByAge.addEventListener(`click`, (e) => {
            e.preventDefault();
            currentSort = 'age';
            sortByName.classList.remove(`activeSort`);
            sortById.classList.remove(`activeSort`);
            sortByAge.classList.add(`activeSort`);
            sortPatient(currentSort, currentDirection);
        });
        sortById.addEventListener(`click`, (e) => {
            e.preventDefault();
            currentSort = 'id';
            sortByName.classList.remove(`activeSort`);
            sortById.classList.add(`activeSort`);
            sortByAge.classList.remove(`activeSort`);
            sortPatient(currentSort, currentDirection);
        });

        const patientPreview = document.getElementById(`patientPreview`);
        const closePreview = document.getElementById(`closePreview`);
        closePreview.addEventListener(`click`, () => {
            patientPreview.classList.remove(`active`);
        });


    }

    
})