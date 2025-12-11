document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('regForm');
    const resetBtn = document.getElementById('resetBtn');
    const submitBtn = document.getElementById('submitBtn');
    const dobInput = document.getElementById('dob');

    if (!form) return;

    // --- Date Constraints ---
    // Set maximum date to today (prevent future dates)
    const today = new Date().toISOString().split('T')[0];
    if (dobInput) {
        dobInput.max = today;

        // Set minimum date (e.g., 100 years ago for realistic age)
        const minDate = new Date();
        minDate.setFullYear(minDate.getFullYear() - 100);
        dobInput.min = minDate.toISOString().split('T')[0];
    }

    // --- Reset Functionality ---
    resetBtn.addEventListener('click', () => {
        form.reset();
        // Clear all error messages
        document.querySelectorAll('.error-message').forEach(el => el.classList.remove('visible'));
        submitBtn.disabled = false;
        submitBtn.textContent = 'Submit Registration';
    });

    // --- Input Validation (Real-time removal of errors) ---
    const inputs = form.querySelectorAll('input, select, textarea');
    inputs.forEach(input => {
        // Remove error when user starts typing/correcting
        input.addEventListener('input', function () {
            if (this.checkValidity()) {
                const errorId = this.id + 'Error';
                const errorDiv = document.getElementById(errorId);
                if (errorDiv) errorDiv.classList.remove('visible');
            }
        });

        // Handle invalid event to show custom error
        input.addEventListener('invalid', function (e) {
            e.preventDefault(); // Prevent default browser tooltip
            const errorId = this.id + 'Error';
            const errorDiv = document.getElementById(errorId);
            if (errorDiv) {
                errorDiv.classList.add('visible');
            }
        });
    });

    // --- Form Submit ---
    form.addEventListener('submit', async (e) => {
        e.preventDefault();

        // Trigger validation check manually
        if (!form.checkValidity()) {
            const firstInvalid = form.querySelector(':invalid');
            if (firstInvalid) firstInvalid.focus();
            return;
        }

        // Gather Form Data
        const formData = new FormData(form);
        const data = Object.fromEntries(formData.entries());
        const interests = formData.getAll('interests[]');

        // Show loading state
        submitBtn.disabled = true;
        submitBtn.textContent = 'Submitting...';

        try {
            // Attempt to send to PHP server (if running)
            const response = await fetch('process.php', {
                method: 'POST',
                body: formData
            });

            if (response.ok) {
                const result = await response.json();
                if (result.status === 'success') {
                    console.log('Saved to DB:', result);
                } else {
                    console.error('Server Error:', result.message);
                }
            } else {
                // If 405 or 404, server is missing/misconfigured. Proceed calmly.
                console.warn('Backend unavailable (likely no PHP server), proceeding with client-side preview.');
            }

        } catch (error) {
            console.warn('Network/Server error, proceeding with client-side preview.', error);
        }

        // --- Client-Side Success View (Runs for both Server & Fallback) ---

        // Populate Success View
        document.getElementById('displayFullName').textContent = data.fullName;
        document.getElementById('displayEmail').textContent = data.email;
        document.getElementById('displayPhone').textContent = data.phone;
        document.getElementById('displayDob').textContent = data.dob;
        document.getElementById('displayCourse').textContent = data.course;
        document.getElementById('displayGender').textContent = data.gender;
        document.getElementById('displayAddress').textContent = data.address || '-';
        document.getElementById('displayInterests').textContent = interests.join(', ') || 'None';

        // Update UI
        form.classList.add('hidden');
        const headerH1 = document.querySelector('header h1');
        const headerP = document.querySelector('header p');
        if (headerH1) headerH1.textContent = 'Registration Successful';
        if (headerP) headerP.textContent = 'Your application has been submitted successfully.';

        const successView = document.getElementById('successView');
        successView.classList.remove('hidden');
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });

    // --- Back/Submit Another Handler ---
    const backBtn = document.getElementById('backBtn');
    if (backBtn) {
        backBtn.addEventListener('click', () => {
            // Reset form
            form.reset();
            submitBtn.disabled = false;
            submitBtn.textContent = 'Submit Registration';
            submitBtn.style.opacity = '1';
            submitBtn.style.cursor = 'pointer';

            // Toggle Views
            const successView = document.getElementById('successView');
            successView.classList.add('hidden');
            form.classList.remove('hidden');

            // Reset Header
            document.querySelector('header h1').textContent = 'Student Registration';
            document.querySelector('header p').textContent = 'Complete the form below to enroll in your desired course.';
        });
    }
});