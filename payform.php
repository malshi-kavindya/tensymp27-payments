<?php require __DIR__ . '/config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= CONFERENCE_SHORT ?> Registration | Manual Payment</title>
    <link rel="icon" href="<?= CONFERENCE_FAVICON ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.min.js"></script>
</head>
<body>
<div class="container pb-2">

    <nav class="app-nav">
        <div class="app-nav-brand">
            <img src="<?= CONFERENCE_LOGO ?>" alt="<?= CONFERENCE_SHORT ?> Logo" class="app-nav-logo">
            <div>
                <div class="brand-name"><?= CONFERENCE_SHORT ?></div>
                <div class="brand-sub">Manual Payment Registration</div>
            </div>
        </div>
        <a href="index.php" class="btn btn-modern btn-ghost btn-sm"><i class="bi bi-arrow-left"></i> Back to Home</a>
    </nav>

    <div class="mt-4 mb-4">
        <h1 class="section-title mb-1">Registration & Manual Payment</h1>
        <p class="section-sub mb-0">
            Complete your details below — your charges are calculated instantly in the summary panel.
            After submission you'll receive a PDF with the bank account and payment particulars.
        </p>
    </div>

    <form id="FrmHtmlCheckout" name="FrmHtmlCheckout">
        <div class="row g-4">
            <div class="col-lg-7">

                <div class="card section-card">
                    <div class="section-header">
                        <div class="section-number">1</div>
                        <div>
                            <h5>Recipient Information</h5>
                            <p>Your contact and registration details</p>
                        </div>
                    </div>
                    <div class="card-body row g-3">
                        <div class="col-md-6">
                            <label for="email">Email Address</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email Address" required>
                        </div>
                        <div class="col-md-6">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter Recipient Name" required>
                        </div>
                        <div class="col-md-6">
                            <label for="category">Registration Category</label>
                            <select class="form-select" id="category" name="registration_category" onchange="toggleCategory(); updateCharge();" required>
                                <option value="">--- Select Registration Category ---</option>
                                <optgroup label="Author Registration (papers presented)">
                                    <option value="author_ieee">Author - IEEE Member</option>
                                    <option value="author_non">Author - IEEE Non-Member</option>
                                </optgroup>
                                <optgroup label="Student Registration (presenting a paper)">
                                    <option value="student_ieee">Student - IEEE Student Member</option>
                                    <option value="student_non">Student - IEEE Non-Member Student</option>
                                </optgroup>
                                <optgroup label="General Attendee">
                                    <option value="attendee_ieee">General Attendee - IEEE Member</option>
                                    <option value="attendee_non">General Attendee - IEEE Non-Member</option>
                                </optgroup>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="registration">Registration Timing</label>
                            <select class="form-select" id="registration" name="registration_type" onchange="updateCharge()">
                                <option value="Early Bird">Early Bird</option>
                                <option value="Regular">Regular</option>
                            </select>
                            <small class="form-hint">Early Bird rates apply until 15 March 2027</small>
                        </div>
                        <div class="col-md-6" id="membership_no_field" style="display: none;">
                            <label for="membership_number">IEEE Membership Number <span class="text-muted fw-normal">(valid active membership required)</span></label>
                            <input type="text" class="form-control" id="membership_number" name="ieee_member_id" placeholder="Enter Your IEEE Membership Number">
                        </div>
                    </div>
                </div>

                <div class="card section-card" id="paper_details_card" style="display: none;">
                    <div class="section-header">
                        <div class="section-number">2</div>
                        <div>
                            <h5>Paper Details</h5>
                            <p>Link your submitted paper to this registration</p>
                        </div>
                    </div>
                    <div class="card-body row g-3">
                        <div class="col-md-6">
                            <label for="paper_id">Paper ID</label>
                            <input type="text" class="form-control" id="paper_id" name="paper_id" placeholder="Enter TENSYMP Paper ID">
                        </div>
                        <div class="col-md-6">
                            <label for="paper_title">Paper Title</label>
                            <input type="text" class="form-control" id="paper_title" name="paper_title" placeholder="Paper title appears here" readonly>
                        </div>
                    </div>
                </div>

                <div class="card section-card">
                    <div class="section-header">
                        <div class="section-number">3</div>
                        <div>
                            <h5>Additional Options</h5>
                            <p>Optional add-ons for your conference experience</p>
                        </div>
                    </div>
                    <div class="card-body row g-3 align-items-center">
                        <div class="col-md-7">
                            <label class="form-check custom-check mb-0">
                                <input type="checkbox" class="form-check-input" id="dinner" name="dinner" value="1" onchange="toggleDinnerCount()">
                                <span>
                                    <span class="form-check-label">Additional Networking Functions (Gala Dinner) Ticket</span>
                                    <span class="d-block form-hint mb-0">USD <?= DINNER_FEE_USD ?> per person — for registrations that do not already include social functions.</span>
                                </span>
                            </label>
                        </div>
                        <div class="col-md-5" id="dinner_count_field" style="display: none;">
                            <label for="dinner_count">Number of Tickets</label>
                            <input type="number" class="form-control" id="dinner_count" name="dinner_count" min="1" value="1" onchange="updateCharge()">
                        </div>
                    </div>
                </div>

                <div class="d-none">
                    <input type="hidden" name="participation_type" id="participation_type" value="">
                    <input type="hidden" name="ieee_member" id="ieee_member" value="">
                    <input type="hidden" name="participation_mode" value="Physical">
                    <input type="hidden" name="currency_type" id="currency_type" value="USD">
                    <label for="amount">Amount (USD)</label>
                    <input type="number" class="form-control" id="amount" name="amount" value="0.00" readonly>
                    <label for="totalamount">Total Amount (LKR)</label>
                    <input type="text" class="form-control" id="totalamount" name="totalamount" value="0.00" readonly>
                </div>

            </div>

            <div class="col-lg-5">
                <aside class="summary-card sticky-top" style="top: 20px;">
                    <div class="summary-head">
                        <i class="bi bi-receipt-cutoff" style="font-size: 1.4rem; color: #FFD966;"></i>
                        <h5>Payment Summary</h5>
                    </div>

                    <div class="summary-row">
                        <span class="label">Category</span>
                        <span class="value" id="sumCategory">—</span>
                    </div>
                    <div class="summary-row">
                        <span class="label">Registration Type</span>
                        <span class="value" id="sumType">—</span>
                    </div>
                    <div class="summary-row">
                        <span class="label">Timing</span>
                        <span class="value" id="sumTiming">—</span>
                    </div>
                    <div class="summary-row">
                        <span class="label">Registration Fee</span>
                        <span class="value" id="sumAmount">—</span>
                    </div>
                    <div class="summary-row" id="sumDinnerRow" style="display: none;">
                        <span class="label">Gala Dinner</span>
                        <span class="value" id="sumDinner">—</span>
                    </div>

                    <div class="summary-row total">
                        <span class="label">Total (USD)</span>
                        <span class="value" id="sumTotal">—</span>
                    </div>
                    <div class="summary-row">
                        <span class="label">Approx. Total (LKR)</span>
                        <span class="value" id="sumLkr">—</span>
                    </div>

                    <p class="summary-note">
                        LKR total is approximated using the live USD exchange rate. Final amount is
                        confirmed in the PDF you receive after submission.
                    </p>

                    <button type="submit" name="submit" class="btn btn-modern btn-blue w-100 mt-2">
                        Submit Payment <i class="bi bi-send"></i>
                    </button>
                </aside>
            </div>
        </div>
    </form>

