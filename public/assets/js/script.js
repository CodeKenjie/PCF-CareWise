const state = {
    patient: { id: null },
    editor: { id: null },
    medicine: { id: null },
    item: { id: null },
    schedule:{ id: null },
    condition: { id: null },
    prescription: { id: null, item: null },
    calendar: { selected: null },
    sort: { order: 'id', direction: 'ASC' }
};
const months = [ `January`, `February`, `March`, `April`, `May`, `June`, `July`, `August`, `September`, `October`, `November`, `December` ];
let today = new Date();
let month = today.getMonth();
let year = today.getFullYear();
let occupiedDate = [];

function initChart(stockData){
    const totalStock = stockData.high + stockData.medium + stockData.low;
    const totalExp = stockData.good + stockData.soon + stockData.expired;
    if (totalStock === 0) return;
    if (totalExp === 0) return;
    const percentages = { high: (stockData.high/totalStock) * 100, medium: (stockData.medium / totalStock) * 100, low: (stockData.low / totalStock) * 100 };
    const expPercentages = { good: (stockData.good/totalExp) * 100, soon: (stockData.soon / totalExp) * 100, expired: (stockData.expired / totalExp) * 100 };
    const radius = 15.915;
    const circumference = 2 * Math.PI * radius;
    const high = document.querySelector(`.high`);
    const medium = document.querySelector(`.medium`);
    const low = document.querySelector(`.low`);

    const good = document.querySelector(`.good`);
    const soon = document.querySelector(`.soon`);
    const expired = document.querySelector(`.expired`);

    const totalItems = document.getElementById(`totalItems`);
    const expStatus = document.getElementById(`exp-status`);
    const label = document.getElementById(`label`);
    const explabel = document.getElementById(`explabel`);

    if (!high || !medium || !low || !good || !soon || !expired) return;

    function setSegment(segment, percent, offset){
        const dash = (percent / 100) * circumference;
        segment.style.strokeDasharray = `${dash} ${circumference}`;
        segment.style.strokeDashoffset = offset;
    }

    let quantOffset = 0;
    let expOffset = 0;

    document.querySelectorAll(`.segment`).forEach(s => {
        s.style.strokeDasharray  = `0 ${circumference}`

        s.addEventListener(`mouseleave`, () => {
            totalItems.textContent = totalStock;
            expStatus.textContent = totalExp;
            label.textContent = `Items`;
            explabel.textContent = `Items`;
        });
    });

    setTimeout(() => {
        setSegment(high, percentages.high, quantOffset);
        quantOffset -= (percentages.high / 100) * circumference;

        setSegment(medium, percentages.medium, quantOffset);
        quantOffset -= (percentages.medium / 100) * circumference;

        setSegment(low, percentages.low, quantOffset);

        setSegment(good, expPercentages.good, expOffset);
        expOffset -= (expPercentages.good / 100) * circumference;

        setSegment(soon, expPercentages.soon, expOffset);
        expOffset -= (expPercentages.soon / 100) * circumference;

        setSegment(expired, expPercentages.expired, expOffset);
    }, 100);

    totalItems.textContent = totalStock;
    expStatus.textContent = totalExp;

    high.addEventListener(`mouseenter`, () => {
        totalItems.textContent = percentages.high.toFixed(1) + `%`;
        label.textContent = `High Stocks`;
    });

    medium.addEventListener(`mouseenter`, () => {
        totalItems.textContent = percentages.medium.toFixed(1) + `%`;
        label.textContent = `Medium Stocks`;
    });

    low.addEventListener(`mouseenter`, () => {
        totalItems.textContent = percentages.low.toFixed(1) + `%`;
        label.textContent = `Low Stocks`;
    });

    good.addEventListener(`mouseenter`, () => {
        expStatus.textContent = expPercentages.good.toFixed(1) + `%`;
        explabel.textContent = `Good`;
    });

    soon.addEventListener(`mouseenter`, () => {
        expStatus.textContent = expPercentages.soon.toFixed(1) + `%`;
        explabel.textContent = `Expiring Soon`;
    });

    expired.addEventListener(`mouseenter`, () => {
        expStatus.textContent = expPercentages.expired.toFixed(1) + `%`;
        explabel.textContent = `Expired`;
    });
}

