<section id="deletePatient" class="popup">
    <form id="deletePatientForm" class="form-ui" action="/patients/delete" method="post">
        <header><h4>Delete Patient</h4></header>
        <hr>
        <p>Are you sure that you want to delete patient: </p>
        <div>
            <button type="submit">Delete</button>
            <button id="closeDelete" class="btn-highlight" type="button">Cancel</button>
        </div>
    </form>
</section>