</div>

<footer class="app-footer">
    © IEEE Sri Lanka Section • <strong><?= CONFERENCE_NAME ?></strong> • All rights reserved
</footer>

<script>
const REGISTRATION_FEES = <?= REGISTRATION_FEES_JSON ?>;
const DINNER_FEE_USD = <?= DINNER_FEE_USD ?>;
const EARLY_BIRD_CUTOFF = <?= json_encode(EARLY_BIRD_CUTOFF) ?>;

let lkrRate = 0;

function setRegistrationTiming() {
    const today = new Date();
    const earlyBirdEnd = new Date(EARLY_BIRD_CUTOFF + "T23:59:59");
    const select = document.getElementById("registration");

    if (today <= earlyBirdEnd) {
        select.value = "Early Bird";
        select.querySelector('option[value="Early Bird"]').disabled = false;
        select.querySelector('option[value="Regular"]').disabled = true;
    } else {
        select.value = "Regular";
        select.querySelector('option[value="Early Bird"]').disabled = true;
        select.querySelector('option[value="Regular"]').disabled = false;
    }
}
setRegistrationTiming();

function toggleCategory() {
    const category = document.getElementById("category").value;
    const fee = REGISTRATION_FEES[category];

    const membershipField = document.getElementById("membership_no_field");
    const paperCard = document.getElementById("paper_details_card");

    document.getElementById("participation_type").value = fee ? fee.participation_type : "";
    document.getElementById("ieee_member").value = fee && fee.ieee_member ? "IEEE Member" : "";

    if (!fee) {
        membershipField.style.display = "none";
        paperCard.style.display = "none";
        document.getElementById("membership_number").value = "";
        document.getElementById("paper_id").value = "";
        document.getElementById("paper_title").value = "";
        return;
    }

    membershipField.style.display = fee.ieee_member ? "block" : "none";
    paperCard.style.display = (fee.participation_type === "Author" || fee.participation_type === "Student") ? "block" : "none";

    if (!fee.ieee_member) {
        document.getElementById("membership_number").value = "";
    }
}

