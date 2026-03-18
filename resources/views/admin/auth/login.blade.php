<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
     <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
      body {
            margin: 0;
            height: 100vh;
            font-family: 'Poppins', sans-serif;
            background: radial-gradient(circle at top, #0f172a, #020617);
            color: white;
        }
        .container-fluid{
          height: 100vh;
        }
        .left-panel{
          background: radial-gradient(circle,#0b1220, #020617);
          display: flex;
          flex-direction: column;
          justify-content: center;
          padding: 60px;
          border-right: 1px solid rgba(255,255,255,0.05);
        }
        .brand-title{
          font-size: 42px;
          font-weight: 700;
        }
        .brand-title span{
          color: #3b82f6;
        }
        .panel-card{
          background: rgba(15,23,42,0.6);
          padding: 18px;
          border-radius: 14px;
          margin-bottom: 18px;
          border: 1px solid rgba(255,255,255,0.05);
        }
        .right-panel{
          display: flex;
          justify-content: center;
          align-items: center;
        }
        .login-box{
          width: 420px;
        }
        .tabs{
          background: #020617;
        }
        .tab {
          flex: 1;
          text-align: center;
          padding: 10px;
          border-radius: 10px;
          cursor: pointer;
          transition: all 0.25s ease;
          color: #94a3b8;
        }
        .tab.active{
          background: #3b82f6;
          color: white;
        }
        .form-control{
          background: #020617;
          box-shadow: none;
          border: 1px solid rgba(255,255,255,0.08);
          color: white;
        }
        .form-control:focus{
          background: #020617;
          box-shadow: none;
          border-color: #3b82f6;
          color: white;
        }
        .btn-primary{
          background: #3b82f6;
          border: none;
          height: 48px;
          border-radius: 10px;
          
        }
        .btn-primary:hover{
         background-color: #2563eb;
        }
        .muted {
            color: #94a3b8;
            font-size: 14px;
        }
        a {
          text-decoration: none;
          color: #3b82f6;
        }
    </style>

</head>
<body>
    <div class="container-fluid">
      <div class="row h-100">
        {{-- Left side --}}
        <div class="col-md-6 left-panel">
          <div class="brand-title">
            Edu<span>Admit</span> Pro
          </div>
          <div class="muted mb-4">Administrator Portal</div>
          <div class="panel-card">
            🏛 <strong>Administrator</strong><br>
            <span class="muted">Full system access</span>
          </div>
          <div class="panel-card">
           📊<strong>Analytics Dashboard</strong>
           <span class="muted">Real-time admission stats & lead funnel overview</span>
          </div>
          <div class="panel-card">
            👥 <strong>User Management</strong><br>
            <span class="muted">Add/edit counselors, accountants & system users</span>
          </div>
          <div class="panel-card">
            📜 <strong>Rules & Quotas</strong><br>
            <span class="muted">Configure admission rules, seat limits & categories</span>
          </div>
          
        </div>
        {{-- Right side --}}
        <div class="col-md-6 right-panel"> 
          <div class="login-box">
            <div class="mb-3">
              <a href="/">← Back to role selection</a>
            </div>

            <h3 id="formTitle">Welcome, Admin 👋</h3>
            <div class="muted mb-3" id="formSubtitle">Sign in to access the Admin dashboard

            </div>
             <!-- Tabs -->
                <div class="tabs d-flex p-1 rounded-3 mb-3">
                    <div class="tab active" id="signinTab">Sign In</div>
                    <div class="tab" id="signupTab">Sign Up</div>
                </div>
                {{-- Form --}}
                <form id="signinForm" action="{{ route('admin.login.submit') }}" method="POST">
                  @csrf
                  <div class="mb-3">
                    <label class="muted" for="email">Email</label>
                    <input type="email" name="email" id="email" class="form-control">
                  </div>
                  <div class="mb-2 position-relative">
                    <label class="muted">Password</label>

                    <input type="password"
                           name="password"
                           id="password"
                           class="form-control pe-5">

                    <span id="togglePassword"
                          class="bi bi-eye"
                          style="position:absolute; right:15px; top:38px; cursor:pointer; color:#94a3b8;">
                    </span>
                  </div>
                  <div class="d-flex ">
                    <div>
                      <input type="checkbox" name="remember" id="remember">
                      <span class="muted">Remember me</span>
                    </div>
                    <a href="#">Forget Password?</a>
                  </div>
                  <button class="btn btn-primary w-100">Sign In-></button>
                  
                </form> 
                @csrf

                <form id="signupForm" action="{{ route('admin.signup.submit') }}" method="POST" style="display:none;">
                     @csrf

                     <div class="mb-3">
                        <label class="muted">Full Name</label>
                        <input type="text" name="name" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="muted">Email Address</label>
                        <input type="email" name="email" class="form-control">
                    </div>

                    <div class="mb-2 position-relative">
                    <label class="muted">Password</label>

                    <input type="password"
                           name="password"
                           id="signupPassword"
                           class="form-control pe-5">

                    <span id="toggleSignupPassword"
                          class="bi bi-eye"
                          style="position:absolute; right:15px; top:38px; cursor:pointer; color:#94a3b8;">
                    </span>
                  </div>

                    <div class="mb-2 position-relative">
                        <label class="muted">Confirm Password</label>
                        <input type="password"
                           name="password_confirmation"
                           id="signupConfirmPassword"
                           class="form-control pe-5">

                        <span id="toggleSignupConfirmPassword"
                              class="bi bi-eye"
                              style="position:absolute; right:15px; top:38px; cursor:pointer; color:#94a3b8;">
                        </span>
                    </div>

                    <button class="btn btn-primary w-100">Create Account →</button>
            
                </form>
                @csrf
            </div>
          </div>
          
        </div>
      </div>
    </div>
    <script>
      const signinTab = document.getElementById("signinTab");
      const signupTab = document.getElementById("signupTab");

      const signinForm = document.getElementById("signinForm");
      const signupForm = document.getElementById("signupForm");

      const formTitle = document.getElementById("formTitle");
      const formSubtitle = document.getElementById("formSubtitle");
      const togglePassword = document.getElementById("togglePassword");
      const passwordField = document.getElementById("password");
      const passwordField2 = document.getElementById("password_confirmation");

      signinTab.addEventListener("click", () => {

        signinTab.classList.add("active");
        signupTab.classList.remove("active");

        signinForm.style.display = "block";
        signupForm.style.display = "none";

        formTitle.innerText = "Welcome, Admin 👋";
        formSubtitle.innerText = "Sign in to access the Admin dashboard";
      });

    signupTab.addEventListener("click", () => {

        signupTab.classList.add("active");
        signinTab.classList.remove("active");

        signupForm.style.display = "block";
        signinForm.style.display = "none";

        formTitle.innerText = "Create Account 📝";
        formSubtitle.innerText = "Register as Administrator";
      });

      function setupPasswordToggle(toggleId, inputId) {

    const toggleBtn = document.getElementById(toggleId);
    const input = document.getElementById(inputId);

    if (!toggleBtn || !input) return;

    toggleBtn.addEventListener("click", () => {

        const isHidden = input.type === "password";

        input.type = isHidden ? "text" : "password";

        toggleBtn.classList.toggle("bi-eye");
        toggleBtn.classList.toggle("bi-eye-slash");
    });
}

/* Attach toggles */
setupPasswordToggle("togglePassword", "password");                     // Signin
setupPasswordToggle("toggleSignupPassword", "signupPassword");         // Signup
setupPasswordToggle("toggleSignupConfirmPassword", "signupConfirmPassword"); // Confirm
    </script>
</body>
</html>