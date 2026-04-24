const state = {
    patient: { id: null },
    medicine: { id: null },
    item: { id: null },
    schedule:{ id: null },
    condition: { id: null },
    prescription: { id: null },
    calendar: { selected: null },
    sort: { order: 'id', direction: 'ASC' }
};
const months = [ `January`, `February`, `March`, `April`, `May`, `June`, `July`, `August`, `September`, `October`, `November`, `December` ];
let today = new Date();
let month = today.getMonth();
let year = today.getFullYear();
let occupiedDate = [];

function initCalendar(){ 
    const date = document.getElementById(`date`);
    const daysContainer = document.getElementById(`days`);
    const firstDay = new Date(year, month, 1).getDay();
    const lastDate = new Date(year, month + 1, 0).getDate();
    const prevLastDate = new Date(year, month, 0).getDate();
    const lastDay = new Date(year, month + 1, 0).getDay();
    const totalCells = firstDay + lastDate + (6 - lastDay);

    date.textContent = months[month] + ` ` + year; 
    daysContainer.innerHTML = "";

    for(let i = 0; i < totalCells; i++){
        const day = document.createElement(`span`);
        const currentDate = i - firstDay + 1;
        const formattedDate = `${year}-${String(month + 1).padStart(2, '0')}-${String(currentDate).padStart(2, '0')}`;

        if(i < firstDay) {
            day.textContent = prevLastDate - firstDay + i + 1;
            day.classList.add(`prev-days`);
        } else if (i < firstDay + lastDate) {
            day.textContent = currentDate;

            if(occupiedDate.includes(formattedDate)) {
                day.classList.add(`set`);
            }

            if(formattedDate === state.calendar.selected){
                day.classList.add(`selected`);
            }

            if(currentDate === new Date().getDate() && year === new Date().getFullYear() && month === new Date().getMonth()){
                day.classList.add(`current`);
            }

        } else {
            day.textContent = i - (firstDay + lastDate) + 1;
            day.classList.add(`next-days`);
        }

        day.addEventListener(`click`, async (e) => {
            e.preventDefault();
            state.calendar.selected = formattedDate;

            if(day.classList.contains(`selected`)){
                state.calendar.selected = null;
                loadList(`schedule`, renderSchedulesData);
                document.getElementById(`addSchedBtn`).classList.add(`hidden`);
                return;
            }

            document.getElementById(`addSchedBtn`).classList.remove(`hidden`);
            document.getElementById(`selectedDate`).textContent = `${months[month]} ${currentDate}, ${year}`;
            document.getElementById(`getDate`).value = formattedDate;
            filter(`schedule`, renderSchedulesData, formattedDate);
        });

        daysContainer.append(day);
    }

}

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
    const selected = document.querySelector(`.selected`);
    const schedule = document.getElementById(`schedule`);
    if(activePopup){ 
        activePopup.classList.remove(`active`);
        if(schedule && selected){
            selected.classList.remove(`selected`);
            document.getElementById(`addSchedBtn`).classList.add(`hidden`);
        }
    }
}