function calculateStocks(collection){
    return {
        high: collection.filter(i => i.stock_status.includes(`High Stocks`)).length,
        medium: collection.filter(i => i.stock_status.includes(`Medium Stocks`)).length,
        low: collection.filter(i => i.stock_status.includes(`Low Stocks`)).length,
        good: collection.filter(i => i.expiration_status.includes(`Good`)).length,
        soon: collection.filter(i => i.expiration_status.includes(`Expiring Soon`)).length,
        expired: collection.filter(i => i.expiration_status.includes(`Expired`)).length,
    }
}

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
        todayDate = formattedDate;
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
        const avatarUpload = clone.querySelector(`.avatarUpload`);
        const form = clone.querySelector(`.patientAvatarForm`);
        const statusMark = clone.querySelector(`.status`);
        const save = clone.querySelector(`.save`);
        const img = clone.querySelector(`.profile img`);
        if(patient.status === `Active` || patient.status === `Complete`){
            statusMark.style.backgroundColor = `var(--good)`;
        } else if (patient.status === `Deceased` || patient.status === `Inactive`) {
            statusMark.style.backgroundColor = `var(--critical)`;
        } else {
            statusMark.style.backgroundColor = `var(--moderate)`;
        }
        statusMark.textContent = patient.status;
        clone.querySelector(`.id`).textContent = patient.id;
        img.src = patient.avatar ? patient.avatar : `assets/images/profile.png`;
        clone.querySelector(`.profile`).addEventListener(`mouseenter`, () => {
            avatarUpload.classList.add(`show`);
        });
        clone.querySelector(`.profile`).addEventListener(`mouseleave`, () => {
            avatarUpload.classList.remove(`show`);
        });

        clone.querySelector(`input[name="avatar"]`).onchange = function (e) {
            const file = e.target.files[0];

            img.src = URL.createObjectURL(file);
            save.classList.remove(`hidden`);
        };

        form.action = `/patients/${patient.id}/avatar`;
        save.addEventListener(`click`, async (e) => {
            e.preventDefault();
            try{
                const formdata = new FormData(form);
                const res = await fetch(`/patients/${patient.id}/avatar`, {
                    method: 'POST',
                    body: formdata
                });

                const data = await res.json();
                if(!data.ok){
                    return responseMessage(data, data.error);
                }

                responseMessage(data, data.message);
                loadList(`patients`, renderPatientsData);
            } catch(err){
                console.error(err);
            }
        });
        clone.querySelector(`.name`).textContent = patient.last_name + ", " + patient.first_name;
        clone.querySelector(`.address`).textContent = patient.address;
        clone.querySelector(`.birthdate`).textContent = `${months[month - 1]} ${day}, ${year}`;
        clone.querySelector(`.age`).textContent = patient.age;
        clone.querySelector(`.sex`).textContent = patient.sex;
        clone.querySelector(`.contact`).textContent = patient.contact + " " + patient.extra_contact;
        clone.querySelector(`.referredBy`).textContent = patient.referred_by;
        clone.querySelector(`.patientPreviewBtn`).addEventListener(`click`, () => {
            document.getElementById(`dp`).src = patient.avatar ? patient.avatar : `assets/images/profile.png`;
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
            document.getElementById(`editPatientForm`).action = `/patients/${patient.id}/edit`
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
        const [m, d, y] = new Date().toLocaleDateString('en-PH', { month: '2-digit', day: '2-digit', year: 'numeric' }).split('/');
        const [year, month, day] = patient.birthdate.split('-');
        const clone = template.content.cloneNode(true);
        const statusMark = clone.querySelector(`.pstatus`);
        clone.querySelector(`.patient`).addEventListener(`click`, (e) => {
            state.patient.id = patient.id;
            const isSelected = e.currentTarget.classList.contains(`selected`);
            document.querySelectorAll(`.patient`).forEach(li => {
                li.classList.remove(`selected`)
            });

            if(isSelected){
                document.getElementById(`care`).classList.remove(`open`);
                return;
            }

            e.currentTarget.classList.add(`selected`);

            document.getElementById(`care`).classList.add(`open`);
            document.getElementById(`prescriptionForm`).action = `/care/prescription/${patient.id}`;
            document.getElementById(`diagnosisForm`).action = `/care/patient/${patient.id}/diagnosis`;
            document.getElementById(`profpic`).src = patient.avatar ? patient.avatar : '/assets/images/profile.png';
            document.getElementById(`patientId`).textContent = patient.id;
            document.getElementById(`patientName`).textContent = `${patient.last_name}, ${patient.first_name}`;
            document.getElementById(`patientAge`).textContent = patient.age;
            document.getElementById(`patientBirthdate`).textContent = `${months[month - 1]} ${day}, ${year}`;
            document.getElementById(`patientStatus`).textContent = patient.status;
            loadPatientDiagnosis(patient.id);
            loadPatientPrescriptions(patient.id);
        });
        clone.querySelector(`.name`).textContent = `${patient.last_name}, ${patient.first_name}`;
        clone.querySelector(`.age`).textContent = patient.age;
        clone.querySelector(`.medicalReport`).addEventListener(`click`, async (e) => {
            e.preventDefault();
            document.getElementById(`printDate`).textContent = `${months[m - 1]} ${d}, ${y}`;
            document.getElementById(`medicalReport`).classList.add(`active`);
            document.getElementById(`printAvatar`).src = patient.avatar ? patient.avatar : `/assets/images/profile.png`;
            document.getElementById(`printName`).textContent = `${patient.last_name}, ${patient.first_name}`;
            document.getElementById(`printBirthdate`).textContent =  `${months[month - 1]} ${day}, ${year}`;
            document.getElementById(`printAge`).textContent = patient.age;
            document.getElementById(`printSex`).textContent = patient.sex;
            document.getElementById(`printAddress`).textContent = patient.address;
            document.getElementById(`printContacts`).textContent = `${patient.contact}${patient.extra_contact ? `, ${patient.extra_contact}`: ``}`;
            try{
                const res = await fetch(`/care/patient/${patient.id}/diagnosis`, {
                    method: 'GET'
                });
                const data = await res.json();
                if(!data.ok){
                    return responseMessage(data, data.error);
                }

                const container = document.getElementById(`printDiagnosis`);
                container.innerHTML = ``;
                data.diagnosis.forEach(diagnosed => {
                    const created = new Date(diagnosed.created_at).toLocaleString(`en-PH`, { timeZone: 'Asia/Manila', month: '2-digit', day: '2-digit', year: 'numeric', hour: '2-digit', minute: '2-digit', hour12: true });
                    const li = document.createElement(`li`);
                    const conditionName = document.createElement(`h3`);
                    conditionName.textContent = diagnosed.condition_name;
                    const createdAt = document.createElement(`h3`);
                    createdAt.textContent = created;
                    li.append(conditionName, createdAt);
                    container.appendChild(li);
                });
            } catch(err){
                console.error(err);
            }

            try{
                const res = await fetch(`/care/patient/${patient.id}/prescriptions`, {
                    method: 'GET'
                });

                const data = await res.json();
                if(!data.ok){
                    return responseMessage(data, data.error);
                }

                const container = document.getElementById(`printPrescriptions`);
                container.innerHTML = ``;
                data.collection.forEach(prescription => {
                    const created = new Date(prescription.created_at).toLocaleString(`en-PH`, { timeZone: 'Asia/Manila', month: '2-digit', day: '2-digit', year: 'numeric', hour: '2-digit', minute: '2-digit', hour12: true });
                    const div = document.createElement(`div`);
                    div.style.display = `flex`;
                    div.style.justifyContent = `space-between`;
                    const li = document.createElement(`li`);
                    li.style.display = `flex`;
                    li.style.flexDirection = `column`;
                    li.style.gap = `0`;
                    const date = document.createElement(`h3`);
                    date.textContent = created;
                    const condition = document.createElement(`h3`);
                    condition.textContent = prescription.condition_name ? prescription.condition_name : ``; 

                    const ul = document.createElement(`ul`);
                    ul.style.gap = `0`;
                    ul.style.padding = `0`;
                    (async () => {
                        try {
                            const res = await fetch(`/care/prescription/${prescription.id}/all`, {
                                method: 'GET'
                            });
                            const data = await res.json();
                            if(!data.ok){
                                return responseMessage(data, data.error);
                            }

                            data.collection.forEach(medication => {
                                const [ month, day, year ] = new Date(medication.valid_until).toLocaleString(`en-PH`, { timeZone: 'Asia/Manila', month: '2-digit', day: '2-digit', year: 'numeric' }).split(`/`);
                                const li = document.createElement(`li`);
                                li.classList.add(`medicineGiven`);
                                const medicine = document.createElement(`h3`);
                                medicine.textContent = `${medication.generic_name} (${medication.brand_name})`;
                                const dosage = document.createElement(`h3`);
                                dosage.textContent = `${medication.dose_amount} ${medication.dose_unit}`;
                                const frequency = document.createElement(`h3`);
                                frequency.textContent = `${medication.frequency_per_day}x a day`;
                                const duration = document.createElement(`h3`);
                                duration.textContent = `for: ${medication.duration} ${medication.duration_unit}`;
                                const validUntil = document.createElement(`h3`);
                                validUntil.textContent = `${months[month - 1]} ${day}, ${year}`;
                                const span = document.createElement(`span`);
                                const h5 = document.createElement(`h5`);
                                h5.textContent = `Instructions:`
                                const p = document.createElement(`p`);
                                p.textContent = medication.instructions;

                                span.append(h5, p);
                                li.append(medicine, dosage, frequency, duration, validUntil, span);
                                ul.appendChild(li);
                            });
                        } catch(err) {
                            console.error(err);
                        }
                    })();
                    
                    div.append(condition, date);
                    li.append(div, ul);
                    container.appendChild(li);
                });
            } catch(err){
                console.error(err);
            }
        });
        statusMark.textContent = patient.status;
        if(patient.status === `Active` || patient.status === `Complete`){
            statusMark.style.backgroundColor = `var(--good)`;
        } else if (patient.status === `Deceased` || patient.status === `Inactive`) {
            statusMark.style.backgroundColor = `var(--critical)`;
        } else {
            statusMark.style.backgroundColor = `var(--moderate)`;
        }
        container.appendChild(clone);

        document.getElementById(`setSchedBtn`).addEventListener(`click`, () => {
            document.getElementById(`setSched`).classList.add(`active`);
            document.getElementById(`firstName`).value = patient.first_name;
            document.getElementById(`lastName`).value = patient.last_name;
            document.getElementById(`contact`).value = patient.contact;
            document.getElementById(`exContact`).value = patient.extra_contact ? patient.extra_contact : `N/A`;
            document.getElementById(`scheduledFor`).value = `Taking medicines`;
        });
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
        clone.querySelector(`.copyBtn`).addEventListener(`click`, () => {
            document.getElementById(`addMeds`).classList.add(`active`);
            document.getElementById(`genName`).value = medicine.generic_name;
            document.getElementById(`brndName`).value = medicine.brand_name;
            document.getElementById(`dosage`).value = medicine.dosage;
            document.getElementById(`form`).value = medicine.form;
        });
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
            document.getElementById(`brandName`).value = medicine.brand_name ? medicine.brand_name : 'N/A';
            document.getElementById(`updateDosage`).value = medicine.dosage ? medicine.dosage : 'N/A';
            document.getElementById(`updateForm`).value = medicine.form ? medicine.form : 'N/A';
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
    const care = document.getElementById(`care`);

    container.innerHTML = ``;

    data.collection.forEach(medicine => {
        const clone = template.content.cloneNode(true);

        clone.querySelector(`.genericName`).innerHTML = `${medicine.generic_name} <span style="opacity: 50%">(${medicine.brand_name ? medicine.brand_name : `N/A`})</span>`;
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

            if(care) {
                document.getElementById(`medicineId`).value = medicine.id;
                document.getElementById(`medicineName`).value = `${medicine.brand_name} ${medicine.generic_name}`;
                document.getElementById(`doseUnit`).value = medicine.form;
            }
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
        } else if (item.expiration_status === "Expiring Soon") {
            exprStatus.classList.add(`moderate`);
        } else {
            exprStatus.classList.add(`critical`);
        }
        stockStatus.style.setProperty(`--textFromJs`, `"${item.quantity}${item.quantity_type} min: ${item.minimum_quantity}${item.quantity_type}"`);
        exprStatus.style.setProperty(`--textFromJs`, `"Expiration: ${item.expiration_date}"`);
        clone.querySelector(`.adjustBtn`).addEventListener(`click`, () => {
            state.item.id = item.id;
            document.getElementById(`adjust`).classList.add(`active`);
            document.getElementById(`imCurrentQuant`).textContent = `${item.quantity} ${item.quantity_type}`;
            document.getElementById(`imName`).textContent = item.name;
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
        const clone = template.content.cloneNode(true);
        const date = new Date(schedule.date);
        const [year, month, day] = schedule.date.split('-');
        const timeFormat = new Date(`${schedule.date}T${schedule.time}`).toLocaleTimeString('en-PH', { hour: 'numeric', minute: '2-digit', hour12: true });
        const now = new Date();
        const [y, m, d] = schedule.date.split('-');
        const [hh, mm, ss] = schedule.time.split(':');
        const sched = new Date(Number(y), Number(m) - 1, Number(d), Number(hh), Number(mm), Number(ss));

        if(!occupiedDate.includes(schedule.date)){
            occupiedDate.push(schedule.date);
        }

        if(sched <= now){
            clone.querySelector(`li`).classList.add(`expired`);
            clone.querySelector(`.reSched`).classList.remove(`hidden`);
            clone.querySelector(`.editBtn`).classList.add(`hidden`);
            clone.querySelector(`.viewBtn`).classList.add(`hidden`);

            if(schedule.frequency === `Everyday`){
                date.setDate(date.getDate() + 1);
                const newDate = date.toISOString().split('T')[0];
                reschedule(schedule.id, newDate);
            } else if(schedule.frequency === `Every week`) {
                date.setDate(date.getDate() + 7);
                const newDate = date.toISOString().split('T')[0];
                reschedule(schedule.id, newDate);
            } else if(schedule.frequency === `Every 30 days`){
                date.setDate(date.getDate() + 30);
                const newDate = date.toISOString().split('T')[0];
                reschedule(schedule.id, newDate);
            }
        }

        clone.querySelector(`.schedDate`).textContent = `${months[month - 1]} ${day}, ${year}`;
        clone.querySelector(`.schedTime`).textContent = `${timeFormat} (${schedule.frequency})`;
        clone.querySelector(`.patientName`).textContent = `${schedule.last_name}, ${schedule.first_name}`;
        clone.querySelector(`.schedFor`).textContent = schedule.scheduled_for;
        clone.querySelector(`.reSched`).addEventListener(`click`, async (e) => {
            e.preventDefault();
            date.setMonth(date.getMonth() + 1);
            const newDate = date.toISOString().split('T')[0];
            reschedule(schedule.id, newDate);
        });
        clone.querySelector(`.editBtn`).addEventListener(`click`, () => {
            state.schedule.id = schedule.id;
            document.getElementById(`sDate`).textContent = `${months[month - 1]} ${day}, ${year}`;
            document.getElementById(`patientName`).textContent = `${schedule.last_name}, ${schedule.first_name}`;
            document.getElementById(`editSched`).classList.add(`active`);
            document.getElementById(`updateTime`).value = schedule.time;
            document.getElementById(`updateFrequency`).value = schedule.frequency;
            document.getElementById(`updateSchedFor`).value = schedule.scheduled_for;
        });
        clone.querySelector(`.viewBtn`).addEventListener(`click`, () => {
            document.getElementById(`schedInfo`).classList.add(`active`);
            document.getElementById(`sId`).textContent = schedule.id;
            document.getElementById(`vDate`).textContent = `${months[month - 1]} ${day}, ${year}`;
            document.getElementById(`vTime`).textContent = timeFormat;
            document.getElementById(`sName`).textContent = `${schedule.last_name}, ${schedule.first_name}`;
            document.getElementById(`sContact`).textContent = schedule.contact;
            document.getElementById(`sExContact`).textContent = schedule.extra_contact ? schedule.extra_contact : `N/A`;
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

async function renderNotifications(data){
    const container = document.getElementById(`notifications`);
    const template = document.getElementById(`notificationCard`);

    container.innerHTML = ``;

    data.collection.forEach(notification => {
        const clone = template.content.cloneNode(true);
        if(notification.link === '/schedule') {
            clone.querySelector(`.schedule`).classList.remove(`hidden`);
        } else if (notification.link === '/dashboard') {
            clone.querySelector(`.dashboard`).classList.remove(`hidden`);
        } else if (notification.link === '/care') {
            clone.querySelector(`.care`).classList.remove(`hidden`);
        } else if (notification.link === '/inventory') {
            clone.querySelector(`.inventory`).classList.remove(`hidden`);
        } else if (notification.link === '/patients') {
            clone.querySelector(`.patients`).classList.remove(`hidden`);
        } else if (notification.link === '/me') {
            clone.querySelector(`.request`).classList.remove(`hidden`);
        } else if (notification.link === '/medicines') {
            clone.querySelector(`.medicines`).classList.remove(`hidden`);
        }

        const newNotf = clone.querySelector(`.new`);
        if(!notification.is_read){
            document.querySelector(`#notifBtn > .new`).classList.remove(`hidden`);
            newNotf.classList.remove(`hidden`);
        }

        if(notification.is_read){
            clone.querySelector(`li`).classList.add(`read`);
        }

        clone.querySelector(`.title`).textContent = notification.title;
        clone.querySelector(`.content`).textContent = notification.content;
        clone.querySelector(`.go`).addEventListener(`click`, () => {
            (async () =>{
                try {
                    const res = await fetch(`/notifications/${notification.id}/read`, {
                        method: 'PATCH'
                    });

                    loadList(`notifications`, renderNotifications);
                    newNotf.classList.add(`hidden`);
                    window.location.replace(notification.link);
                } catch(err){
                    console.error(err);
                }
            })();
        });

        clone.querySelector(`.remove`).addEventListener(`click`, async (e) =>{
            e.preventDefault();
            try{
                const res = await fetch(`/notifications/${notification.id}/delete`, {
                    method: 'DELETE'
                });

                const data = await res.json();
                if(!data.ok){
                    return responseMessage(data, data.error);
                }
                loadList(`notifications`, renderNotifications);
            } catch(err){
                console.error(err);
            }
        })
        container.appendChild(clone);
    });
} 

async function reschedule(id, date) {
    try{
        const res = await fetch(`schedule/${id}/reschedule`, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ newDate: date })
        });

        const data = await res.json();
        if(!data.ok){
            responseMessage(data, data.error);
            return;
        }

        responseMessage(data, data.message);
        loadList(`schedule`, renderSchedulesData);
        occupiedDate = [];
    } catch(err){
        console.error(err);
    }
}

async function loadPatientDiagnosis(id){
    try{
        const res = await fetch(`/care/patient/${id}/diagnosis`, {
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
            clone.querySelector(`.prescribe`).addEventListener(`click`, async (e) => {
                e.preventDefault();
                try{
                    const res = await fetch(`/care/prescription/${id}`, {
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

                    loadPatientPrescriptions(id);
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
                    loadPatientDiagnosis(id);
                    loadPatientPrescriptions(id);
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

async function loadPatientPrescriptions(id) {
    try{
        const res = await fetch(`/care/patient/${id}/prescriptions`, {
            method: 'GET'
        });

        const data = await res.json();

        if(!data.ok){
            responseMessage(data, data.error);
            return;
        }

        document.getElementById(`setSchedBtn`).addEventListener(`click`, () => {
            document.getElementById(`scheduledFor`).value = `Take ${data.collection.map(p => {
                const [ month, day, year ] = new Date(p.created_at).toLocaleString(`en-PH`, { timeZone: 'Asia/Manila', month: '2-digit', day: '2-digit', year: 'numeric'}).split(`/`)
                return `${months[month - 1]} ${day}, ${year} prescription ${p.condition_name ? `for ` + p.condition_name : ``}`
            }).join(', ')} prescribed medicine/s`;
        });

        const container = document.getElementById(`prescription`);
        const template = document.getElementById(`prescriptionCard`);

        container.innerHTML = ``;
        data.collection.forEach(prescription => {
            const clone = template.content.cloneNode(true);
            const expand = clone.querySelector(`.btn-expand`);
            const prescribedMeds = clone.querySelector(`.prescribedMeds`);
            const created = new Date(prescription.created_at).toLocaleString(`en-PH`, { timeZone: 'Asia/Manila', month: '2-digit', day: '2-digit', year: 'numeric', hour: '2-digit', minute: '2-digit', hour12: true });
            clone.querySelector(`.createdAt`).textContent = created;
            clone.querySelector(`.conditionName`).textContent = prescription.condition_name;
            clone.querySelector(`.expand`).addEventListener(`click`, () => {
                expand.classList.toggle(`hide`);
                prescribedMeds.classList.toggle(`expand`);
                loadPrescriptionItems(prescription.id, prescribedMeds);
            });
            clone.querySelector(`.prescribeBtn`).addEventListener(`click`, () => {
                state.prescription.id = prescription.id;
                expand.classList.add(`hide`);
                prescribedMeds.classList.add(`expand`);
                document.getElementById(`prescribeMed`).classList.add(`active`);
                document.getElementById(`prescribeMedForm`).action = `/care/prescribe/${prescription.id}`;
                loadPrescriptionItems(prescription.id, prescribedMeds);
            });
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

async function loadPrescriptionItems(id, container){
    try {
        const res = await fetch(`/care/prescription/${id}/all`, {
            method: 'GET'
        });

        const data = await res.json();
        if(!data.ok){
            responseMessage(data, data.error);
            return;
        }

        const template = document.getElementById(`prescribedCard`);
        container.innerHTML = ``;

        data.collection.forEach(medication => {
            const clone = template.content.cloneNode(true);
            const [ createdMonth, createdDay, createdYear ] = new Date(medication.created_at).toLocaleString(`en-PH`, { timeZone: 'Asia/Manila', month: '2-digit', day: '2-digit', year: 'numeric' }).split(`/`);
            const [ exMonth, exDay, exYear ] = new Date(medication.valid_until).toLocaleString(`en-PH`, { timeZone: 'Asia/Manila', month: '2-digit', day: '2-digit', year: 'numeric' }).split(`/`);
            if(!medication.quantity){
                clone.querySelector(`li`).classList.add(`null`);
            }
            clone.querySelector(`.medicineName`).innerHTML = `${medication.generic_name} <span>(${medication.brand_name})</span>`;
            clone.querySelector(`.doseAmount`).innerHTML =`${medication.dose_amount} <span>${medication.dose_unit}</span>`;
            clone.querySelector(`.frequency`).textContent = medication.frequency_per_day;
            clone.querySelector(`.duration`).innerHTML = `for: ${medication.duration} ${medication.duration_unit}`;
            clone.querySelector(`.setSched`).addEventListener(`click`, () => {
                if(!medication.quantity){
                    responseMessage(false, `${medication.generic_name}(${medication.brand_name}) has no quantity or stock`);
                    return;
                }
                document.getElementById(`setSched`).classList.add(`active`);
                document.getElementById(`firstName`).value = medication.first_name;
                document.getElementById(`lastName`).value = medication.last_name;
                document.getElementById(`contact`).value = medication.contact;
                document.getElementById(`exContact`).value = medication.extra_contact;
                document.getElementById(`scheduledFor`).value = `${medication.generic_name}(${medication.brand_name}) - ${medication.dosage}(${medication.form}) ${medication.dose_amount} ${medication.dose_unit}`;
            });
            clone.querySelector(`.info`).addEventListener(`click`, () => {
                document.getElementById(`prescribedInfo`).classList.add(`active`);
                document.getElementById(`presCreatedAt`).textContent = `${months[createdMonth - 1]} ${createdDay}, ${createdYear}`;
                document.getElementById(`presValidUntil`).textContent = `${months[exMonth - 1]} ${exDay}, ${exYear}`;
                document.getElementById(`pmId`).textContent = medication.id;
                document.getElementById(`genericName`).textContent = medication.generic_name;
                document.getElementById(`brandName`).textContent = medication.brand_name ? medication.brand_name : `N.A`;
                document.getElementById(`quantity`).textContent = `${medication.quantity ? medication.quantity : `No stock`} ${medication.quantity_type ? medication.quantity_type : ``}`;
                document.getElementById(`medDosage`).textContent = medication.dosage ? medication.dosage : `N.A`;
                document.getElementById(`medForm`).textContent = medication.form ? medication.form : `N.A`;
                document.getElementById(`presDose`).textContent = `${medication.dose_amount} ${medication.dose_unit}`;
                document.getElementById(`presFrequency`).textContent = `${medication.frequency_per_day}x a day`;
                document.getElementById(`presMedExp`).textContent = `${medication.expiration_date}`;
                document.getElementById(`presDuration`).textContent = `for ${medication.duration} ${medication.duration_unit}`;
                document.getElementById(`presInstructions`).textContent = medication.instructions;
            });
            clone.querySelector(`.edit`).addEventListener(`click`, async (e) => {
                state.prescription.id = id;
                state.prescription.item = medication.id;
                document.getElementById(`editMed`).classList.add(`active`);
                document.getElementById(`editMedForm`).action = `/care/prescription/${id}/prescribed/${medication.id}/edit`;
                document.getElementById(`otherInfo`).textContent = `${medication.generic_name}(${medication.brand_name}) - ${months[createdMonth - 1]} ${createdDay}, ${createdYear}`;
                document.getElementById(`updateDoseAmount`).value = medication.dose_amount ? medication.dose_amount : `N/A`;
                document.getElementById(`updateDoseUnit`).value = medication.dose_unit ? medication.dose_unit : `N/A`;
                document.getElementById(`updateFrequencyPerDay`).value = medication.frequency_per_day ? medication.frequency_per_day : `N/A`;
                document.getElementById(`updateDuration`).value = medication.duration ? medication.duration : `N/A`;
                document.getElementById(`updateDurationUnit`).value = medication.duration_unit ? medication.duration_unit : `N/A`;
                document.getElementById(`updateValidUntil`).value = medication.valid_until ? medication.valid_until : `N/A`;
                document.getElementById(`updateInstructions`).value = medication.instructions ? medication.instructions : `N/A`;
            });
            clone.querySelector(`.deletePrescribedMed`).addEventListener(`click`, async (e) => {
                state.prescription.id = id;
                state.prescription.item = medication.id;
                e.preventDefault();
                document.getElementById(`deletePrescribedMed`).classList.add(`active`);
                document.getElementById(`deletePrescribedMedForm`).action = `/care/prescription/${id}/prescribed/${medication.id}/delete`;
                document.getElementById(`medName`).innerHTML = `${medication.generic_name} <span>(${medication.brand_name})</span>`;
                document.getElementById(`medId`).textContent = medication.id;
            });
            container.appendChild(clone);
        });
    } catch (err) {
        console.error(err);
    }
}

async function loadLogs(){
    try {
        const res = await fetch(`activities`, {
            method: 'GET'
        });

        const data = await res.json();

        if(!data.collection){
            return;
        }

        const container = document.querySelector(`#activityLogs #collection`);
        const template = document.getElementById(`logCard`);

        container.innerHTML = ``;
        data.collection.forEach(activity => {
            const clone = template.content.cloneNode(true);
            const [ month, day, year ] = new Date(activity.recorded_at).toLocaleString(`en-PH`, { timeZone: 'Asia/Manila', month: '2-digit', day: '2-digit', year: 'numeric' }).split(`/`);
            const usr_agent = activity.user_agent;
            let browser = 'UNKNOWN';
            let OS = 'UNKNOWN';
            (usr_agent.includes(`Chrome`)) ? browser = `Chrome` : (usr_agent.includes(`Firefox`)) ? browser = `Firefox` : (usr_agent.includes(`Safari`)) ? browser = `Safari` : (usr_agent.includes(`Edg`)) ? browser = `Edge` : browser;
            (usr_agent.includes(`Windows`)) ? OS = `Windows` : (usr_agent.includes(`Mac`)) ? OS = `MacOS` : (usr_agent.includes(`Linux`)) ? OS = `Linux` : (usr_agent.includes(`Android`)) ? OS = `Android` : (usr_agent.includes(`iPhone`)) ? OS = `iPhone` : OS ;
            clone.querySelector(`.ipAddress`).textContent = activity.ip_address;
            clone.querySelector(`.name`).textContent = `${activity.last_name}, ${activity.first_name} (${activity.display_name})`;
            clone.querySelector(`.action`).textContent = activity.action;
            clone.querySelector(`.agent`).textContent = `${browser} (${OS})`;
            clone.querySelector(`.date`).textContent = `${months[month - 1]} ${day}, ${year}`;
            clone.querySelector(`.details`).textContent = activity.details;
            const details = clone.querySelector(`.details`);
            clone.querySelector(`li`).addEventListener(`click`, () => {
                details.classList.toggle(`view`);
            });
            container.appendChild(clone);
        });
    } catch (err) {
        console.error(err);
    }
}

async function loadList(page, render) {
    const dashboard = document.getElementById(`dashboard`);
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

async function chart(page) {
    try {
        const res = await fetch(`/dashboard/${page}/chart`, {
            method: 'GET'
        });

        const data = await res.json();
        if(!data.ok){
            responseMessage(data, data.error);
            return;
        }
        return calculateStocks(data.collection);
    } catch (err){
        console.error(err);
    }
}

function showTab(tab, element){
    document.querySelectorAll(`.tab`).forEach(content => {
        content.style.display = `none`;
    });

    document.querySelectorAll(`.option`).forEach(opt => {
        opt.classList.remove(`selected`);
    });

    if(tab === `account`){
        document.getElementById(`accountSettings`).style.display = `flex`;
    } else if(tab === `display`){
        document.getElementById(`displaySettings`).style.display = `flex`;
    }

    element.classList.add(`selected`);
}

function passwordCheck(input, input2){
    const strength = document.getElementById(`strength`);
    const value = input.value;
    const hasUpper = /[A-Z]/.test(value);
    const hasDigit = /\d/.test(value);
    const hasSpecial = /[!@#$%^&*]/.test(value);
    const longEnough = value.length >= 6;

    if (value === "" || value.length === 0) {
        strength.classList.add(`hidden`);
        input.style.borderColor = "var(--border-color)";
        input2.style.borderColor = "var(--border-color)";
        return;
    }

    if (longEnough && hasUpper && hasDigit && hasSpecial) {
        strength.classList.remove('hidden');
        strength.textContent = "STRONG (please take note of your password to avoid forgetting)";
        strength.style.color = "var(--good)";
        input.style.borderColor = "var(--good)";
    } else if (longEnough && (hasDigit || hasUpper || hasSpecial)){
        strength.classList.remove('hidden');
        strength.textContent = "Medium (to further enhance protection must have number, uppercase, and special character)";
        strength.style.color = "var(--moderate)";
        input.style.borderColor = "var(--moderate)";
    } else if(value.length > 0) {
        strength.classList.remove('hidden');
        strength.textContent = "weak (should have number, uppercase letter, or special character)";
        strength.style.color = "var(--critical)";
        input.style.borderColor = "var(--critical)";
    }
}

document.addEventListener(`DOMContentLoaded`, function(e) {
    e.preventDefault();
    const goodColor = localStorage.getItem(`good-color`);
    const moderateColor = localStorage.getItem(`moderate-color`);
    const criticalColor = localStorage.getItem(`critical-color`);
    const accentColor = localStorage.getItem(`accent-color`);
    const accentFontColor = localStorage.getItem(`accent-font-color`);
    const font = localStorage.getItem(`font`);
    const theme = localStorage.getItem(`theme`);

    if(goodColor, moderateColor, criticalColor){
        document.documentElement.style.setProperty(`--good`, goodColor);
        document.documentElement.style.setProperty(`--moderate`, moderateColor);
        document.documentElement.style.setProperty(`--critical`, criticalColor);

        const good = document.getElementById(`goodColorPicker`);
        if(good){
            good.value = goodColor;
        };
        const moderate = document.getElementById(`moderateColorPicker`);
        if(moderate){
            moderate.value = moderateColor;
        };
        const critical = document.getElementById(`criticalColorPicker`);
        if(critical){
            critical.value = criticalColor;
        };
    }

    if(theme){
        document.documentElement.setAttribute(`data-theme`, theme);
        const btn = document.getElementById(`themeBtn`);
        if(btn){
            theme === `dark` ? btn.textContent = `Switch to Light mode` : btn.textContent = `Switch to Dark mode`;
        };
    }

    if(accentColor){
        document.documentElement.style.setProperty(`--button-color`, accentColor);
        document.documentElement.style.setProperty(`--button-hover`, accentColor);
        const colorPicker = document.getElementById(`colorPicker`);
        if(colorPicker){
            colorPicker.value = accentColor;
        };
    }

    if(accentFontColor){
        document.documentElement.style.setProperty(`--alt-font-color`, accentFontColor);
        const fontColorPicker = document.getElementById(`accentFontColorPicker`);
        if(fontColorPicker){
            fontColorPicker.value = accentFontColor;
        }
    }
    
    if(font){
        document.documentElement.style.setProperty(`--font-fam`, font);
        const fontPicker = document.getElementById(`fontPicker`);
        if(fontPicker){
            fontPicker.value = font;
        }
    }

    document.addEventListener('keydown', (event) => {
        if (event.key === "Escape"){
            closePopup();
        }
    });

    const settings = document.getElementById(`settings`);
    if(settings){
        document.getElementById(`colorPicker`).addEventListener(`input`, (e) => {
            const color = e.target.value
            document.documentElement.style.setProperty(`--button-color`, color);
            document.documentElement.style.setProperty(`--button-hover`, color);

            localStorage.setItem(`accent-color`, color);
        });

        document.getElementById(`accentFontColorPicker`).addEventListener(`input`, (e) => {
            const color = e.target.value
            document.documentElement.style.setProperty(`--alt-font-color`, color);
            localStorage.setItem(`accent-font-color`, color);
        });

        document.getElementById(`goodColorPicker`).addEventListener(`input`, (e) => {
            const color = e.target.value
            document.documentElement.style.setProperty(`--good`, color);
            localStorage.setItem(`good-color`, color);
        });

        document.getElementById(`moderateColorPicker`).addEventListener(`input`, (e) => {
            const color = e.target.value
            document.documentElement.style.setProperty(`--moderate`, color);
            localStorage.setItem(`moderate-color`, color);
        });

        document.getElementById(`criticalColorPicker`).addEventListener(`input`, (e) => {
            const color = e.target.value
            document.documentElement.style.setProperty(`--critical`, color);
            localStorage.setItem(`critical-color`, color);
        });

        document.getElementById(`fontPicker`).addEventListener(`change`, (e) => {
            const font = e.target.value;
            document.documentElement.style.setProperty(`--font-fam`, font);
            localStorage.setItem(`font`, font);
        });

        document.getElementById(`default`).addEventListener(`click`, () => {
            const DEFAULT_GOOD = `rgb(34, 139, 34)`;
            const DEFAULT_MODERATE = `rgb(221, 162, 52)`;
            const DEFAULT_CRITICAL = `rgb(178, 34, 34)`;
            const DEFAULT_ACCENT = `rgb(26, 77, 92)`;
            const DEFAULT_HOVER = `rgba(26, 77, 92, 0.8)`;
            const DEFAULT_ACCENT_FONT_COLOR = `rgb(255, 255, 255)`;
            const DEFAULT_FONT = `Arial, sans-serif`;

            document.documentElement.style.setProperty(`--good`, DEFAULT_GOOD);
            document.documentElement.style.setProperty(`--moderate`, DEFAULT_MODERATE);
            document.documentElement.style.setProperty(`--critical`, DEFAULT_CRITICAL);
            document.getElementById(`goodColorPicker`).value = DEFAULT_GOOD;
            document.getElementById(`moderateColorPicker`).value = DEFAULT_MODERATE;
            document.getElementById(`criticalColorPicker`).value = DEFAULT_CRITICAL;
            localStorage.setItem(`good-color`, DEFAULT_GOOD);
            localStorage.setItem(`moderate-color`, DEFAULT_MODERATE);
            localStorage.setItem(`critical-color`, DEFAULT_CRITICAL);

            document.documentElement.style.setProperty(`--button-color`, DEFAULT_ACCENT);
            document.documentElement.style.setProperty(`--button-hover`, DEFAULT_HOVER);
            document.getElementById(`colorPicker`).value = DEFAULT_ACCENT;
            localStorage.setItem(`accent-color`, DEFAULT_ACCENT);

            document.documentElement.style.setProperty(`--alt-font-color`, DEFAULT_ACCENT_FONT_COLOR);
            document.documentElement.style.setProperty(`--font-fam`, DEFAULT_FONT);
            document.getElementById(`fontPicker`).value = `Arial, sans-serif`;
            localStorage.setItem(`font`, DEFAULT_FONT);

            document.getElementById(`accentFontColorPicker`).value = DEFAULT_ACCENT_FONT_COLOR;
            localStorage.setItem(`accent-font-color`, DEFAULT_ACCENT_FONT_COLOR);
        });

        document.getElementById(`themeBtn`).addEventListener(`click`, () => {
            const current = document.documentElement.getAttribute(`data-theme`);
            const newTheme = current === `dark` ? `light` : `dark`;

            document.documentElement.setAttribute(`data-theme`, newTheme);
            localStorage.setItem(`theme`, newTheme);

            const btn = document.getElementById(`themeBtn`);
            newTheme === `dark` ? btn.textContent = `Switch to Light mode` : btn.textContent = `Switch to Dark mode`;
        });

        document.getElementById(`accountSettings`).style.display = `flex`;
        document.getElementById(`deleteAccountBtn`).addEventListener(`click`, () => {
            document.getElementById(`deleteAccount`).classList.add(`active`);
        });
        document.getElementById(`deleteAccountCancel`).addEventListener(`click`, () => {
            document.querySelector(`#deleteAccount`).classList.remove(`active`);
        });

        const password = document.getElementById(`currentPassword`);
        password.addEventListener(`input`, () => {
            if(password.value === ``){
                password.style.borderColor = `var(--border-color)`;
            }
        });
        const newPassword = document.getElementById(`newPassword`);
        const confirmNewPassword = document.getElementById(`confirmNewPassword`);
        newPassword.addEventListener(`input`, () => {
            passwordCheck(newPassword, confirmNewPassword);
        });

        const form = document.getElementById(`changePasswordForm`);
        form.addEventListener(`submit`, async (e) => {
            e.preventDefault();
            try {
                const res = await fetch(`/me/update/password`, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ password: password.value, newPassword: newPassword.value, confirmPassword: confirmNewPassword.value })
                });

                const data = await res.json();

                if(data.code === 400){
                    password.style.borderColor = `var(--critical)`;
                }

                if(newPassword.value !== confirmNewPassword.value || data.code === 409){
                    newPassword.style.borderColor = `var(--critical)`;
                    confirmNewPassword.style.borderColor = `var(--critical)`;
                }

                if(!data.ok){
                    return responseMessage(data, data.error);
                }

                responseMessage(data, data.message);
                password.value = ``;
                newPassword.value = ``;
                confirmNewPassword.value = ``;
            } catch(err){
                console.error(err);
            }
        });

        document.getElementById(`deleteAccountForm`).addEventListener(`submit`, async (e) => {
            try {
                const res = await fetch(`/me/delete`, {
                    method: 'DELETE'
                });

                const data = await res.json();
                if(!data.ok){
                    return responseMessage(data, data.error);
                }
            } catch (err) {
                console.error(err);
            }
        });
    }

    const notificationBtn = document.getElementById(`notifBtn`);
    if(notificationBtn){
        loadList(`notifications`, renderNotifications);
        notificationBtn.addEventListener(`click`, () => {
            document.getElementById(`notificationPanel`).classList.toggle(`open`);
            document.querySelector(`#notifBtn > .new`).classList.add(`hidden`);
        });
    }

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

        const settingsBtn = document.getElementById(`settingsBtn`);
        settingsBtn.addEventListener(`click`, () => {
            document.getElementById(`settingsPop`).classList.add(`active`);
        });

        const activityLogsBtn = document.getElementById(`activityLogsBtn`);
        activityLogsBtn.addEventListener(`click`, () => {
            document.getElementById(`activityPanel`).classList.add(`active`);
            loadLogs();
        });
    }

    const register = document.getElementById(`register`);
    if (register) {
        
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
            passwordCheck(pass, confPass);
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

                if (data.code === 401) {
                    displayName.style.borderColor = `var(--critical)`;
                } 

                if(confPass.value !== pass.value) {
                    confPass.style.borderColor = `var(--critical)`;
                    pass.style.borderColor = `var(--critical)`;
                }

                if (data.code === 400) {
                    email.style.borderColor = `var(--critical)`;
                }

                if (!data.ok) {
                    return responseMessage(data, data.error);
                }

                responseMessage(data, data.message);
                window.location.replace(`/login`);

            } catch(err){
                console.error(err);    
            }
        });

        document.getElementById(`TCBtn`).addEventListener(`click`, () => {
            document.querySelector(`.popup`).classList.add(`active`);
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
                window.location.replace(`/login`);
            } catch(err) {
                console.error(err);
            }
        });
    }

    const dashboard = document.getElementById(`dashboard`);
    if(dashboard){
        chart(`inventory`).then(stockData => {
            if(stockData){
                initChart(stockData);
            }
        });

        async function loadStatus(){
            try {
                const res = await fetch(`/dashboard/patients/status`, {
                    method: 'GET'
                });

                const data = await res.json();
                if(!data.ok){
                    return responseMessage(data, data.error);
                }

                return {
                    active: data.collection.filter( p => p.status.includes('Active')).length,
                    inactive: data.collection.filter( p => p.status.includes('Inactive')).length,
                    total: data.collection.length,
                }
            } catch (err) {
                console.error(err);
            }
        }

        loadStatus().then(p => {
            document.getElementById(`activePatients`).textContent = p.active;
            document.getElementById(`inactivePatients`).textContent = p.inactive;
            document.getElementById(`totalPatients`).textContent = p.total;
        });

        async function loadNew() {
            try {
                const res = await fetch(`/dashboard/patients/new`, {
                    method: 'GET'
                });

                const data = await res.json();
                if(!data.ok){
                    return responseMessage(false, 'Server Error Cant get new patients');
                }
            
                const container = document.getElementById(`newPatients`);
                const template = document.getElementById(`newPatientCard`);

                container.innerHTML = ``;
                data.collection.forEach(patient => {
                    const clone = template.content.cloneNode(true);
                    const [ month, day, year ] = new Date(patient.created_at).toLocaleString(`en-PH`, { timeZone: 'Asia/Manila', month: '2-digit', day: '2-digit', year: 'numeric' }).split(`/`);
                    clone.querySelector(`.patientName`).textContent = `${patient.last_name}, ${patient.first_name}`;
                    clone.querySelector(`.patientSex`).textContent = patient.sex;
                    clone.querySelector(`.addedDate`).textContent = `${months[month - 1]} ${day}, ${year}`;
                    container.appendChild(clone);
                });
            } catch(err){
                console.error(err);
            }
        } loadNew();

        (async () => {
            try {
                const res = await fetch(`/dashboard/schedule/today`, {
                    method: 'GET'
                });

                const data = await res.json();
                if(!data.ok){
                    return responseMessage(false, `Server Error: cant get todays schedules`);
                }

                const container = document.getElementById(`scheduleToday`);
                const template = document.getElementById(`todaySchedCard`);
                data.collection.forEach(schedule => {
                    const clone = template.content.cloneNode(true);
                    const timeFormat = new Date(`${schedule.date}T${schedule.time}`).toLocaleTimeString('en-PH', { hour: 'numeric', minute: '2-digit', hour12: true });
                    const [year, month, day] = schedule.date.split('-');
                    const now = new Date();
                    const [y, m, d] = schedule.date.split('-');
                    const [hh, mm, ss] = schedule.time.split(':');
                    const sched = new Date(Number(y), Number(m) - 1, Number(d), Number(hh), Number(mm), Number(ss));

                    if(sched <= now){
                        clone.querySelector(`.sched`).classList.add(`expired`);
                    }

                    clone.querySelector(`.sched`).addEventListener(`click`, () => {
                        window.location.replace(`/schedule`);
                    });
                    clone.querySelector(`.schedDate`).textContent = `${months[month - 1]} ${day}, ${year}`;
                    clone.querySelector(`.schedTime`).textContent = `${timeFormat} (${schedule.frequency})`;
                    clone.querySelector(`.clientName`).textContent = `${schedule.last_name}, ${schedule.first_name}`;
                    clone.querySelector(`.scheduledFor`).textContent = schedule.scheduled_for;
                    container.appendChild(clone);
                });
            } catch (err) {
                console.error(err);
            }
        })();

        async function lowStocks(){
            try {
                const res = await fetch(`/dashboard/inventory/low`, {
                    method: 'GET'
                });

                const data = await res.json();
                if(!data.ok){
                    return responseMessage(false, `Server Error: Can't get items`);
                }

                const container = document.getElementById(`inventoryRestock`);
                const template = document.getElementById(`lowItemCard`);
                container.innerHTML = ``;
                data.collection.forEach(item => {
                    const clone = template.content.cloneNode(true);
                    const status = clone.querySelector(`.itemStatus`);
                    const itemQuant = clone.querySelector(`.itemQuant`);
                    const [year, month, day] = item.expiration_date.split('-');
                    clone.querySelector(`.itemName`).textContent = item.name;
                    clone.querySelector(`.itemCategory`).textContent = item.category;
                    status.textContent = item.stock_status;
                    itemQuant.textContent = `Quantity: ${item.quantity} / ${item.minimum_quantity} ${item.quantity_type}`;
                    status.setAttribute(`stock-status`, item.stock_status);
                    if (item.stock_status === "Medium Stocks") {
                        status.classList.add(`moderate`);
                    } else {
                        status.classList.add(`critical`);
                    }

                    const quantities = clone.querySelector(`.quantities`);
                    status.addEventListener(`mouseenter`, () => {
                        quantities.classList.add(`up`);
                    });
                    status.addEventListener(`mouseleave`, () => {
                        quantities.classList.remove(`up`);
                    });

                    status.addEventListener(`click`, () => {
                        if(status.getAttribute(`data-showing`) === 'expiration'){
                            status.textContent = status.getAttribute(`stock-status`);
                            itemQuant.textContent = `Quantity: ${item.quantity} / ${item.minimum_quantity} ${item.quantity_type}`;
                            status.classList.remove(`good`, `moderate`, `critical`);
                            (item.stock_status === "Medium Stocks") ? status.classList.add(`moderate`) : status.classList.add(`critical`);
                            status.setAttribute(`data-showing`, `stock`);
                        } else {
                            status.textContent = item.expiration_status;
                            itemQuant.textContent = `Expiration: ${months[month - 1]} ${day}, ${year}`;
                            status.classList.remove(`good`, `moderate`, `critical`);
                            (item.expiration_status === "Good") ? status.classList.add(`good`) : (item.expiration_status === "Expiring Soon") ? status.classList.add(`moderate`) : status.classList.add(`critical`);
                            status.setAttribute(`data-showing`, `expiration`);
                        }
                    });
                    clone.querySelector(`.adjustBtn`).addEventListener(`click`, () => {
                        state.item.id = item.id;
                        document.getElementById(`adjust`).classList.add(`active`);
                        document.getElementById(`imName`).textContent = item.name;
                        document.getElementById(`imCurrentQuant`).textContent = `${item.quantity} ${item.quantity_type}`;
                    });
                    clone.querySelector(`.deleteBtn`).addEventListener(`click`, () => {
                        state.item.id = item.id;
                        document.getElementById(`deleteItem`).classList.add(`active`);
                        document.getElementById(`name`).textContent = item.name;
                        document.getElementById(`id`).textContent = item.id;
                    });

                    container.appendChild(clone);
                });
            } catch(err){
                console.error(err);
            }
        } lowStocks();

        document.getElementById(`importBtn`).addEventListener(`click`, (e) => {
            e.preventDefault();
            const valueInput = document.getElementById(`valueInput`).value;
            adjustQuantity(Number(valueInput), 'import');
            lowStocks();
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

        document.getElementById(`registerPatientBtn`).addEventListener(`click`, () => {
            document.getElementById(`registerPatient`).classList.add(`active`);
        });

        document.getElementById(`registerPatientForm`).addEventListener(`submit`, async (e) => {
            e.preventDefault();
            const formdata = new FormData(e.target);
            try {
                const res = await fetch('/patients/register', {
                    method:'POST',
                    body: formdata
                });

                const data = await res.json();
                if(!data.ok){
                    return responseMessage(data, data.error);
                }

                responseMessage(data, data.message);
                registerPatient.classList.remove('active');
                loadNew();
                loadStatus().then(p => {
                    document.getElementById(`activePatients`).textContent = p.active;
                    document.getElementById(`totalPatients`).textContent = p.total;
                });
            } catch (err) {
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

                loadPatientDiagnosis(state.patient.id);
                document.getElementById(`conditionName`).value = ``;
            } catch (err) {
                console.error(err);
            }
        });

        let timeout;
        document.getElementById(`medicineName`).addEventListener(`click`, (e) => {
            document.getElementById(`medicineOptn`).classList.toggle(`active`);
            loadList(`medicines`, renderMedsDrop);
        });

        document.getElementById(`medicineName`).addEventListener(`input`, (e) => {
            e.preventDefault();
            const input = document.getElementById(`medicineName`);
            clearTimeout(timeout);
            if(input.value === ``){
                document.getElementById(`medicineOptn`).classList.remove(`active`);
            } else {
                document.getElementById(`medicineOptn`).classList.add(`active`);
            }

            timeout = setTimeout(() => {
                dropdown(`care/medicine`, renderMedsDrop, input.value);
            }, 300);
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

                loadPatientPrescriptions(state.patient.id);
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
                loadPatientPrescriptions(state.patient.id);
                document.getElementById(`deletePrescription`).classList.remove(`active`);
            } catch(err){
                console.error(err);
            }
        });

        document.getElementById(`deletePrescribedMedForm`).addEventListener(`submit`, async (e) => {
            e.preventDefault();
            try{
                const res = await fetch(`/care/prescription/${state.prescription.id}/prescribed/${state.prescription.item}/delete`, {
                    method: 'DELETE'
                });

                const data = await res.json();
                if(!data.ok){
                    responseMessage(data, data.error);
                    return;
                }
                loadPatientPrescriptions(state.patient.id);
                document.getElementById(`deletePrescribedMed`).classList.remove(`active`);
            } catch(err){
                console.error(err);
            }
        });

        document.getElementById(`prescribeMedForm`).addEventListener(`submit`, async (e) => {
            e.preventDefault();
            const medName = document.getElementById(`medicineName`);
            const doseAmount = document.getElementById(`doseAmount`);
            const doseUnit = document.getElementById(`doseUnit`);
            const frequencyPerDay = document.getElementById(`frequencyPerDay`);
            const duration = document.getElementById(`duration`);
            const durationUnit = document.getElementById(`durationUnit`);
            const validUntil = document.getElementById(`validUntil`);
            const instructions = document.getElementById(`instructions`);
            try{
                const formdata = new FormData(e.target);
                const res = await fetch(`/care/prescribe/${state.prescription.id}`, {
                    method: 'POST',
                    body: formdata
                });

                const data = await res.json();
                if(!data.ok){
                    responseMessage(data, data.error);
                }

                loadPatientPrescriptions(state.patient.id);
                responseMessage(data, data.message);
                document.getElementById(`prescribeMed`).classList.remove(`active`);
                medName.value = ``;
                doseAmount.value = ``;
                doseUnit.value = ``;
                frequencyPerDay.value = ``;
                duration.value = ``;
                durationUnit.value = ``;
                validUntil.value = ``;
                instructions.value = ``;
            } catch(err){
                console.error(err);
            }
        });

        document.getElementById(`editMedForm`).addEventListener(`submit`, async (e) => {
            e.preventDefault();
            try {
                const updateDoseAmount = document.getElementById(`updateDoseAmount`);
                const updateDoseUnit = document.getElementById(`updateDoseUnit`);
                const updateFrequencyPerDay = document.getElementById(`updateFrequencyPerDay`);
                const updateDuration = document.getElementById(`updateDuration`);
                const updateDurationUnit = document.getElementById(`updateDurationUnit`);
                const updateValidUntil = document.getElementById(`updateValidUntil`);
                const updateInstructions = document.getElementById(`updateInstructions`);
                const res = await fetch(`/care/prescription/${state.prescription.id}/prescribed/${state.prescription.item}/edit`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ doseAmount: updateDoseAmount.value, doseUnit: updateDoseUnit.value, frequencyPerDay: updateFrequencyPerDay.value, duration: updateDuration.value, durationUnit: updateDurationUnit.value, validUntil: updateValidUntil.value, instructions: updateInstructions.value })
                });

                const data = await res.json();
                if(!data.ok){
                    responseMessage(data, data.error);
                    return;
                }

                responseMessage(data, data.message);
                loadPatientPrescriptions(state.patient.id);
                document.getElementById(`editMed`).classList.remove(`active`);
            } catch (err){
                console.error(err);
            }
        });

        document.getElementById(`setSchedForm`).addEventListener(`submit`, async (e) => {
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
            } catch(err) {
                console.error(err);
            }
        });

        const symptomsInput = document.getElementById(`symptomsInput`);
        symptomsInput.addEventListener(`click`, () => {
            document.getElementById(`results`).classList.toggle(`active`);
        });
        symptomsInput.addEventListener(`input`, () => {
            clearTimeout(timeout);

            if(symptomsInput.value === ``){
                document.getElementById(`results`).classList.remove(`active`);
            } else {
                document.getElementById(`results`).classList.add(`active`);
            }

            timeout = setTimeout(async () => {
                try {
                    const res = await fetch(`/care/condition?symptoms=${symptomsInput.value}`, {
                        method: 'GET'
                    });

                    const data = await res.json();
                    if(!data.ok){
                        return;
                    }

                    const container = document.getElementById(`results`);
                    const template = document.getElementById(`possibleConditionCard`);
                    container.innerHTML = ``;
                    data.collection.results.forEach(result => {
                        const clone = template.content.cloneNode(true);
                        clone.querySelector(`li`).addEventListener(`click`, () => {
                            document.getElementById(`conditionName`).value = result.condition;
                        });
                        clone.querySelector(`.condition`).textContent = result.condition;
                        clone.querySelector(`.confidence`).textContent = `${result.confidence}%  (${result.confidenceLevel})`;
                        clone.querySelector(`.description`).textContent = result.description;
                        result.medications.forEach(suggestedMed => {
                            const medicinesCollections = clone.querySelector(`.medications`);
                            const h4 = document.createElement(`h4`);
                            h4.textContent = suggestedMed.name;
                            medicinesCollections.appendChild(h4);
                        });
                        container.appendChild(clone);
                    });
                    if(data.collection.emergency.detected){
                        const emergency = data.collection.emergency.data;
                        const clone = template.content.cloneNode(true);
                        clone.querySelector(`li`).addEventListener(`click`, () => {
                            document.getElementById(`conditionName`).value = emergency.name;
                            document.getElementById(`results`).classList.remove(`active`);
                        });
                        clone.querySelector(`.condition`).textContent = emergency.name;
                        clone.querySelector(`.confidence`).textContent = emergency.urgency;
                        clone.querySelector(`.description`).textContent = emergency.message;
                        container.appendChild(clone);
                    }
                } catch(err){
                    console.error(err);
                }
            }, 300);
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
            const formdata = new FormData(e.target);
            try {
                const res = await fetch(`/patients/${state.patient.id}/edit`, {
                    method:'POST',
                    body: formdata
                });

                const data = await res.json();
                if(!data.ok){
                    responseMessage(data, data.error);
                    return;
                }

                responseMessage(data, data.message);
                editPanel.classList.remove('active');
                loadList(`patients`, renderPatientsData);
            } catch (err) {
                console.error(err);
            }
        });

        const registerPatientForm = document.getElementById(`registerPatientForm`);
        registerPatientForm.addEventListener(`submit`, async (e) => {
            e.preventDefault();
            const firstName = document.getElementById(`firstName`);
            const lastName = document.getElementById(`lastName`);
            const birthdate = document.getElementById(`birthdate`);
            const sex = document.getElementById(`sex`);
            const address = document.getElementById(`address`);
            const contact = document.getElementById(`contact`);
            const exContact = document.getElementById(`exContact`);
            const referredBy = document.getElementById(`referredBy`);
            const status = document.getElementById(`status`);

            const formdata = new FormData(e.target);
            try {
                const res = await fetch('/patients/register', {
                    method:'POST',
                    body: formdata
                });

                const data = await res.json();
                if(!data.ok){
                    return responseMessage(data, data.error);
                }

                responseMessage(data, data.message);
                registerPatient.classList.remove('active');
                loadList('patients', renderPatientsData);
                firstName.value = ``;
                lastName.value = ``;
                birthdate.value = ``;
                sex.value = ``;
                address.value = ``;
                contact.value = ``;
                exContact.value = ``;
                referredBy.value = ``;
                status.value = ``;
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
            const dosage = document.getElementById(`updateDosage`).value;
            const form = document.getElementById(`updateForm`).value;

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
            genericName = ``;
            brandName = ``;
            dosage = ``;
            form = ``;
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
        findPatient.addEventListener(`click`, (e) => {
            const patientOptn = document.getElementById(`patientOption`); 
            patientOptn.classList.toggle(`active`);
            loadList(`patients`, renderPatientsDrop);
        });

        findPatient.addEventListener(`input`, (e) => {
            e.preventDefault();
            clearTimeout(timeout);
            timeout = setTimeout(() => {
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
                occupiedDate = [];
                loadList(`schedule`, renderSchedulesData);
            } catch(err) {
                console.error(err);
            }
        });

        document.getElementById(`editSched`).addEventListener(`submit`, async (e) => {
            e.preventDefault();
            const updateSchedFor = document.getElementById(`updateSchedFor`).value;
            const updateTime = document.getElementById(`updateTime`).value;
            const updateFrequency = document.getElementById(`updateFrequency`).value;
            try {
                const res = await fetch(`/schedule/edit`, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ id: state.schedule.id, schedFor: updateSchedFor, time: updateTime, frequency: updateFrequency })
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
                occupiedDate = [];
                loadList(`schedule`, renderSchedulesData);
                document.getElementById(`deleteSched`).classList.remove(`active`);
            } catch(err) {
                console.error(err);
            }
        });
    }

    const me = document.getElementById(`me`);
    if(me){
        const avatarUpload = document.querySelector(`.avatarUpload`);
        document.querySelector(`.profile`).addEventListener(`mouseenter`, () => {
            avatarUpload.classList.add(`show`);
        });
        document.querySelector(`.profile`).addEventListener(`mouseleave`, () => {
            avatarUpload.classList.remove(`show`);
        });

        document.querySelector(`input[name="avatar"]`).onchange = function (e) {
            const file = e.target.files[0];
            const img = document.querySelector(`.profile img`);

            document.querySelector(`.save`).classList.remove(`hidden`);
            img.src = URL.createObjectURL(file);
        };

        document.querySelector(`.save`).addEventListener(`click`, async (e) => {
            e.preventDefault();
            try {
                const form = document.getElementById(`avatarUploadForm`);
                const formdata = new FormData(form);
                const res = await fetch(`/me/update/avatar`, {
                    method: 'POST',
                    body: formdata
                });

                const data = await res.json();
                if(!data.ok){
                    return responseMessage(data, data.error);
                }
                responseMessage(data, data.message);
            } catch(err) {
                console.error(err);
            }
        });

        document.getElementById(`editInfoBtn`).addEventListener(`click`, () => {
            document.getElementById(`displayName`).classList.add(`hidden`);
            document.getElementById(`editInfoForm`).classList.remove(`hidden`);
        });

        document.getElementById(`cancelUpdateBtn`).addEventListener(`click`, () => {
            document.getElementById(`displayName`).classList.remove(`hidden`);
            document.getElementById(`editInfoForm`).classList.add(`hidden`);
        });

        document.getElementById(`verifyBtn`).addEventListener(`click`, () => {
            document.getElementById(`verify`).classList.add(`active`);
        });

        document.getElementById(`resendCode`).addEventListener(`click`, async (e) => {
            e.preventDefault();
            try {
                const res = await fetch(`/me/verification/resend`, {
                    method: 'GET'
                });

                const data = await res.json();
                if(!data.ok){
                    return responseMessage(data, data.error);
                }

                responseMessage(data, data.message);
            } catch(err){
                console.error(err);
            }
        });
        document.getElementById(`verifyForm`).addEventListener(`submit`, async (e) => {
            e.preventDefault();
            const code = document.getElementById(`code`);
            try {
                const res = await fetch(`/me/verify`, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ code: code.value })
                });

                const data = await res.json();
                if(!data.ok){
                    return responseMessage(data, data.error);
                }

                responseMessage(data, data.message);
                document.getElementById(`verify`).classList.remove(`active`);
                location.reload();
            } catch(err) {
                console.error(err);
            }
        });

        const requestAccessBtn = document.getElementById(`requestAccess`);
        requestAccessBtn.addEventListener(`click`, async (e) => {
            e.preventDefault();
            try {
                const res = await fetch(`/me/requestAccess`, {
                    method: 'PATCH'
                });

                const data = await res.json();

                if(!data.ok){
                    return responseMessage(data, data.error);
                }

                location.reload();
            } catch(err) {
                console.error(err);
            }
        });

        document.getElementById(`editInfoForm`).addEventListener(`submit`, async (e) => {
            e.preventDefault();
            try{
                const formdata = new FormData(e.target);
                const res = await fetch(`/me/update`, {
                    method: 'POST',
                    body: formdata
                });

                const data = await res.json();
                if(!data.ok){
                    return responseMessage(data, data.error);
                } else {
                    location.reload();
                }
            } catch(err){
                console.error(err);
            }
        });

        async function loadRequests (){
            try {
                const res = await fetch(`/me/requests`, {
                    method: 'GET'
                });

                const data = await res.json();
                if(!data.collection){
                    return;
                }
                const container = document.getElementById(`collection`);
                const template = document.getElementById(`requesterCard`);
                container.innerHTML = ``;
                data.collection.forEach(requester => {
                    const clone = template.content.cloneNode(true);

                    clone.querySelector(`.name`).textContent = `${requester.last_name}, ${requester.first_name}`;
                    clone.querySelector(`.position`).textContent = requester.position;
                    clone.querySelector(`.accept`).addEventListener(`click`, async (e) => {
                        e.preventDefault();
                        try {
                            const res = await fetch(`/me/${requester.id}/accept`, {
                                method: 'PATCH'
                            });

                            const data = await res.json();
                            if(!data.ok){
                                return responseMessage(data, data.error);
                            }

                            responseMessage(data, data.message);
                            loadRequests();
                            loadEditor();
                        } catch(err) {
                            console.error(err);
                        }
                    });

                    clone.querySelector(`.decline`).addEventListener(`click`, async(e) => {
                        e.preventDefault();
                        try {
                            const res = await fetch(`/me/${requester.id}/decline`, {
                                method: 'PATCH'
                            });

                            const data = await res.json();
                            if(!data.ok){
                                return responseMessage(data, data.error);
                            }

                            responseMessage(true, `Successfully declined the request`);
                            loadRequests();
                        } catch(err) {
                            console.error(err);
                        }
                    });
                    container.appendChild(clone);
                });
            } catch (err) {
                console.error(err);
            }
        } 

        async function loadEditor(){
            try {
                const res = await fetch(`/me/editors`, {
                    method: 'GET'
                });

                const data = await res.json();

                const container = document.getElementById(`editorCollection`);
                const template = document.getElementById(`editorCard`);
                container.innerHTML = ``;
                if(!data.collection){
                    return;
                }
                data.collection.forEach(editor => {
                    const clone = template.content.cloneNode(true);

                    clone.querySelector(`.name`).textContent = `${editor.last_name}, ${editor.first_name}`;
                    clone.querySelector(`.position`).textContent = editor.position;
                    clone.querySelector(`.remove`).addEventListener(`click`, () => {
                        state.editor.id = editor.id;
                        document.getElementById(`removeAccessForm`).action = `/me/${editor.id}/remove`;
                        document.getElementById(`removeAccess`).classList.add(`active`);
                        document.getElementById(`editorName`).textContent = `${editor.last_name}, ${editor.first_name}`; 
                        document.getElementById(`editorId`).textContent = editor.id;
                    });
                    container.appendChild(clone);
                });
            } catch(err) {
                console.error(err);
            }
        }

        const editor = document.getElementById(`editorPanel`);
        if(editor) {
            loadRequests();
            loadEditor();

            document.getElementById(`removeAccessForm`).addEventListener(`submit`, async (e) => {
                e.preventDefault();
                try {
                    const res = await fetch(`/me/${state.editor.id}/remove`, {
                        method: 'PATCH'
                    });

                    const data = await res.json();
                    if(!data.ok){
                        return responseMessage(data, data.error);
                    }

                    document.getElementById(`removeAccess`).classList.remove(`active`);
                    loadEditor();
                    loadRequests();
                } catch(err){
                    console.error(err);
                }
            });
        } 

    }

    const activityLogs = document.getElementById(`activityLogs`);
    if(activityLogs) {
        document.getElementById(`deleteAll`).addEventListener(`click`, async (e) => {
            e.preventDefault();
            try{
                const res = await fetch(`/activities/delete`, {
                    method: 'DELETE'
                });

                const data = await res.json();
                if(!data.ok){
                    return responseMessage(data, data.error);
                }

                responseMessage(data, data.message);
                loadLogs();
            } catch(err){
                console.error(err);
            }
        });
    }
})
