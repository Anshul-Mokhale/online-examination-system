<style>
    :root {
        --primary-color: rgb(11, 78, 179);
    }

    *,
    *::before,
    *::after {
        box-sizing: border-box;
    }

    body {
        font-family: Montserrat, "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
        margin: 0;
        display: grid;
        place-items: center;
        min-height: 100vh;
    }

    /* Global Stylings */
    label {
        display: block;
        margin-bottom: 0.5rem;
    }

    input {
        display: block;
        width: 100%;
        padding: 0.75rem;
        border: 1px solid #ccc;
        border-radius: 0.25rem;
    }

    .width-50 {
        width: 50%;
    }

    .ml-auto {
        margin-left: auto;
    }

    .text-center {
        text-align: center;
    }

    /* Progressbar */
    .progressbar {
        position: relative;
        display: flex;
        justify-content: space-between;
        counter-reset: step;
        margin: 2rem 0 4rem;
    }

    .progressbar::before,
    .progress {
        content: "";
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        height: 4px;
        width: 100%;
        background-color: #dcdcdc;
        z-index: -1;
    }

    .progress {
        background-color: var(--primary-color);
        width: 0%;
        transition: 0.3s;
    }

    .progress-step {
        width: 2.1875rem;
        height: 2.1875rem;
        background-color: #dcdcdc;
        border-radius: 50%;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .progress-step::before {
        counter-increment: step;
        content: counter(step);
    }

    .progress-step::after {
        content: attr(data-title);
        position: absolute;
        top: calc(100% + 0.5rem);
        font-size: 0.85rem;
        color: #666;
    }

    .progress-step-active {
        background-color: var(--primary-color);
        color: #f3f3f3;
    }

    /* Form */
    .form {
        width: 100%;
        /* Increase the form width to 100% */
        max-width: 800px;
        /* Set a maximum width to avoid excessive stretching */
        margin: 0 auto;
        border: 1px solid #ccc;
        border-radius: 0.35rem;
        padding: 1.5rem;
        background-color: white;
        position: relative;
        z-index: 0;
    }

    .form-step {
        display: none;
        transform-origin: top;
        animation: animate 0.5s;
    }

    .form-step-active {
        display: block;
    }

    .input-group {
        margin: 2rem 0;
    }

    @keyframes animate {
        from {
            transform: scale(1, 0);
            opacity: 0;
        }

        to {
            transform: scale(1, 1);
            opacity: 1;
        }
    }

    /* Button */
    .btns-group {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1.5rem;
    }

    .btno {
        padding: 0.75rem;
        display: block;
        text-decoration: none;
        background-color: var(--primary-color);
        color: #f3f3f3;
        text-align: center;
        border-radius: 0.25rem;
        cursor: pointer;
        transition: 0.3s;
    }

    .btno:hover {
        box-shadow: 0 0 0 2px #fff, 0 0 0 3px var(--primary-color);
    }

    @media (max-width: 768px) {
        body {
            display: block;
            /* Change to a block layout for small screens */
            text-align: center;
        }

        .form {
            width: 90%;
            /* Adjust to your preferred width for small screens */
        }

        .progressbar {
            margin: 1rem 0 2rem;
            /* Reduce margin for small screens */
        }

        .btns-group {
            grid-template-columns: 1fr;
            /* Change to a single column layout for small screens */
        }
    }

    select {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        background-color: #f7f7f7;
        color: #333;
    }

    #background-section {
        margin-top: 67px;
        width: 100%;
        background-image: url('img/nwq.jpg');
        background-size: cover;
        background-position: center;
        /* position: absolute; */
        z-index: 10;
    }

    #custom-popup {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        z-index: 1000;
        padding: 200px;
        display: flex;
        justify-content: center;
        align-items: center;
        animation: fadeIn 0.5s;
        /* Add the fade-in animation */
    }

    .popup-content {
        width: 70%;
        margin: auto;
        background: #fff;
        padding: 20px;
        border-radius: 5px;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
        position: relative;
        z-index: 100000;
        animation: scaleIn 0.5s;
        /* Add a scaling animation for the content */
    }



    #close-popup {
        display: block;
        margin-top: 10px;
        cursor: pointer;
    }

    /* Define the fade-in animation */
    @keyframes fadeIn {
        from {
            opacity: 0;
        }

        to {
            opacity: 1;
        }
    }

    /* Define a scaling animation for the content */
    @keyframes scaleIn {
        from {
            transform: scale(0);
        }

        to {
            transform: scale(1);
        }
    }