function renderPatientsData(data){
    const container = document.getElementById(`collection`);
    const template = document.getElementById(`patientsCard`);

    container.innerHTML = ``;

    data.collection.forEach( patient => {
        const [year, month, day] = patient.birthdate.split('-');
        const clone = template.content.cloneNode(true);

        const statusMark = clone.querySelector(`.status`);
        if(patient.status === `Active` || patient.status === `Complete`){
            statusMark.style.backgroundColor = `var(--good)`;
        } else if (patient.status === `Deceased` || patient.status === `Inactive`) {
            statusMark.style.backgroundColor = `var(--critical)`;
        } else {
            statusMark.style.backgroundColor = `var(--moderate)`;
        }

        statusMark.textContent = patient.status;
        clone.querySelector(`.id`).textContent = patient.id;
        clone.querySelector(`.name`).textContent = patient.last_name + ", " + patient.first_name;
        clone.querySelector(`.address`).textContent = patient.address;
        clone.querySelector(`.birthdate`).textContent = `${months[month - 1]} ${day}, ${year}`;
        clone.querySelector(`.age`).textContent = patient.age;
        clone.querySelector(`.sex`).textContent = patient.sex;
        clone.querySelector(`.contact`).textContent = patient.contact + " " + patient.extra_contact;
        clone.querySelector(`.referredBy`).textContent = patient.referred_by;
        clone.querySelector(`.patientPreviewBtn`).addEventListener(`click`, () => {
            document.getElementById(`patientPreview`).classList.add(`active`);
            document.getElementById(`pId`).textContent = patient.id;
            document.getElementById(`pName`).textContent = `${patient.last_name}, ${patient.first_name}`;
            document.getElementById(`pStatus`).textContent = patient.status;
            document.getElementById(`pAge`).textContent = patient.age;
            document.getElementById(`pSex`).textContent = patient.sex;
            document.getElementById(`pBirthdate`).textContent = `${months[month - 1]} ${day}, ${year}`;
            document.getElementById(`pAddress`).textContent = patient.address;
            document.getElementById(`pContacts`).textContent = patient.contact + " " + patient.extra_contact;
            document.getElementById(`pReferredBy`).textContent = patient.referred_by;
        });
        
        clone.querySelector(`.editPatientBtn`).addEventListener(`click`, () => {
            state.patient.id = patient.id;
            document.getElementById(`editPatient`).classList.add(`active`);
            document.getElementById(`updateFirstName`).value = patient.first_name;
            document.getElementById(`updateLastName`).value = patient.last_name;
            document.querySelector(`.updateSex`).value = patient.sex;
            document.getElementById(`updateBirthdate`).value = patient.birthdate;
            document.getElementById(`updateAddress`).value = patient.address;
            document.getElementById(`updateContact`).value = patient.contact;
            document.getElementById(`updateExContact`).value = patient.extra_contact ? patient.extra_contact : `N/A`;
            document.getElementById(`updateStatus`).value = patient.status;
            document.getElementById(`updateReferredBy`).value = patient.referred_by ? patient.referred_by : `N/A`;
        });

        clone.querySelector(`.deletePatientBtn`).addEventListener(`click`, () => {
            state.patient.id = patient.id;
            document.getElementById(`name`).textContent = patient.last_name + ", " + patient.first_name;
            document.getElementById(`id`).textContent = patient.id;
            document.getElementById(`deletePatient`).classList.add(`active`);
        });

        container.appendChild(clone);
    });
}

function renderPatientsDrop(data){
    const container = document.getElementById(`patientOption`);
    const template = document.getElementById(`patientOptnTemplate`);

    container.innerHTML = ``;
    data.collection.forEach(patient => {
        const clone = template.content.cloneNode(true);
        clone.querySelector(`.id`).textContent = patient.id;
        clone.querySelector(`.name`).textContent = `${patient.last_name}, ${patient.first_name}`;

        clone.querySelector(`.patient`).addEventListener(`click`, () => {
            document.getElementById(`firstName`).value = patient.first_name;
            document.getElementById(`lastName`).value = patient.last_name;
            document.getElementById(`contact`).value = patient.contact;
            document.getElementById(`exContact`).value = patient.extra_contact ? patient.extra_contact : 'N/A';
            document.getElementById(`patientOption`).classList.remove(`active`);
        });
        container.appendChild(clone);
    });
}

function renderPatientsDataForCare(data){
    const container = document.getElementById(`collection`);
    const template = document.getElementById(`patientCareCard`);

    container.innerHTML = ``;
    data.collection.forEach(patient => {
        const [year, month, day] = patient.birthdate.split('-');
        const clone = template.content.cloneNode(true);
        clone.querySelector(`.patient`).addEventListener(`click`, (e) => {
            state.patient.id = patient.id;
            const isSelected = e.currentTarget.classList.contains(`selected`);
            document.querySelectorAll(`.patient`).forEach(li => {
                li.classList.remove(`selected`)
            });

            if(isSelected){
                document.getElementById(`diagnose`).classList.remove(`open`);
                return;
            }

            e.currentTarget.classList.add(`selected`);

            document.getElementById(`prescriptionForm`).action = `/care/prescription/${patient.id}`;
            document.getElementById(`diagnosisForm`).action = `/care/patient/${patient.id}/diagnosis`;
            document.getElementById(`diagnose`).classList.add(`open`);
            document.getElementById(`patientId`).textContent = patient.id;
            document.getElementById(`patientName`).textContent = `${patient.last_name}, ${patient.first_name}`;
            document.getElementById(`patientAge`).textContent = patient.age;
            document.getElementById(`patientBirthdate`).textContent = `${months[month - 1]} ${day}, ${year}`;
            loadPatientDiagnosis();
            loadPatientPrescriptions();
        });
        clone.querySelector(`.name`).textContent = `${patient.last_name}, ${patient.first_name}`;
        clone.querySelector(`.age`).textContent = patient.age;

        container.appendChild(clone);
    });
}

