document.addEventListener("DOMContentLoaded", () => {
    let currentStep = 1;
    let formData = {};

    function switchStep(step) {
        document.querySelectorAll(".form-container").forEach((container) => {
            container.style.display = "none";
        });

        const nextStepContainer = document.querySelector(`#step${step}-container`);
        if (nextStepContainer) {
            nextStepContainer.style.display = "block";
            currentStep = step;
            attachFormListeners();
        }
    }

    function checkInputs(step) {
        let isValid = true;
        const currentContainer = document.querySelector(`#step${step}-container`);
        if (!currentContainer) return false;

        const fields = currentContainer.querySelectorAll("input[required], select[required], textarea[required]");
        fields.forEach((field) => {
            if (field.value.trim() === "") {
                setErrorFor(field, `${field.parentElement.querySelector("label")?.textContent || field.name} is verplicht.`);
                isValid = false;
            } else {
                setSuccessFor(field);
            }
        });

        return isValid;
    }

    function setErrorFor(input, message) {
        const parent = input.parentElement;
        const small = parent.querySelector(".error-message");
        input.style.border = "2px solid red";
        if (small) small.textContent = message;
    }

    function setSuccessFor(input) {
        const parent = input.parentElement;
        const small = parent.querySelector(".error-message");
        input.style.border = "2px solid green";
        if (small) small.textContent = "";
    }

    function collectFormData(step) {
        const currentContainer = document.querySelector(`#step${step}-container`);
        if (!currentContainer) return;

        const fields = currentContainer.querySelectorAll("input, select, textarea");
        fields.forEach((field) => {
            if (field.name) {
                formData[field.name] = field.value.trim();
            }
        });
    }

    function submitFinalForm() {
        console.log("Form Data:", formData);
        showSuccessMessage();
    }

    function showSuccessMessage() {
        const formContainer = document.querySelector(`#step${currentStep}-container`);
        if (!formContainer) return;

        formContainer.innerHTML = `
            <div id="success-message" style="text-align: center;">
                <h2 style="font-size: 24px; color: green;">Uw verzoek is succesvol verzonden!</h2>
                <p style="margin: 10px 0;">We nemen binnenkort contact met je op.</p>
                <button id="close-success" style="padding: 10px 20px; background: green; color: white; border: none; cursor: pointer; border-radius: 5px;">
                    Sluit
                </button>
            </div>
        `;

        const closeButton = document.querySelector("#close-success");
        if (closeButton) {
            closeButton.addEventListener("click", () => {
                formContainer.innerHTML = "<p>Bedankt</p>";
            });
        }
    }

    function attachFormListeners() {
        const forms = document.querySelectorAll(".auto-sales-form");
        forms.forEach((form) => {
            form.removeEventListener("submit", handleSubmit); // Prevent duplicate listeners
            form.addEventListener("submit", handleSubmit);
        });

        const currentContainer = document.querySelector(`#step${currentStep}-container`);
        if (currentContainer) {
            const fields = currentContainer.querySelectorAll("input, select, textarea");
            fields.forEach((field) => {
                field.removeEventListener("input", handleInputChange);
                field.removeEventListener("change", handleInputChange);
                field.addEventListener("input", handleInputChange);
                field.addEventListener("change", handleInputChange);
            });
        }
    }

    function handleSubmit(e) {
        e.preventDefault();
        if (!checkInputs(currentStep)) {
            alert("Lütfen tüm zorunlu alanları doldurun.");
            return;
        }

        collectFormData(currentStep);
        if (window.history && history.replaceState) {
            history.replaceState(null, null, window.location.pathname);
        }

        if (currentStep < 3) {
            switchStep(currentStep + 1);
        } else {
            submitFinalForm();
        }
    }

    function handleInputChange() {
        checkInputs(currentStep);
    }

    attachFormListeners();
});