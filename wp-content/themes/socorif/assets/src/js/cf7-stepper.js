/**
 * Contact Form 7 Stepper - Version JavaScript Vanilla
 * Transforme les formulaires CF7 en formulaires multi-étapes
 */

document.addEventListener('DOMContentLoaded', function() {
    setTimeout(() => {
        initCF7Stepper();
    }, 500);
});

function initCF7Stepper() {
    const forms = document.querySelectorAll('.cf7-service-form');

    console.log('CF7 Stepper: Found ' + forms.length + ' forms');

    forms.forEach(form => {
        if (form.closest('.cf7-stepper-wrapper')) {
            return;
        }

        console.log('CF7 Stepper: Wrapping form');
        wrapFormWithStepper(form);
    });
}

function wrapFormWithStepper(form) {
    const sections = form.querySelectorAll('.form-section');

    if (sections.length < 3) {
        console.log('CF7 Stepper: Not enough sections');
        return;
    }

    // État du stepper
    let currentStep = 1;
    const totalSteps = 3;

    // Créer le wrapper
    const wrapper = document.createElement('div');
    wrapper.className = 'cf7-stepper-wrapper';

    // Créer l'indicateur d'étapes
    const indicator = createIndicator();
    wrapper.appendChild(indicator);

    // Wrapper le formulaire
    form.parentNode.insertBefore(wrapper, form);
    wrapper.appendChild(form);

    // Organiser les sections par étapes
    sections.forEach((section, index) => {
        section.setAttribute('data-step', Math.floor(index / (sections.length / 3)) + 1);
        section.style.display = 'none';
    });

    // Créer la navigation
    const nav = createNavigation();
    const submitBtn = form.querySelector('.form-submit');
    if (submitBtn) {
        form.insertBefore(nav, submitBtn);
        submitBtn.style.display = 'none';
    }

    // Validation en temps réel pour activer/désactiver le bouton
    form.addEventListener('input', () => {
        checkButtonState();
    });

    form.addEventListener('change', () => {
        checkButtonState();
    });

    // Fonctions de navigation
    function updateUI() {
        // Mettre à jour les sections visibles
        sections.forEach(section => {
            const step = parseInt(section.getAttribute('data-step'));
            section.style.display = step === currentStep ? 'block' : 'none';
        });

        // Mettre à jour l'indicateur
        const steps = indicator.querySelectorAll('.cf7-step-item');
        steps.forEach((item, index) => {
            const stepNum = index + 1;
            item.classList.remove('active', 'completed', 'inactive');

            if (stepNum === currentStep) {
                item.classList.add('active');
            } else if (stepNum < currentStep) {
                item.classList.add('completed');
            } else {
                item.classList.add('inactive');
            }
        });

        // Mettre à jour les boutons
        const backBtn = nav.querySelector('.cf7-btn-back');
        const nextBtn = nav.querySelector('.cf7-btn-next');

        backBtn.style.display = currentStep > 1 ? 'block' : 'none';

        // Au dernier step, changer le bouton "Weiter" en "Anfrage absenden"
        if (currentStep === totalSteps) {
            nextBtn.innerHTML = `
                Anfrage absenden
                <svg class="w-5 h-5 inline-block ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
            `;
            nextBtn.setAttribute('data-is-submit', 'true');
        } else {
            nextBtn.innerHTML = `
                Weiter
                <svg class="w-5 h-5 inline-block ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            `;
            nextBtn.removeAttribute('data-is-submit');
        }

        nextBtn.style.display = 'block';

        // Garder le bouton submit original caché
        if (submitBtn) {
            submitBtn.style.display = 'none';
        }

        // Cacher le message d'erreur
        const errorMsg = nav.querySelector('.cf7-step-error');
        if (errorMsg) {
            errorMsg.style.display = 'none';
        }

        // Vérifier l'état du bouton
        checkButtonState();
    }

    function checkButtonState() {
        const currentSections = Array.from(sections).filter(s =>
            parseInt(s.getAttribute('data-step')) === currentStep
        );

        let hasErrors = false;

        console.log('Checking step:', currentStep);

        currentSections.forEach(section => {
            // Vérifier les inputs et textarea requis (CF7 ajoute aria-required="true")
            const requiredFields = section.querySelectorAll('input[aria-required="true"], textarea[aria-required="true"], select[aria-required="true"]');

            console.log('Required fields found:', requiredFields.length);

            requiredFields.forEach(field => {
                const value = field.value ? field.value.trim() : '';

                console.log('Field:', field.name, 'Value:', value, 'Empty:', !value);

                // Champ vide
                if (!value) {
                    hasErrors = true;
                    return;
                }

                // Validation email
                if (field.type === 'email' && !value.match(/^[^\s@]+@[^\s@]+\.[^\s@]+$/)) {
                    hasErrors = true;
                    console.log('Email invalid:', value);
                    return;
                }

                // Validation téléphone (au moins 6 caractères)
                if (field.type === 'tel' && value.length < 6) {
                    hasErrors = true;
                    console.log('Tel too short:', value);
                    return;
                }
            });

            // Vérifier les checkboxes d'acceptance (datenschutz)
            const acceptanceCheckboxes = section.querySelectorAll('input.wpcf7-acceptance');
            console.log('Acceptance checkboxes found:', acceptanceCheckboxes.length);

            acceptanceCheckboxes.forEach(checkbox => {
                if (!checkbox.checked) {
                    hasErrors = true;
                    console.log('Acceptance not checked');
                }
            });
        });

        console.log('Has errors:', hasErrors);

        // Désactiver/activer le bouton
        const nextBtn = nav.querySelector('.cf7-btn-next');
        if (nextBtn) {
            if (hasErrors) {
                nextBtn.disabled = true;
                nextBtn.classList.add('opacity-50', 'cursor-not-allowed');
                nextBtn.style.pointerEvents = 'none';
            } else {
                nextBtn.disabled = false;
                nextBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                nextBtn.style.pointerEvents = 'auto';
            }
        }
    }

    function validateCurrentStep() {
        const currentSections = Array.from(sections).filter(s =>
            parseInt(s.getAttribute('data-step')) === currentStep
        );

        let isValid = true;
        let errorMessages = [];
        const errorMsg = nav.querySelector('.cf7-step-error');

        // Réinitialiser tous les styles d'erreur
        currentSections.forEach(section => {
            section.querySelectorAll('input, textarea, select').forEach(input => {
                input.classList.remove('!ring-red-500', '!ring-2');
            });
        });

        currentSections.forEach(section => {
            const requiredInputs = section.querySelectorAll('input[aria-required="true"], textarea[aria-required="true"], select[aria-required="true"]');

            requiredInputs.forEach(input => {
                const value = input.value.trim();

                // Vérifier si le champ est vide
                if (!value) {
                    isValid = false;
                    input.classList.add('!ring-red-500', '!ring-2');

                    // Récupérer le placeholder ou le nom du champ
                    const fieldName = input.getAttribute('placeholder') || input.getAttribute('name') || 'Dieses Feld';
                    if (!errorMessages.includes('Bitte füllen Sie alle Pflichtfelder aus.')) {
                        errorMessages.push('Bitte füllen Sie alle Pflichtfelder aus.');
                    }
                }

                // Validation email spécifique pour les champs requis
                if (input.type === 'email' && value && !value.match(/^[^\s@]+@[^\s@]+\.[^\s@]+$/)) {
                    isValid = false;
                    input.classList.add('!ring-red-500', '!ring-2');
                    if (!errorMessages.includes('Bitte geben Sie eine gültige E-Mail-Adresse ein.')) {
                        errorMessages.push('Bitte geben Sie eine gültige E-Mail-Adresse ein.');
                    }
                }

                // Validation téléphone pour les champs requis
                if (input.type === 'tel' && value && value.length < 6) {
                    isValid = false;
                    input.classList.add('!ring-red-500', '!ring-2');
                    if (!errorMessages.includes('Bitte geben Sie eine gültige Telefonnummer ein.')) {
                        errorMessages.push('Bitte geben Sie eine gültige Telefonnummer ein.');
                    }
                }
            });

            // Vérifier les checkboxes d'acceptance
            const acceptanceCheckboxes = section.querySelectorAll('input.wpcf7-acceptance');
            acceptanceCheckboxes.forEach(checkbox => {
                if (!checkbox.checked) {
                    isValid = false;
                    if (!errorMessages.includes('Bitte akzeptieren Sie die Datenschutzerklärung.')) {
                        errorMessages.push('Bitte akzeptieren Sie die Datenschutzerklärung.');
                    }
                }
            });
        });

        // Afficher les messages d'erreur
        if (!isValid && errorMsg) {
            errorMsg.innerHTML = errorMessages.map(msg =>
                `<div class="flex items-start gap-2 mb-2 last:mb-0">
                    <svg class="w-5 h-5 text-red-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                    <span>${msg}</span>
                </div>`
            ).join('');
            errorMsg.style.display = 'block';

            // Scroller vers le premier champ en erreur
            const firstError = form.querySelector('.!ring-red-500');
            if (firstError) {
                firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                firstError.focus();
            }
        } else if (errorMsg) {
            errorMsg.style.display = 'none';
        }

        return isValid;
    }

    // Event listeners pour la navigation
    nav.querySelector('.cf7-btn-back').addEventListener('click', () => {
        if (currentStep > 1) {
            currentStep--;
            updateUI();
            // Scroll doux seulement si l'indicateur n'est pas visible
            scrollToIndicatorIfNeeded();
        }
    });

    nav.querySelector('.cf7-btn-next').addEventListener('click', (e) => {
        const nextBtn = e.currentTarget;

        // Si c'est le dernier step, soumettre le formulaire
        if (nextBtn.hasAttribute('data-is-submit')) {
            if (validateCurrentStep()) {
                // Cliquer sur le vrai bouton submit de CF7
                const realSubmitBtn = submitBtn?.querySelector('input[type="submit"]');
                if (realSubmitBtn) {
                    realSubmitBtn.click();
                }
            }
        } else {
            // Sinon, passer à l'étape suivante
            if (validateCurrentStep() && currentStep < totalSteps) {
                currentStep++;
                updateUI();
                // Scroll doux seulement si l'indicateur n'est pas visible
                scrollToIndicatorIfNeeded();
            }
        }
    });

    // Fonction pour scroller uniquement si nécessaire
    function scrollToIndicatorIfNeeded() {
        const indicatorRect = indicator.getBoundingClientRect();
        const isIndicatorVisible = (
            indicatorRect.top >= 0 &&
            indicatorRect.bottom <= window.innerHeight
        );

        // Scroller uniquement si l'indicateur n'est pas visible
        if (!isIndicatorVisible) {
            const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
            const targetTop = wrapper.offsetTop - 20;

            window.scrollTo({
                top: targetTop,
                behavior: 'smooth'
            });
        }
    }

    // Initialiser l'UI
    updateUI();

    // Vérifier l'état initial du bouton (doit être désactivé si champs vides)
    setTimeout(() => {
        checkButtonState();
    }, 100);

    console.log('CF7 Stepper: Initialized successfully');
}

function createIndicator() {
    const indicator = document.createElement('div');
    indicator.className = 'cf7-stepper-indicator';
    indicator.innerHTML = `
        <div class="cf7-step-item active">
            <div class="cf7-step-number">1</div>
            <span class="cf7-step-label hidden sm:inline">Kontaktdaten</span>
        </div>
        <div class="cf7-step-connector"></div>
        <div class="cf7-step-item inactive">
            <div class="cf7-step-number">2</div>
            <span class="cf7-step-label hidden sm:inline">Projektstandort</span>
        </div>
        <div class="cf7-step-connector"></div>
        <div class="cf7-step-item inactive">
            <div class="cf7-step-number">3</div>
            <span class="cf7-step-label hidden sm:inline">Projektdetails</span>
        </div>
    `;
    return indicator;
}

function createNavigation() {
    const nav = document.createElement('div');
    nav.innerHTML = `
        <div class="cf7-step-error" style="display: none;"></div>
        <div class="cf7-stepper-navigation">
            <button type="button" class="cf7-btn-back" style="display: none;">
                <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Zurück
            </button>
            <button type="button" class="cf7-btn-next ml-auto">
                Weiter
                <svg class="w-5 h-5 inline-block ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </button>
        </div>
    `;
    return nav;
}