function renderMedicineData(data){
    const container = document.getElementById(`collection`);
    const template = document.getElementById(`medicineCard`);

    container.innerHTML = ``;

    data.collection.forEach(medicine => {
        const clone = template.content.cloneNode(true);
        clone.querySelector(`.genericName`).textContent = medicine.generic_name;
        clone.querySelector(`.brandName`).textContent = medicine.brand_name;
        clone.querySelector(`.dosage`).textContent = medicine.dosage;
        clone.querySelector(`.form`).textContent = medicine.form;
        clone.querySelector(`.quantity`).textContent = medicine.quantity ? medicine.quantity + ' /': `No stocks`;
        clone.querySelector(`.minQuant`).textContent = medicine.minimum_quantity ? `${medicine.minimum_quantity} ${medicine.quantity_type}`: ``;
        clone.querySelector(`.isDonated`).textContent = medicine.is_donated ? `Donated` : `not Donated`;
        clone.querySelector(`.previewBtn`).addEventListener(`click`, () => {
            document.getElementById(`medsPreview`).classList.add(`active`);
            document.getElementById(`mId`).textContent = medicine.id;
            document.getElementById(`mGenericName`).textContent = medicine.generic_name;
            document.getElementById(`mBrandName`).textContent = medicine.brand_name ? medicine.brand_name : `N/A`;
            document.getElementById(`mDosage`).textContent = medicine.dosage;
            document.getElementById(`mForm`).textContent = medicine.form;
            document.getElementById(`mCategory`).textContent = medicine.category ? medicine.category : `N/A`;
            document.getElementById(`mQuantity`).textContent = medicine.quantity ? medicine.quantity : `N/A`;
            document.getElementById(`mMinQuant`).textContent = medicine.minimum_quantity ? medicine.minimum_quantity : `N/A`;
            document.getElementById(`mExpiration`).textContent = medicine.expiration_date;
            document.getElementById(`mIsDonated`).textContent = medicine.is_donated ? `Donated` : `not Donated`;
        });
        clone.querySelector(`.editBtn`).addEventListener(`click`, () => {
            state.medicine.id = medicine.id;
            document.getElementById(`genericName`).value = medicine.generic_name;
            document.getElementById(`brandName`).value = medicine.brand_name ? medicine.brandName : 'N/A';
            document.getElementById(`dosage`).value = medicine.dosage ? medicine.dosage : 'N/A';
            document.getElementById(`form`).value = medicine.form ? medicine.form : 'N/A';
            document.getElementById(`editMeds`).classList.add(`active`);
        });
        clone.querySelector(`.deleteBtn`).addEventListener(`click`, () => {
            state.medicine.id = medicine.id;
            document.getElementById(`deleteMedsForm`).action = `/medicines/delete/${medicine.id}`;
            document.getElementById(`name`).textContent = medicine.generic_name;
            document.getElementById(`id`).textContent = medicine.id;
            document.getElementById(`deleteMeds`).classList.add(`active`);
        });
        container.appendChild(clone);
    });
}
function renderMedsDrop(data){
    const container = document.getElementById(`medicineOptn`);
    const template = document.getElementById(`medicineCard`);
    const inventory = document.getElementById(`inventory`);

    container.innerHTML = ``;

    data.collection.forEach(medicine => {
        const clone = template.content.cloneNode(true);

        clone.querySelector(`.genericName`).textContent = medicine.generic_name;
        clone.querySelector(`.dosage`).textContent = medicine.dosage;
        clone.querySelector(`.form`).textContent = medicine.form;

        clone.querySelector(`.medicine`).addEventListener(`click`, () => {
            document.getElementById(`medicineOptn`).classList.remove(`active`);
            if(inventory){
                document.getElementById(`medicineId`).value = medicine.id;
                document.getElementById(`itemName`).value = medicine.generic_name;
                document.getElementById(`category`).value = `Medicine`;
                document.getElementById(`description`).value = `${medicine.brand_name} ${medicine.dosage} ${medicine.form}`;
            }
            document.getElementById(`medicineId`).value = medicine.id;
            document.getElementById(`medicineName`).value = medicine.generic_name;
        });
        container.appendChild(clone);
    });
}
function renderItemData(data){
    const container = document.getElementById(`collection`);
    const template = document.getElementById(`itemCard`);

    container.innerHTML = ``;
    data.collection.forEach(item => {
        const [year, month, day] = item.expiration_date.split('-');
        const clone = template.content.cloneNode(true);
        const stockStatus = clone.querySelector(`.stockStatus`);
        const exprStatus = clone.querySelector(`.exprStatus`);

        clone.querySelector(`.name`).textContent = item.name;
        if(item.is_donated){
            clone.querySelector(`.name`).classList.add(`donated`);
        }
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
            state.item.id = item.id;
            document.getElementById(`adjust`).classList.add(`active`);
            document.getElementById(`imCurrentQuant`).textContent = `${item.quantity} ${item.quantity_type}`;
            document.getElementById(`imName`).textContent = item.item_name;
        });

        clone.querySelector(`.previewItemBtn`).addEventListener(`click`, () => {
            document.getElementById(`itemPreview`).classList.add(`active`);
            document.getElementById(`iId`).textContent = item.id;
            document.getElementById(`iName`).textContent = item.name;
            document.getElementById(`iCategory`).textContent = item.category;
            document.getElementById(`iDescription`).textContent = item.description;
            document.getElementById(`iQuantity`).textContent = `${item.quantity} ${item.quantity_type}`;
            document.getElementById(`iMinQuant`).textContent = `${item.minimum_quantity} ${item.quantity_type}`;
            document.getElementById(`iQuantStatus`).textContent = item.stock_status;
            document.getElementById(`iExpiration`).textContent = `${months[month - 1]} ${day}, ${year}`;
            document.getElementById(`iExpirationStatus`).textContent = item.expiration_status;
            document.getElementById(`iIsDonated`).textContent = item.is_donated;
        });

        clone.querySelector(`.editItemBtn`).addEventListener(`click`, () => {
            state.item.id = item.id;
            document.getElementById(`editItem`).classList.add(`active`);
            document.getElementById(`updateItemName`).value = item.name;
            document.getElementById(`updateCategory`).value = item.category;
            document.getElementById(`updateMinQuant`).value = item.minimum_quantity;
            document.getElementById(`updateQuantityType`).value = item.quantity_type;
            document.getElementById(`updateDescription`).value = item.description;
            document.getElementById(`updateExpiration`).value = item.expiration_date;
        });
        clone.querySelector(`.deleteItemBtn`).addEventListener(`click`, () => {
            state.item.id = item.id;
            document.getElementById(`deleteItem`).classList.add(`active`);
            document.getElementById(`name`).textContent = item.name;
            document.getElementById(`id`).textContent = item.id;
        });

        container.appendChild(clone);
    });
}