function toggleDinnerCount() {
    const checked = document.getElementById("dinner").checked;
    const countField = document.getElementById("dinner_count_field");
    const countInput = document.getElementById("dinner_count");

    if (checked) {
        countField.style.display = "block";
        countInput.disabled = false;
        countInput.value = 1;
    } else {
        countField.style.display = "none";
        countInput.disabled = true;
    }
    updateCharge();
}

function baseAmountUsd() {
    const category = document.getElementById("category").value;
    const fee = REGISTRATION_FEES[category];
    if (!fee) return 0;

    const timing = document.getElementById("registration").value;
    const key = timing === "Early Bird" ? "early_bird" : "regular";
    return fee[key] || 0;
}

function dinnerAmountUsd() {
    const checked = document.getElementById("dinner").checked;
    if (!checked) return 0;
    const count = parseInt(document.getElementById("dinner_count").value) || 1;
    return DINNER_FEE_USD * count;
}

function updateCharge() {
    const totalUsd = baseAmountUsd() + dinnerAmountUsd();
    document.getElementById("amount").value = totalUsd ? totalUsd : "";

    if (totalUsd > 0 && lkrRate > 0) {
        document.getElementById("totalamount").value = (totalUsd * lkrRate).toFixed(2);
    } else {
        document.getElementById("totalamount").value = "";
    }
    updateSummary();
}

function money(usd) {
    return usd ? 'US$ ' + usd.toLocaleString(undefined, { maximumFractionDigits: 0 }) : '—';
}

function updateSummary() {
    const cat = document.getElementById("category");
    const fee = cat.value ? REGISTRATION_FEES[cat.value] : null;

    document.getElementById("sumCategory").textContent = fee ? fee.participation_type : '—';
    document.getElementById("sumType").textContent = fee ? fee.member_type : '—';
    document.getElementById("sumTiming").textContent = document.getElementById("registration").value + ' Rate';

    const base = baseAmountUsd();
    const din = dinnerAmountUsd();
    const total = base + din;

    document.getElementById("sumAmount").textContent = money(base);

    const dinnerRow = document.getElementById("sumDinnerRow");
    if (din > 0) {
        dinnerRow.style.display = "flex";
        document.getElementById("sumDinner").textContent = money(din);
    } else {
        dinnerRow.style.display = "none";
    }

    document.getElementById("sumTotal").textContent = money(total);

    const lkr = document.getElementById("totalamount").value;
    document.getElementById("sumLkr").textContent = lkr
        ? 'LKR ' + parseFloat(lkr).toLocaleString(undefined, { minimumFractionDigits: 2 })
        : '—';
}

function loadLKR() {
    fetch("https://api.exchangerate-api.com/v4/latest/USD")
        .then(res => res.json())
        .then(res => {
            lkrRate = res.rates["LKR"] || 0;
            updateCharge();
        })
        .catch(() => {
            lkrRate = 0;
            updateCharge();
        });
}
loadLKR();

document.getElementById('paper_id').addEventListener('blur', function() {
    const paperId = this.value.trim();
    const titleField = document.getElementById('paper_title');

    if (paperId === '') return;

    titleField.value = 'Checking...';

    fetch('<?= API_BASE_URL ?>/api/papers/' + encodeURIComponent(paperId))
        .then(response => response.json())
        .then(data => {
            if (data && data.title) {
                titleField.value = data.title;
            } else {
                titleField.value = '';
                titleField.placeholder = 'Not found';
                alert('Invalid Paper ID');
            }
        })
        .catch(err => {
            titleField.value = '';
            titleField.placeholder = 'Error fetching title';
            console.error(err);
        });
});

document.getElementById('membership_number').addEventListener('blur', function() {
    const memberId = this.value.trim();

    if (memberId === '') return;

    this.classList.remove('is-invalid');
    this.classList.remove('is-valid');

    fetch('<?= API_BASE_URL ?>/api/ieee/' + encodeURIComponent(memberId))
        .then(response => response.json())
        .then(data => {
            if (data.success && data.message === 'Valid Member') {
                this.classList.add('is-valid');
            } else {
                alert(data.message);
                resetIEEEForm();
            }
        })
        .catch(err => {
            console.error(err);
            alert('Error validating IEEE Membership!');
            resetIEEEForm();
        });
});

function resetIEEEForm() {
    const membershipInput = document.getElementById('membership_number');
    membershipInput.value = '';
    membershipInput.classList.add('is-invalid');
}

document.getElementById('FrmHtmlCheckout').addEventListener('submit', function(e){
    e.preventDefault();
    let formData = new FormData(this);

    fetch('backend.php', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {

        if (data.error) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: data.error,
            });
            return;
        }

        if (data.pdf_url) {
            window.open(data.pdf_url, '_blank');
        }

        window.location.href = 'index.php';
    })
    .catch(err => {
        Swal.fire({
            icon: 'error',
            title: "Submission Failed",
            text: "Please review the form and fill in all required fields."
        });
        console.error(err);
    });
});
</script>

</body>
</html>