</style>





<div id="background-section">
    <div class="warning-message" style="display:flex; align-items:center; justify-content:center; padding-top: 10px;">
        <p style="width: fit-content; text-align: center;background-color: white; border-radius: 10px; padding:3px;"><i
                class="fa-solid fa-circle-info"></i> Do Not Refresh or Reload the Page, Your Saved Data Will Be Lost. If
            You
            Want to Go Back, Click on the Back
            Button.</p>
    </div>
    <form action="show.php" method="post" class="form" enctype="multipart/form-data">
        <h1 class="text-center">Post Property Details</h1>
        <!-- Progress bar -->
        <div class="progressbar">
            <div class="progress" id="progress"></div>

            <div class="progress-step progress-step-active" data-title="basic"></div>
            <div class="progress-step" data-title="location"></div>
            <div class="progress-step" data-title="image"></div>
            <div class="progress-step" data-title="property"></div>
            <div class="progress-step" data-title="pricing"></div>
        </div>

        <!-- Steps -->
        <div class="form-step form-step-active">
            <div class="input-group">
                <label for="own">You are </label>
                <select name="own" id="own">
                    <option selected disabled>select one</option>
                    <option value="Owner">Owner</option>
                    <option value="Broker">Broker</option>
                </select>
            </div>
            <div class="input-group">
                <label for="name">Name</label>
                <input type="text" name="name" id="name" />
            </div>
            <div class="input-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" />
            </div>
            <div class="input-group">
                <label for="phoneno">Phone Number</label>
                <input type="tel" name="phoneno" id="phoneno" />
            </div>
            <div class="input-group">
                <input type="checkbox" name="agreement" id="agreement" style="width: auto;" />
                <label for="agreement">I agree to the terms and conditions</label>
            </div>
            <div class="">
                <a href="#" class="btn btno btn-next width-50 ml-auto">Next</a>
            </div>
        </div>
        <div class="form-step">
            <div class="input-group">
                <label for="address">Address</label>
                <input type="text" name="address" id="address" />
            </div>
            <div class="input-group">
                <label for="state">State</label>
                <input type="text" name="state" id="state" />
            </div>
            <div class="input-group">
                <label for="city">City</label>
                <input type="text" name="city" id="city" />
            </div>

            <div class="input-group">
                <label for="area">Area</label>
                <input type="text" name="area" id="area" />
            </div>
            <div class="btns-group">
                <a href="#" class="btn btno btn-prev">Back</a>
                <a href="#" class="btn btno btn-next">Next</a>
            </div>
        </div>
        <div class="form-step">
            <div class="input-group">
                <label for="previewImage">Select preview image</label>
                <input type="file" name="previewImage" id="previewImage" accept="image/*" />
                <img id="previewImageDisplay" src="" alt="Preview" style="max-width: 300px; display: none;">
            </div>
            <div class="input-group">
                <label for="propertyImage">Select property image</label>
                <input type="file" name="propertyImage" id="propertyImage" accept="image/*" />
                <img id="propertyImageDisplay" src="" alt="Preview" style="max-width: 300px; display: none;">
            </div>

            <div class="btns-group">
                <a href="#" class="btn btno btno btn-prev">Back</a>
                <a href="#" class="btn btno btno btn-next">Next</a>
            </div>
        </div>
        <div class="form-step">
            <div class="input-group">
                <label for="pro_type">Select the type of properties</label>
                <select name="pro_type" id="pro_type" onchange="showSelects()">
                    <option selected disabled>select one</option>
                    <option value="Residential">Residential</option>
                    <option value="villa">Villa</option>
                    <option value="Independent">Independent</option>
                    <option value="Apartment">Apartment</option>
                </select>
            </div>
            <div class="input-group" style="display: none;" id="independentSelect">
                <label for="inde">Select the type of independent house</label>
                <select name="inde" id="inde">
                    <option selected disabled>select one</option>
                    <option value="1bhk">1bhk</option>
                    <option value="2bhk">2bhk</option>
                    <option value="3bhk">3bhk</option>
                    <option value="4bhk">4bhk</option>
                    <option value="other">other</option>
                </select>
            </div>
            <div class="input-group" style="display: none;" id="apartmentSelect">
                <label for="apr">Select the type of Apartment house</label>
                <select name="apr" id="apr">
                    <option selected disabled>select one</option>
                    <option value="1bhk">1bhk</option>
                    <option value="2bhk">2bhk</option>
                    <option value="3bhk">3bhk</option>
                    <option value="4bhk">4bhk</option>
                    <option value="other">other</option>
                </select>
            </div>
            <div class="input-group">
                <label for="value">Select no. of bedrooms</label>
                <select name="value" id="value">
                    <option selected disabled>select one</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                </select>
            </div>
            <div class="input-group">
                <label for="value2">Select no. of bathrooms</label>
                <select name="value2" id="value2">
                    <option selected disabled>select one</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                </select>
            </div>
            <div class="input-group">
                <label for="value3">Select no. of balconies</label>
                <select name="value3" id="value3">
                    <option selected disabled>select one</option>
                    <option value="1">0</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                </select>
            </div>
            <div class="input-group">
                <label for="area">Area(in sqmeter)</label>
                <input type="number" name="area" id="area" />
            </div>
            <div class="input-group">
                <label for="floor">Floor details</label>
                <input type="number" name="floor" id="floor" />
            </div>
            <div class="input-group">
                <label for="avail">Availabilty Status</label>
                <select name="avail" id="avail">
                    <option selected disabled>select one</option>
                    <option value="ready to move">Ready to move</option>
                    <option value="under construction">Under construction</option>
                </select>
            </div>
            <div class="input-group">
                <label for="possessionYear">Possession by Year</label>
                <select name="possessionYear" id="possessionYear">
                    <option selected disabled>Select Year</option>
                    <option value="2023">2023</option>
                    <option value="2024">2024</option>
                    <option value="2025">2025</option>
                    <!-- Add more years as needed -->
                </select>


                <select name="possessionMonth" id="possessionMonth">
                    <option selected disabled>Select Month</option>
                    <option value="January">January</option>
                    <option value="February">February</option>
                    <option value="March">March</option>
                    <option value="April">April</option>
                    <option value="May">May</option>
                    <option value="June">June</option>
                    <option value="July">July</option>
                    <option value="August">August</option>
                    <option value="September">September</option>
                    <option value="October">October</option>
                    <option value="November">November</option>
                    <option value="December">December</option>

                </select>
            </div>
            <div class="btns-group">
                <a href="#" class="btn btno btn-prev">Back</a>
                <a href="#" class="btn btno btn-next">Next</a>
            </div>
        </div>
        <div class="form-step">
            <div class="input-group">
                <label for="pro">Ownership</label>
                <select name="pro" id="pro">
                    <option selected disabled>select one</option>
                    <option value="Freehold">Freehold</option>
                    <option value="Leasehold">Leasehold</option>
                    <option value="co-operative society">co-operative society</option>
                    <option value="power of attorney">power of attorney</option>
                </select>
            </div>
            <div class="input-group">
                <label for="price">Pricing</label>
                <select name="price" id="price" onchange="toggleInputFields()">
                    <option selected disabled>Choose One</option>
                    <option value="for rent">For Rent</option>
                    <option value="for sell">For Sell</option>
                </select>
            </div>

            <div class="input-group" id="forRent" style="display: none;">
                <label for="rentPrice">Rent Price</label>
                <input type="text" id="rentPrice" name="rentPrice">
            </div>

            <div class="input-group" id="forSell" style="display: none;">
                <label for="sellPrice">Sell Price</label>
                <input type="text" id="sellPrice" name="sellPrice">
                <label for="sqrftPrice">Price per sqrft.</label>
                <input type="text" id="sqrftPrice" name="sqrft">
            </div>

            <div class="btns-group">
                <a href="#" class="btn btno btn-prev">Back</a>
                <input type="submit" value="Submit" class="btn btno">
            </div>
        </div>
    </form>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        var popup = document.getElementById("custom-popup");
        var closeButton = document.getElementById("close-popup");

        // Show the popup
        popup.style.display = "block";

        // Close the popup when the close button is clicked
        closeButton.addEventListener("click", function () {
            popup.style.display = "none";
        });
    });

    function showSelects() {
        var proTypeSelect = document.getElementById("pro_type");
        var independentSelect = document.getElementById("independentSelect");
        var apartmentSelect = document.getElementById("apartmentSelect");

        if (proTypeSelect.value === "Independent") {
            independentSelect.style.display = "block";
            apartmentSelect.style.display = "none";
        } else if (proTypeSelect.value === "Apartment") {
            independentSelect.style.display = "none";
            apartmentSelect.style.display = "block";
        } else {
            independentSelect.style.display = "none";
            apartmentSelect.style.display = "none";
        }
    }


    function showImagePreview(input, imageDisplay) {
        const file = input.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                imageDisplay.src = e.target.result;
                imageDisplay.style.display = "block";
            };
            reader.readAsDataURL(file);
        }
    }

    // Add event listeners to the file input elements
    const previewImageInput = document.getElementById("previewImage");
    const propertyImageInput = document.getElementById("propertyImage");
    const previewImageDisplay = document.getElementById("previewImageDisplay");
    const propertyImageDisplay = document.getElementById("propertyImageDisplay");

    previewImageInput.addEventListener("change", function () {
        showImagePreview(this, previewImageDisplay);
    });

    propertyImageInput.addEventListener("change", function () {
        showImagePreview(this, propertyImageDisplay);
    });

    function toggleInputFields() {
        var ownershipSelect = document.getElementById("price");
        var forRentInput = document.getElementById("forRent");
        var forSellInput = document.getElementById("forSell");

        forRentInput.style.display = ownershipSelect.value === "for rent" ? "block" : "none";
        forSellInput.style.display = ownershipSelect.value === "for sell" ? "block" : "none";
    }

    let formDraft = {};

    // Function to update form data in the draft object
    function updateDraft(step) {
        // Capture and update data for the current step (example for step 0)
        if (step === 0) {
            formDraft.step0 = {
                own: document.getElementById("own").value,
                name: document.getElementById("name").value,
                email: document.getElementById("email").value,
                phoneno: document.getElementById("phoneno").value,
                agreement: document.getElementById("agreement").checked,
            };
        } else if (step === 1) {
            formDraft.step1 = {
                address: document.getElementById("address").value,
                state: document.getElementById("state").value,
                city: document.getElementById("city").value,
                area: document.getElementById("area").value,
            };
        } else if (step === 2) { // Assuming step 2 corresponds to the images
            formDraft.step2 = {
                previewImage: document.getElementById("previewImage").value,
                propertyImage: document.getElementById("propertyImage").value,
            };
        } else if (step === 3) {
            formDraft.step3 = {
                value: document.getElementById("value").value,
                value2: document.getElementById("value2").value,
                value3: document.getElementById("value3").value,
                area: document.getElementById("area").value,
                floor: document.getElementById("floor").value,
                avail: document.getElementById("avail").value,
                possessionYear: document.getElementById("possessionYear").value,
                possessionMonth: document.getElementById("possessionMonth").value
            };

        } else if (step === 4) {
            formDraft.step4 = {
                ownership: document.getElementById("pro").value,
                pricing: document.getElementById("price").value,
                rentPrice: document.getElementById("rentPrice").value,
                sellPrice: document.getElementById("sellPrice").value,
                sqrftPrice: document.getElementById("sqrftPrice").value,
            };
        }


        // Implement similar updates for other steps
        // ...

        // Store the updated draft in localStorage
        localStorage.setItem('formDraft', JSON.stringify(formDraft));
    }

    // Function to validate form data for the current step
    function validateFormData(step) {
        if (step === 0) {
            const own = document.getElementById("own").value;
            const name = document.getElementById("name").value;
            const email = document.getElementById("email").value;
            const phoneno = document.getElementById("phoneno").value;
            const agreement = document.getElementById("agreement").checked;

            // Check if any required field is empty
            if (!name || !email || !phoneno || !agreement) {

                return false;
            }
        } else if (step === 1) {
            const address = document.getElementById("address").value;
            const state = document.getElementById("state").value;
            const city = document.getElementById("city").value;
            const area = document.getElementById("area").value;

            // Implement validation for step 1 fields
            if (!address || !state || !city || !area) {

                return false;
            }
        } else if (step === 2) {
            const previewImage = document.getElementById("previewImage").value;
            const propertyImage = document.getElementById("propertyImage").value;

            if (!previewImage || !propertyImage) {

                return false;
            }
        } else if (step === 3) {
            const bed = document.getElementById("value").value;
            const bath = document.getElementById("value2").value;
            const bal = document.getElementById("value3").value;
            const area = document.getElementById("area").value;
            const floor = document.getElementById("floor").value;
            const avail = document.getElementById("avail").value;
            const possessionYear = document.getElementById("possessionYear").value;
            const possessionMonth = document.getElementById("possessionMonth").value;
            if (!bed || !bath || !bal || !area || !floor || !avail || !possessionYear || !possessionMonth) {
                return false;
            }
        } else if (step === 4) {
            const ownership = document.getElementById("pro").value;
            const pricing = document.getElementById("price").value;
            const rentPrice = document.getElementById("rentPrice").value;
            const sellPrice = document.getElementById("sellPrice").value;
            const sqrftPrice = document.getElementById("sqrftPrice").value;

            if (!ownership || !pricing) {
                return false; // Validation failed
            }

            if (pricing === "for rent" && !rentPrice) {
                return false; // Validation failed for rent price
            }

            if (pricing === "for sell") {
                if (!sellPrice || !sqrftPrice) {
                    return false; // Validation failed for sell price or sqrft price
                }
            }
        }

        // Implement similar validation logic for other steps if needed

        return true;
    }

    const prevBtns = document.querySelectorAll(".btn-prev");
    const nextBtns = document.querySelectorAll(".btn-next");
    const progress = document.getElementById("progress");
    const formSteps = document.querySelectorAll(".form-step");
    const progressSteps = document.querySelectorAll(".progress-step");

    let formStepsNum = 0;

    nextBtns.forEach((btn) => {
        btn.addEventListener("click", () => {
            const currentStep = formStepsNum;

            // Validate form data for the current step
            if (!validateFormData(currentStep)) {
                return; // Prevent moving to the next step if validation fails
            }

            // Update draft data for the current step
            updateDraft(currentStep);

            formStepsNum++;
            updateFormSteps();
            updateProgressbar();
        });
    });

    prevBtns.forEach((btn) => {
        btn.addEventListener("click", () => {
            // Implement logic for "Go Back" button
            if (formStepsNum > 0) {
                formStepsNum--;
                updateFormSteps();
                updateProgressbar();
            }
        });
    });

    // When the page loads, check if there's a draft and pre-fill the form
    window.addEventListener('load', () => {
        let savedDraft = localStorage.getItem('formDraft');
        if (savedDraft) {
            let draftData = JSON.parse(savedDraft);
            // console.log(savedDraft);

            // Check the current form step and populate the form fields accordingly
            if (formStepsNum === 0) {
                let step0Data = draftData.step0;
                document.getElementById("own").value = step0Data.name;
                document.getElementById("name").value = step0Data.name;
                document.getElementById("email").value = step0Data.email;
                document.getElementById("phoneno").value = step0Data.phoneno;
                document.getElementById("agreement").checked = step0Data.agreement;
            } else if (formStepsNum === 1) {
                let step1Data = draftData.step1;
                document.getElementById("address").value = step1Data.address;
                document.getElementById("state").value = step1Data.state;
                document.getElementById("city").value = step1Data.city;
                document.getElementById("area").value = step1Data.area;

            } else if (formStepsNum === 2) {
                let step2Data = draftData.step2;
                document.getElementById("previewImage").value = step2Data.previewImage;
                document.getElementById("propertyImage").value = step2Data.propertyImage;
            } else if (formStepsNum === 3) {
                let step3Data = draftData.step3;
                document.getElementById("value").value = step3Data.value;
                document.getElementById("value2").value = step3Data.value2;
                document.getElementById("value3").value = step3Data.value3;
                document.getElementById("area").value = step3Data.area;
                document.getElementById("floor").value = step3Data.floor;
                document.getElementById("avail").value = step3Data.avail;
                document.getElementById("possessionYear").value = step3Data.possessionYear;
                document.getElementById("possessionMonth").value = step3Data.possessionMonth;
            }
            //  else if (formStepsNum === 4) {
            //     let step4Data = draftData.step4;
            //     document.getElementById("value").value = step3Data.value;
            //     document.getElementById("value2").value = step3Data.value2;
            //     document.getElementById("value3").value = step3Data.value3;
            //     document.getElementById("area").value = step3Data.area;
            //     document.getElementById("floor").value = step3Data.floor;
            //     document.getElementById("avail").value = step3Data.avail;
            //     document.getElementById("possessionYear").value = step3Data.possessionYear;
            //     document.getElementById("possessionMonth").value = step3Data.possessionMonth;
            // }
            // Implement similar logic for other form steps
            // ...
        }
    });
    // Your existing code

    // Add this code at the end of your script
    window.addEventListener('beforeunload', () => {
        // Clear the localStorage data when the page is unloaded
        localStorage.removeItem('formDraft');
    });
</script>
<script src="https://kit.fontawesome.com/bf3a18cfbc.js" crossorigin="anonymous"></script>