function renderSchedulesData(data){
    const container = document.getElementById(`collection`);
    const template = document.getElementById(`scheduleCard`);

    container.innerHTML = ``;

    data.collection.forEach(schedule => {
        if(!occupiedDate.includes(schedule.date)){
            occupiedDate.push(schedule.date);
        }
        const clone = template.content.cloneNode(true);
        const [year, month, day] = schedule.date.split('-');
        const timeFormat = new Date(`1972-12-01T${schedule.time}`).toLocaleTimeString('en-US', { hour: 'numeric', minute: '2-digit', hour12: true });
        clone.querySelector(`.schedDate`).textContent = `${months[month - 1]} ${day}, ${year}`;
        clone.querySelector(`.schedTime`).textContent = timeFormat;
        clone.querySelector(`.patientName`).textContent = `${schedule.last_name}, ${schedule.first_name}`;
        clone.querySelector(`.schedFor`).textContent = schedule.scheduled_for;
        clone.querySelector(`.editBtn`).addEventListener(`click`, () => {
            state.schedule.id = schedule.id;
            document.getElementById(`sDate`).textContent = `${months[month - 1]} ${day}, ${year}`;
            document.getElementById(`patientName`).textContent = `${schedule.last_name}, ${schedule.first_name}`;
            document.getElementById(`editSched`).classList.add(`active`);
            document.getElementById(`updateSchedFor`).value = schedule.scheduled_for;
            document.getElementById(`updateTime`).value = schedule.time;
        });
        clone.querySelector(`.viewBtn`).addEventListener(`click`, () => {
            document.getElementById(`schedInfo`).classList.add(`active`);
            document.getElementById(`sId`).textContent = schedule.id;
            document.getElementById(`vDate`).textContent = `${months[month - 1]} ${day}, ${year}`;
            document.getElementById(`vTime`).textContent = timeFormat;
            document.getElementById(`sName`).textContent = `${schedule.last_name}, ${schedule.first_name}`;
            document.getElementById(`sContact`).textContent = schedule.contact;
            document.getElementById(`sExContact`).textContent = schedule.extra_contact;
        });
        clone.querySelector(`.deleteBtn`).addEventListener(`click`, () => {
            state.schedule.id = schedule.id;
            document.getElementById(`deleteSched`).classList.add(`active`);
            document.getElementById(`name`).textContent = `${schedule.last_name}, ${schedule.first_name}`;
            document.getElementById(`schedDate`).textContent = schedule.date;
        });
        container.appendChild(clone);
    });

    initCalendar();
}

