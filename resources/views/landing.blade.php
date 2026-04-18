<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apply Now | EduAdmit Pro</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: radial-gradient(circle at top, #0f172a, #020617);
            color: #fff;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow-x: hidden;
            margin: 0;
            padding: 20px 0;
        }

        .landing-container {
            max-width: 1200px;
            width: 100%;
            display: flex;
            align-items: center;
            gap: 50px;
            padding: 0 20px;
        }

        .content-col {
            flex: 1;
        }

        .form-col {
            flex: 1;
            max-width: 500px;
        }

        .hero-title {
            font-size: clamp(2.5rem, 5vw, 4rem);
            font-weight: 700;
            line-height: 1.2;
            margin-bottom: 20px;
        }

        .hero-title span {
            background: linear-gradient(135deg, #3b82f6, #8b5cf6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .hero-subtitle {
            color: #94a3b8;
            font-size: 1.1rem;
            line-height: 1.6;
            margin-bottom: 30px;
        }

        .feature-list {
            list-style: none;
            padding: 0;
        }

        .feature-list li {
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 15px;
            font-size: 1rem;
            color: #cbd5e1;
        }

        .feature-list i {
            color: #3b82f6;
            background: rgba(59, 130, 246, 0.1);
            padding: 8px;
            border-radius: 50%;
            font-size: 0.9rem;
        }

        .lead-form-card {
            background: linear-gradient(145deg, #1e293b, #0f172a);
            border-radius: 20px;
            padding: 40px;
            border: 1px solid rgba(255, 255, 255, 0.05);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            position: relative;
            overflow: hidden;
        }

        /* Glowing top border */
        .lead-form-card::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, #3b82f6, #8b5cf6);
        }

        .form-label {
            color: #94a3b8;
            font-weight: 500;
            font-size: 0.9rem;
            margin-bottom: 8px;
        }

        .form-control, .form-select {
            background: #0f172a;
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: #fff;
            border-radius: 12px;
            padding: 14px 20px;
            transition: all 0.3s ease;
        }

        .form-control:focus, .form-select:focus {
            background: #0f172a;
            color: #fff;
            border-color: #3b82f6;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
        }

        .form-select option {
            background: #0f172a;
            color: #fff;
        }

        .submit-btn {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            color: white;
            border: none;
            border-radius: 12px;
            padding: 16px;
            font-weight: 600;
            font-size: 1.1rem;
            width: 100%;
            transition: all 0.3s ease;
            margin-top: 20px;
            box-shadow: 0 10px 20px -5px rgba(59, 130, 246, 0.4);
        }

        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 25px -5px rgba(59, 130, 246, 0.5);
            color: white;
        }

        .success-overlay {
            position: absolute;
            inset: 0;
            background: rgba(15, 23, 42, 0.95);
            backdrop-filter: blur(8px);
            border-radius: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            opacity: 0;
            visibility: hidden;
            transition: 0.4s ease;
            padding: 40px;
            z-index: 10;
        }

        .success-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        .success-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #10b981, #059669);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 40px;
            color: white;
            margin-bottom: 25px;
            box-shadow: 0 10px 25px rgba(16, 185, 129, 0.4);
            animation: bounceIn 0.6s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards;
            opacity: 0;
            transform: scale(0.5);
        }

        .success-overlay.active .success-icon {
            animation-delay: 0.1s;
        }

        @keyframes bounceIn {
            to { opacity: 1; transform: scale(1); }
        }

        /* Responsive */
        @media (max-width: 991px) {
            .landing-container {
                flex-direction: column;
                text-align: center;
            }
            .feature-list {
                display: inline-block;
                text-align: left;
            }
        }
    <style>
        /* Existing CSS ... we will add just header at the bottom of the style tag */
        .top-header {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            padding: 20px 40px;
            display: flex;
            justify-content: flex-end;
            z-index: 100;
        }
        .header-btn {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: #cbd5e1;
            padding: 10px 24px;
            border-radius: 20px;
            text-decoration: none;
            font-weight: 500;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        .header-btn:hover {
            color: white;
            background: rgba(255, 255, 255, 0.1);
            transform: translateY(-2px);
            border-color: rgba(255, 255, 255, 0.2);
        }
    </style>
</head>
<body>

    <div class="top-header">
        <a href="{{ route('portals') }}" class="header-btn">
            <i class="fas fa-lock text-primary"></i> App Portals
        </a>
    </div>

    <div class="landing-container">
        <!-- Content Column -->
        <div class="content-col">
            <h1 class="hero-title">Start Your Journey With <span>EduAdmit Pro</span></h1>
            <p class="hero-subtitle">Secure your admission today. Fill out the application enquiry form and our dedicated counselors will reach out to you within 24 hours to guide you through the process.</p>
            
            <ul class="feature-list">
                <li><i class="fas fa-check"></i> 100% Online Processing</li>
                <li><i class="fas fa-check"></i> Instant Counselor Assignment</li>
                <li><i class="fas fa-check"></i> Real-time Application Tracking</li>
                <li><i class="fas fa-check"></i> Secure Document Uploads</li>
            </ul>
        </div>

        <!-- Form Column -->
        <div class="form-col">
            <div class="lead-form-card">
                
                <h4 class="mb-4 text-center fw-bold">Admission Enquiry</h4>
                
                <form id="leadForm">
                    <!-- CSRF Token for Laravel -->
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    
                    <!-- DYNAMIC SOURCE TRACKING -->
                    <input type="hidden" name="source" value="{{ $source }}">

                    <div class="mb-3">
                        <label class="form-label">Full Name</label>
                        <input type="text" class="form-control" name="name" placeholder="John Doe" required>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Email Address</label>
                            <input type="email" class="form-control" name="email" placeholder="john@example.com" required>
                            <div class="invalid-feedback text-danger mt-1 fs-7" id="emailError"></div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Phone Number</label>
                            <input type="tel" class="form-control" name="phone" placeholder="+1 234 567 8900" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Interested Course</label>
                        <select class="form-select" name="course_interested" required>
                            <option value="" selected disabled>Select a course</option>
                            @foreach($courses as $course)
                                <option value="{{ $course->id }}">{{ $course->name }} ({{ $course->code }})</option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit" class="submit-btn" id="submitBtn">
                        Submit Application
                    </button>
                    
                    <div class="text-center mt-3 text-secondary" style="font-size: 0.8rem;">
                        By submitting, you agree to our Terms & Privacy Policy
                    </div>
                </form>

                <!-- Success Overlay -->
                <div class="success-overlay" id="successOverlay">
                    <div class="success-icon"><i class="fas fa-check"></i></div>
                    <h3 class="fw-bold mb-3">Request Received!</h3>
                    <p class="text-slate-400 mb-0">Thank you for your interest. One of our admission counselors will contact you shortly.</p>
                </div>

            </div>
        </div>
    </div>

    <script>
        document.getElementById('leadForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const form = this;
            const submitBtn = document.getElementById('submitBtn');
            const emailError = document.getElementById('emailError');
            
            // Reset errors
            emailError.innerText = '';
            
            // UI Loading state
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
            submitBtn.disabled = true;

            const formData = new FormData(form);

            try {
                const response = await fetch("{{ route('api.leads.capture') }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': formData.get('_token'),
                        'Accept': 'application/json',
                    },
                    body: formData
                });

                const data = await response.json();

                if (response.ok) {
                    // Success! Show beautiful overlay
                    document.getElementById('successOverlay').classList.add('active');
                    form.reset();
                } else {
                    // Handle Errors (Validation)
                    if(data.errors && data.errors.email) {
                        emailError.innerText = data.errors.email[0];
                    } else {
                        alert(data.message || 'Something went wrong. Please try again.');
                    }
                }
            } catch (error) {
                console.error('Error:', error);
                alert('A network error occurred. Please try again.');
            } finally {
                // Restore Button State
                submitBtn.innerHTML = 'Submit Application';
                submitBtn.disabled = false;
            }
        });
    </script>
</body>
</html>
