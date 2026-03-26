<section id="registerPatient" class="popup">
    <form action="/addPatient" method="post">
        <h3 class="ctr-text">Patient Registration Form</h3>
        <span class="p-sm">
            <input name="firstName" type="text" required>
            <label for="firstName">First Name</label>
        </span>
        <span class="p-sm">
            <input name="lastName" type="text" required>
            <label for="lastName">Last Name</label>
        </span>
        <div class="part p-sm">
            <span>
                <input name="birthdate" type="date" required>
                <label for="birthdate">Birthdate</label>
            </span>
            <span>
                <select name="sex" id="sex" required>
                    <option value="" hidden></option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                </select>
                <label for="sex">Sex</label>
            </span>
        </div>
        <span class="p-sm">
            <input name="address" type="text" required>
            <label for="address">Address</label>
        </span>
        <div class="part p-sm">
            <span>
                <input name="contact" type="text" required>
                <label for="contact">Contact</label>
            </span>
            <span>
                <input name="exContact" type="text" placeholder="N/A" required>
                <label for="exContact">Contact#2(optional)</label>
            </span>
        </div>
        <span class="p-sm">
            <input name="referredBy" type="text" placeholder="N/A" required>
            <label for="referredBy">Referred by</label>
        </span>
        <div class="p-sm">
            <button type="submit">Submit</button>
            <button id="cancelPatientRegistration" type="reset">Cancel</button>
        </div>
    </form>
</section>