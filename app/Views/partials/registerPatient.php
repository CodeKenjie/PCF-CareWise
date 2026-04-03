<section id="registerPatient" class="popup">
    <form id="registerPatientForm" action="/patients/register" method="post">
        <div>
            <span class="profile">
                <img src="assets/images/profile.png" alt="">
            </span>
            <input id="avatar" type="file" accept="image/*" hidden>
            <label for="avatar">
                <svg viewBox="0 0 32 32" class="svg sm-icon" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g fill="none" fill-rule="evenodd"> <path d="m0 0h32v32h-32z"></path> <path d="m24 2c4.418278 0 8 3.581722 8 8v12c0 4.418278-3.581722 8-8 8h-16c-4.418278 0-8-3.581722-8-8v-12c0-4.418278 3.581722-8 8-8zm-15.15704017 11.3933983-6.84295983 6.8426017v1.764c0 3.2383969 2.56557489 5.8775718 5.77506174 5.9958615l.22493826.0041385h15.45zm21.15704017-1.8643983-10.096 10.097 6.048224 6.0492469c2.2878684-.7868384 3.9503124-2.9181728 4.0436375-5.4503086l.0041385-.2249383zm-6-7.529h-16c-3.23839694 0-5.87757176 2.56557489-5.99586153 5.77506174l-.00413847.22493826v7.407l5.42874627-5.4278153c.74554637-.7455464 1.93326028-.7794348 2.71900373-.1016654l.1094234.1016654 8.2318266 8.2318153 11.3946671-11.39268045c-.5346164-2.67667729-2.8501212-4.71066623-5.6587288-4.81418108zm-5.4 2c2.209139 0 4 1.790861 4 4s-1.790861 4-4 4-4-1.790861-4-4 1.790861-4 4-4zm0 2c-1.1045695 0-2 .8954305-2 2s.8954305 2 2 2 2-.8954305 2-2-.8954305-2-2-2z" fill="currentColor" fill-rule="nonzero"></path> </g> </g></svg>
            </label>
        </div>
        <span class="p-sm">
            <input id="firstName" name="firstName" type="text" required>
            <label for="firstName">First Name</label>
        </span>
        <span class="p-sm">
            <input id="lastName" name="lastName" type="text" required>
            <label for="lastName">Last Name</label>
        </span>
        <div class="part p-sm">
            <span>
                <input id="birthdate" name="birthdate" type="date" required>
                <label for="birthdate">Birthdate</label>
            </span>
            <span>
                <select id="sex" name="sex" id="sex" required>
                    <option value="" hidden></option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                </select>
                <label for="sex">Sex</label>
            </span>
        </div>
        <span class="p-sm">
            <input id="address" name="address" type="text" required>
            <label for="address">Address</label>
        </span>
        <div class="part p-sm">
            <span>
                <input id="contact" name="contact" type="text" maxlength="11" required>
                <label for="contact">Contact</label>
            </span>
            <span>
                <input id="exContact" name="exContact" type="text" placeholder="N/A" required>
                <label for="exContact">Contact#2(N/A)</label>
            </span>
        </div>
        <span class="p-sm">
            <input id="referredBy" name="referredBy" type="text" placeholder="N/A" required>
            <label for="referredBy">Referred by</label>
        </span>
        <div class="part p-sm">
            <button type="submit">Submit</button>
            <button id="cancelPatientRegistration" type="reset">Cancel</button>
        </div>
    </form>
</section>