async function loadPatientDiagnosis(){
    try{
        const res = await fetch(`/care/patient/${state.patient.id}/diagnosis`, {
            method: 'GET'
        });

        const data = await res.json();

        const container = document.getElementById(`diagnosis`);
        const template = document.getElementById(`conditionCard`);

        container.innerHTML = ``;

        data.diagnosis.forEach(diagnosed => {
            const clone = template.content.cloneNode(true);
            const created = new Date(diagnosed.created_at).toLocaleString(`en-PH`, { timeZone: 'Asia/Manila', month: '2-digit', day: '2-digit', year: 'numeric', hour: '2-digit', minute: '2-digit', hour12: true });
            clone.querySelector(`.condition`).textContent = diagnosed.condition_name;
            clone.querySelector(`.date`).textContent = created;
            clone.querySelector(`div`).addEventListener(`click`, async (e) => {
                e.preventDefault();
                try{
                    const res = await fetch(`/care/prescription/${state.patient.id}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({ diagnosisId: diagnosed.id })
                    });

                    const data = await res.json();

                    if(!data.ok){
                        responseMessage(data, data.error);
                        return;
                    }

                    loadPatientPrescriptions();
                } catch(err) {
                    console.error(err);
                }
            });

            clone.querySelector(`.removeCondition`).addEventListener(`click`, async (e) => {
                try{
                    const res = await fetch(`/care/patient/${state.patient.id}/diagnosis/${diagnosed.id}/delete`, {
                        method: 'DELETE'
                    });

                    const data = await res.json();

                    if(!data.ok){
                        responseMessage(data, data.error);
                        return;
                    }
                    loadPatientDiagnosis();
                    loadPatientPrescriptions();
                } catch(err){
                    console.error(err);
                }
            });
            container.appendChild(clone);
        });
    } catch (err){
        console.error(err);
    }
}

async function loadPatientPrescriptions() {
    try{
        const res = await fetch(`/care/patient/${state.patient.id}/prescriptions`, {
            method: 'GET'
        });

        const data = await res.json();

        if(!data.ok){
            responseMessage(data, data.error);
            return;
        }

        const container = document.getElementById(`prescription`);
        const template = document.getElementById(`prescriptionCard`);

        container.innerHTML = ``;
        data.collection.forEach(prescription => {
            const clone = template.content.cloneNode(true);
            const created = new Date(prescription.created_at).toLocaleString(`en-PH`, { timeZone: 'Asia/Manila', month: '2-digit', day: '2-digit', year: 'numeric', hour: '2-digit', minute: '2-digit', hour12: true });
            clone.querySelector(`.createdAt`).textContent = created;
            clone.querySelector(`.conditionName`).textContent = prescription.condition_name;
            clone.querySelector(`.deletePrescription`).addEventListener(`click`, () => {
                state.prescription.id = prescription.id;
                document.getElementById(`deletePrescriptionForm`).action = `/care/patient/${state.patient.id}/prescription/${prescription.id}/delete`;
                document.getElementById(`deletePrescription`).classList.add(`active`);
                document.getElementById(`name`).textContent = created;
                document.getElementById(`id`).textContent = prescription.id;
            });

            container.appendChild(clone);
        });
    } catch(err){
        console.error(err);
    }
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

async function sortList(page, render) {
    try {
        const res = await fetch(`/${page}/sort?order=${state.sort.order}&direction=${state.sort.direction}`, {
            method: "GET"
        });

        const data = await res.json();
        if (!data.ok) {
            responseMessage(data, data.error);
            return;
        }
        
        responseMessage(data, data.message);
        return render(data);
    } catch (err) {
        console.error(err);
    } 
}

function sorts(page, render){
    const sortDirection = document.getElementById(`direction`);
    const sort1 = document.getElementById(`sort1`);
    const sort2 = document.getElementById(`sort2`);
    const sort3 = document.getElementById(`sort3`);

    sortDirection.addEventListener(`click`, (e) => {
        e.preventDefault();
        state.sort.direction = state.sort.direction === 'DESC' ? 'ASC' : 'DESC';
        sortDirection.textContent = state.sort.direction;

        return sortList(page, render);
    });
    
    sort1.addEventListener(`click`, (e) => {
        e.preventDefault();
        state.sort.order = sort1.value;
        sort1.classList.add(`activeSort`);
        sort2.classList.remove(`activeSort`);
        sort3.classList.remove(`activeSort`);
        return sortList(page, render);
    });

    sort2.addEventListener(`click`, (e) => {
        e.preventDefault();
        state.sort.order = sort2.value;
        sort1.classList.remove(`activeSort`);
        sort2.classList.add(`activeSort`);
        sort3.classList.remove(`activeSort`);
        return sortList(page, render);
    });

    sort3.addEventListener(`click`, (e) => {
        e.preventDefault();
        state.sort.order = sort3.value;
        sort1.classList.remove(`activeSort`);
        sort2.classList.remove(`activeSort`);
        sort3.classList.add(`activeSort`);
        return sortList(page, render);
    });
}

async function search(url, render) {
    const sliced = url.split(`/`);
    document.getElementById(`searchForm`).addEventListener('submit', async (e) => {
        e.preventDefault();
        const keyword = document.getElementById(`search`).value;
        try{
            const res = await fetch(`${url}?search=${keyword}`, {
                method: "GET"
            });

            const data = await res.json();
            return render(data);
        } catch(err) {
            console.error(err);
        }
    });
    
    document.getElementById(`search`).addEventListener(`input`, (e) => {
        const search = document.getElementById(`search`).value;
        e.preventDefault();
        if(search === "") {
            loadList(sliced[0], render);
        }
    });
}

async function adjustQuantity(value, type){
    try{
        const res = await fetch(`/inventory/adjust`, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ id: state.item.id, value: value, type: type })
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

async function filter(page, render, by) {
    try {
        const res = await fetch(`/${page}/filter`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ filter: by })
        });

        const data = await res.json();
        if(!data.ok){
            responseMessage(data, data.error);
            return;
        }

        render(data);
    } catch(err) {
        console.error(err);
    }
}

async function dropdown(url, render, input){
    try {
        const res = await fetch(`${url}?search=${input}`, {
            method: 'GET'
        });

        const data = await res.json();

        if(data.collection.length === 0){
            document.querySelector(`.dropdown`).classList.remove(`active`);
        }

        return render(data);
    } catch (err){
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

    const care = document.getElementById(`care`);
    if(care){
        loadList(`care`, renderPatientsDataForCare);
        sorts(`care`, renderPatientsDataForCare);
        search(`care/patient`, renderPatientsDataForCare);

        document.getElementById(`diagnosisForm`).addEventListener(`submit`, async (e) => {
            e.preventDefault();
            try {
                const formdata = new FormData(e.target);
                const res = await fetch(`/care/patient/${state.patient.id}/diagnosis`, {
                    method: 'POST',
                    body: formdata
                });

                const data = await res.json();
                if(!data.ok){
                    responseMessage(data, data.error);
                    return;
                }

                loadPatientDiagnosis();
                document.getElementById(`conditionName`).value = ``;
            } catch (err) {
                console.error(err);
            }
        });

        let timeout;
        document.getElementById(`medicineName`).addEventListener(`input`, (e) => {
            e.preventDefault();
            const input = document.getElementById(`medicineName`);
            clearTimeout(timeout);
            document.getElementById(`medicineOptn`).classList.add(`active`);
            timeout = setTimeout(() => {
                dropdown(`care/medicine`, renderMedsDrop, input.value);
            }, 300);
            if(input.value === ''){
                document.getElementById(`medicineOptn`).classList.remove(`active`);
            }
        });

        document.getElementById(`prescriptionForm`).addEventListener(`submit`, async (e) => {
            e.preventDefault();
            try{
                const formdata = new FormData(e.target);
                const res = await fetch(`/care/prescription/${state.patient.id}`, {
                    method: 'POST',
                    body: formdata
                });

                const data = await res.json();

                if(!data.ok){
                    responseMessage(data, data.error);
                    return;
                }

                loadPatientPrescriptions();
            } catch(err) {
                console.error(err);
            }
        });

        document.getElementById(`deletePrescriptionForm`).addEventListener(`submit`, async (e) => {
            e.preventDefault();
            try{
                const res = await fetch(`/care/patient/${state.patient.id}/prescription/${state.prescription.id}/delete`, {
                    method: 'DELETE'
                });

                const data = await res.json();
                if(!data.ok){
                    responseMessage(data, data.error);
                    return;
                }
                loadPatientPrescriptions();
                document.getElementById(`deletePrescription`).classList.remove(`active`);
            } catch(err){
                console.error(err);
            }
        });
    }

    const patients = document.getElementById(`patients`);
    if(patients){
        loadList('patients', renderPatientsData);
        sorts(`patients`, renderPatientsData);
        search(`patients/patient`, renderPatientsData);

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
            const updateStatus = document.getElementById(`updateStatus`).value;
            const updateReferredBy = document.getElementById(`updateReferredBy`).value;
            const formdata = new FormData(e.target);
            try {
                const res = await fetch(`/patients/edit`, {
                    method:'PUT',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ id: state.patient.id, firstName: updateFirstName, lastName: updateLastName, birthdate: updateBirthdate, address: updateAddress, sex: updateSex, contact: updateContact, exContact: updateExContact, status: updateStatus, referredBy: updateReferredBy })
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
                loadList('patients', renderPatientsData);
            } catch (err) {
                console.error(err);
            }
        });

        document.getElementById(`deletePatientForm`).addEventListener(`submit`, async (e) => {
            e.preventDefault();
            try {
                const res = await fetch(`/patients/delete/${state.patient.id}`, {
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
    }

    const inventory = document.getElementById(`inventory`);
    if (inventory){
        loadList('inventory', renderItemData);
        sorts(`inventory`, renderItemData);
        search(`inventory/item`, renderItemData);
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
                itemName.value = ``;
                category.value = ``;
                quantity.value = ``;
                minQuant.value = ``;
                descrition.value = ``;
                expiration.value = ``;
                isDonated.value = ``;
            } catch (err) {
                console.error(err);
            }
        });

        const deleteItemForm = document.getElementById(`deleteItemForm`);
        deleteItemForm.addEventListener(`submit`, async (e) => {
            e.preventDefault();
            try {
                const res = await fetch(`/inventory/delete/${state.item.id}`, {
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
            const updateQuantityType = document.getElementById(`updateQuantityType`).value; 
            const updateDescription = document.getElementById(`updateDescription`).value; 
            const updateExpiration = document.getElementById(`updateExpiration`).value; 
            try {
                const res = await fetch(`/inventory/edit`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ id: state.item.id, itemName: updateItemName, category:updateCategory, minQuant: updateMinQuant, quantityType:updateQuantityType, description: updateDescription, expiration: updateExpiration })
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

        let timeout;
        itemName.addEventListener(`input`, (e) => {
            e.preventDefault();
            clearTimeout(timeout);

            timeout = setTimeout(() => {
                const value = itemName.value;
                const medsOptn = document.getElementById(`medicineOptn`);
                medsOptn.classList.add(`active`);
                dropdown(`inventory/medicine`, renderMedsDrop, value);
                if(value === ''){
                    medsOptn.classList.remove(`active`);
                }
            }, 300);
        });

    }

    const medicines = document.getElementById(`medicines`);
    if(medicines){
        loadList(`medicines`, renderMedicineData);
        sorts(`medicines`, renderMedicineData);
        search(`medicines/medicine`, renderMedicineData);
        document.getElementById(`addMedsBtn`).addEventListener(`click`, () => {
            document.getElementById(`addMeds`).classList.add(`active`);
        });

        document.getElementById(`addMedsForm`).addEventListener(`submit`, async (e) => {
            const genName = document.getElementById(`genName`);
            const brndName = document.getElementById(`brndName`);
            const dosage = document.getElementById(`dosage`);
            const form = document.getElementById(`form`);
            e.preventDefault();
            try {
                const formdata = new FormData(e.target);
                const res = await fetch(`/medicines/add`, {
                    method: 'POST',
                    body: formdata
                });

                const data = await res.json();
                if(!data.ok){
                    responseMessage(data, data.error);
                    return
                }

                responseMessage(data, data.message);
                loadList(`medicines`, renderMedicineData);
                document.getElementById(`addMeds`).classList.remove(`active`);
                genName.value = '';
                brndName.value = '';
                dosage.value = '';
                form.value = '';
            } catch (err) {
                console.error(err);
            }
        });

        document.getElementById(`editMedsForm`).addEventListener(`submit`, async (e) => {
            e.preventDefault(e);
            const genericName = document.getElementById(`genericName`).value;
            const brandName = document.getElementById(`brandName`).value;
            const dosage = document.getElementById(`dosage`).value;
            const form = document.getElementById(`form`).value;

            const res = await fetch(`/medicines/edit`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ id: state.medicine.id, genericName: genericName, brandName: brandName, dosage: dosage, form: form })
            });

            const data = await res.json();
            if(!data.ok){
                responseMessage(data, data.error);
                return;
            }

            responseMessage(data, data.message);
            loadList(`medicines`, renderMedicineData);
            document.getElementById(`editMeds`).classList.remove(`active`);
        });

        document.getElementById(`deleteMedsForm`).addEventListener(`submit`, async (e) => {
            e.preventDefault(e);
            try{
                const res = await fetch(`/medicines/delete/${state.medicine.id}`, {
                    method: 'DELETE'
                });

                const data = await res.json();
                if(!data.ok){
                    responseMessage(data, data.error);
                    return;
                }

                responseMessage(data, data.message);
                loadList(`medicines`, renderMedicineData);
                document.getElementById(`deleteMeds`).classList.remove(`active`);
            } catch(err){
                console.error(err);
            }
        });
    }

    const schedule = document.getElementById(`schedule`);
    if(schedule){
        loadList(`schedule`, renderSchedulesData);
        const addSchedBtn = document.getElementById(`addSchedBtn`);

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
            addSchedBtn.classList.add(`hidden`);
            initCalendar();
            loadList(`schedule`, renderSchedulesData);
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

        document.getElementById(`addSchedBtn`).addEventListener(`click`, () => {
            document.getElementById(`setSched`).classList.add(`active`);
        });

        let timeout;
        const findPatient = document.getElementById(`find`);
        findPatient.addEventListener(`input`, (e) => {
            e.preventDefault();
            const patientOptn = document.getElementById(`patientOption`); 
            clearTimeout(timeout);
            timeout = setTimeout(() => {
                patientOptn.classList.add(`active`);
                dropdown(`schedule/patient`, renderPatientsDrop, findPatient.value);

                if(findPatient.value === ``){
                    patientOptn.classList.remove(`active`);
                }
            }, 300);
        });

        document.getElementById(`setSched`).addEventListener(`submit`, async (e) => {
            e.preventDefault();
            try {
                const formdata = new FormData(e.target);
                const res = await fetch(`/schedule/add`, {
                    method: 'POST',
                    body: formdata
                });

                const data = await res.json();
                if(!data.ok){
                    responseMessage(data, data.error);
                    return;
                }

                responseMessage(data, data.message);
                document.getElementById(`setSched`).classList.remove(`active`);
                loadList(`schedule`, renderSchedulesData);
                selected.classList.remove(`selected`);
            } catch(err) {
                console.error(err);
            }
        });

        document.getElementById(`editSched`).addEventListener(`submit`, async (e) => {
            e.preventDefault();
            const updateSchedFor = document.getElementById(`updateSchedFor`).value;
            const updateTime = document.getElementById(`updateTime`).value;
            try {
                const res = await fetch(`/schedule/edit`, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ id: state.schedule.id, schedFor: updateSchedFor, time: updateTime })
                });

                const data = await res.json();
                if(!data.ok){
                    responseMessage(data, data.error);
                    return;
                }

                responseMessage(data, data.message);
                loadList(`schedule`, renderSchedulesData);
                document.getElementById(`editSched`).classList.remove(`active`);
            } catch (err) {
                console.error(err);
            }
        });

        document.getElementById(`deleteSchedForm`).addEventListener(`submit`, async (e) => {
            e.preventDefault();
            try{
                const res = await fetch(`/schedule/delete/${state.schedule.id}`, {
                    method: 'DELETE'
                });

                const data = await res.json();

                if(!data.ok){
                    responseMessage(data, data.error);
                    return;
                }

                responseMessage(data, data.message);
                loadList(`schedule`, renderSchedulesData);
                document.getElementById(`deleteSched`).classList.remove(`active`);
            } catch(err) {
                console.error(err);
            }
        });
    }

})