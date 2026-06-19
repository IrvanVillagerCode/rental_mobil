<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login – Sistem Rental Mobil</title>
    <meta name="description" content="Login ke Sistem Informasi Rental Mobil Kelompok 2">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
</head>

<body class="login-page">

    <div class="login-bg">
        <div class="login-orb orb-1"></div>
        <div class="login-orb orb-2"></div>
        <div class="login-orb orb-3"></div>
    </div>

    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <div class="login-logo">
                    <i class="bi bi-car-front-fill"></i>
                </div>
                <h1>RentaCar</h1>
                <p>Sistem Informasi Rental Mobil</p>
                <span class="login-badge">Kelompok 2 – Teknik Informatika</span>
            </div>

            <div id="error-box" class="error-alert" style="display:none">
                <i class="bi bi-exclamation-triangle-fill"></i>
                <span id="error-msg">Login gagal</span>
            </div>

            <!-- Tab Switcher -->
            <div class="tab-switcher">
                <button class="tab-btn active" id="tabAdmin" onclick="switchTab('admin')">
                    <i class="bi bi-shield-lock"></i> Admin
                </button>
                <button class="tab-btn" id="tabUser" onclick="switchTab('user')">
                    <i class="bi bi-person-circle"></i> Pelanggan
                </button>
            </div>

            <!-- Admin Login Form -->
            <div id="formAdmin" class="login-form-section">
                <p class="form-hint">Login dengan email & password akun admin</p>
                <div class="form-group">
                    <label for="admin-email"><i class="bi bi-envelope"></i> Email Admin</label>
                    <input type="email" id="admin-email" class="form-control" placeholder="admin@rental.com" autocomplete="email">
                </div>
                <div class="form-group password-group">
                    <label for="admin-password"><i class="bi bi-lock"></i> Password</label>
                    <input type="password" id="admin-password" class="form-control" placeholder="••••••••">
                    <button class="toggle-pass" type="button" onclick="togglePass('admin-password', this)">
                        <i class="bi bi-eye"></i>
                    </button>
                </div>
                <button id="btn-admin-login" class="btn-login" onclick="loginAdmin()">
                    <span class="btn-text"><i class="bi bi-box-arrow-in-right"></i> Masuk sebagai Admin</span>
                    <span class="btn-loader" style="display:none"><i class="bi bi-arrow-repeat spin"></i> Memverifikasi...</span>
                </button>
            </div>

            <!-- User Login Form -->
            <div id="formUser" class="login-form-section" style="display:none">
                <p class="form-hint">Login atau daftar akun pelanggan baru</p>
                <button id="btn-google-login" class="btn-google" onclick="loginGoogle()">
                    <svg width="18" height="18" viewBox="0 0 48 48">
                        <path fill="#EA4335" d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z" />
                        <path fill="#4285F4" d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.78 7.18l7.73 6c4.51-4.18 7.09-10.36 7.09-17.65z" />
                        <path fill="#FBBC05" d="M10.53 28.59c-.48-1.45-.76-2.99-.76-4.59s.27-3.14.76-4.59l-7.98-6.19C.92 16.46 0 20.12 0 24c0 3.88.92 7.54 2.56 10.78l7.97-6.19z" />
                        <path fill="#34A853" d="M24 48c6.48 0 11.93-2.13 15.89-5.81l-7.73-6c-2.15 1.45-4.92 2.3-8.16 2.3-6.26 0-11.57-4.22-13.47-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z" />
                    </svg>
                    Masuk dengan Google
                </button>
                
                <div class="divider"><span>atau gunakan email</span></div>

                <!-- Sub-tabs for User (Login vs Register) -->
                <div class="user-action-toggle">
                    <a href="javascript:void(0)" id="userToggleLogin" class="user-toggle-btn active" onclick="switchUserAction('login')">Masuk</a>
                    <a href="javascript:void(0)" id="userToggleRegister" class="user-toggle-btn" onclick="switchUserAction('register')">Daftar Baru</a>
                </div>

                <!-- Nama Lengkap (Hanya tampil saat Register) -->
                <div class="form-group" id="user-group-nama" style="display:none">
                    <label for="reg-nama">Nama Lengkap</label>
                    <input type="text" id="reg-nama" class="form-control" placeholder="Nama lengkap Anda">
                </div>

                <!-- Email -->
                <div class="form-group">
                    <label for="reg-email">Email</label>
                    <input type="email" id="reg-email" class="form-control" placeholder="email@anda.com">
                </div>

                <!-- Password -->
                <div class="form-group password-group">
                    <label for="reg-password">Password</label>
                    <input type="password" id="reg-password" class="form-control" placeholder="Min. 8 karakter">
                    <button class="toggle-pass" type="button" onclick="togglePass('reg-password', this)">
                        <i class="bi bi-eye"></i>
                    </button>
                </div>

                <!-- Action Button -->
                <button id="btn-user-action" class="btn-login" onclick="handleUserAction()">
                    <span class="btn-text"><i class="bi bi-box-arrow-in-right"></i> Masuk</span>
                    <span class="btn-loader" style="display:none"><i class="bi bi-arrow-repeat spin"></i> Memproses...</span>
                </button>
            </div>

            <p class="login-footer">© 2026 Kelompok 2 – Teknik Informatika</p>
        </div>
    </div>

    <!-- Firebase SDK -->
    <script type="module">
        import {
            initializeApp
        } from "https://www.gstatic.com/firebasejs/10.12.0/firebase-app.js";
        import {
            getAuth,
            signInWithEmailAndPassword,
            signInWithPopup,
            GoogleAuthProvider,
            createUserWithEmailAndPassword
        } from "https://www.gstatic.com/firebasejs/10.12.0/firebase-auth.js";

        // =============================================
        // GANTI DENGAN KONFIGURASI FIREBASE ANDA
        // =============================================
        const firebaseConfig = {
            apiKey: "AIzaSyDXsVU3ztLztO6H1yOe7dkoY2L-K9ZXmz4",
            authDomain: "rental-mobile-a9138.firebaseapp.com",
            projectId: "rental-mobile-a9138",
            storageBucket: "rental-mobile-a9138.firebasestorage.app",
            messagingSenderId: "143774694513",
            appId: "1:143774694513:web:64649155767510bbf1efd0",
            measurementId: "G-8R6DN6D81G"
        };


        const app = initializeApp(firebaseConfig);
        const auth = getAuth(app);
        const provider = new GoogleAuthProvider();

        const BASE_URL = "<?= base_url() ?>";

        function showError(msg) {
            document.getElementById('error-msg').innerHTML = msg;
            document.getElementById('error-box').style.display = 'flex';
        }

        function hideError() {
            document.getElementById('error-box').style.display = 'none';
        }

        function setLoading(btnId, loading) {
            const btn = document.getElementById(btnId);
            const text = btn.querySelector('.btn-text');
            const loader = btn.querySelector('.btn-loader');
            if (text && loader) {
                text.style.display = loading ? 'none' : '';
                loader.style.display = loading ? '' : 'none';
            }
            btn.disabled = loading;
        }

        async function sendSession(user, role = 'user') {
            const token = await user.getIdToken();
            const res = await fetch(BASE_URL + 'auth/set-session', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({
                    uid: user.uid,
                    nama: user.displayName || document.getElementById('reg-nama')?.value || user.email,
                    email: user.email,
                    role: role,
                    token: token
                })
            });
            const data = await res.json();
            if (data.status === 'ok') {
                window.location.href = data.redirect;
            } else {
                showError(data.message || 'Gagal memverifikasi sesi.');
            }
        }

        window.loginAdmin = async function() {
            hideError();
            const email = document.getElementById('admin-email').value.trim();
            const password = document.getElementById('admin-password').value;
            if (!email || !password) {
                showError('Email dan password wajib diisi!');
                return;
            }
            setLoading('btn-admin-login', true);
            try {
                const cred = await signInWithEmailAndPassword(auth, email, password);
                await sendSession(cred.user, 'admin');
            } catch (e) {
                showError('Login gagal: ' + (e.code === 'auth/invalid-credential' ? 'Email atau password salah.' : e.message));
                setLoading('btn-admin-login', false);
            }
        };

        window.loginGoogle = async function() {
            hideError();
            try {
                const result = await signInWithPopup(auth, provider);
                await sendSession(result.user, 'user');
            } catch (e) {
                showError('Login Google gagal: ' + e.message);
            }
        };

        // User email login
        window.loginUser = async function() {
            hideError();
            const email = document.getElementById('reg-email').value.trim();
            const password = document.getElementById('reg-password').value;
            if (!email || !password) {
                showError('Email dan password wajib diisi!');
                return;
            }
            setLoading('btn-user-action', true);
            try {
                const cred = await signInWithEmailAndPassword(auth, email, password);
                await sendSession(cred.user, 'user');
            } catch (e) {
                showError('Login gagal: ' + (e.code === 'auth/invalid-credential' ? 'Email atau password salah.' : e.message));
                setLoading('btn-user-action', false);
            }
        };

        // User email registration
        window.registerUser = async function() {
            hideError();
            const nama = document.getElementById('reg-nama').value.trim();
            const email = document.getElementById('reg-email').value.trim();
            const password = document.getElementById('reg-password').value;
            
            if (!nama || !email || !password) {
                showError('Semua field wajib diisi!');
                return;
            }
            
            if (password.length < 8) {
                showError('Password minimal 8 karakter!');
                return;
            }
            
            // Validasi format email
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                showError('Format email tidak valid!');
                return;
            }
            
            // Cek apakah email sudah terdaftar di database lokal
            try {
                const checkRes = await fetch(BASE_URL + 'auth/check-email-exists?email=' + encodeURIComponent(email));
                const checkData = await checkRes.json();
                
                if (checkData.exists) {
                    showError('Email ini sudah terdaftar. <br><strong>Silakan login</strong> dengan akun Anda atau gunakan email lain untuk mendaftar.');
                    return;
                }
            } catch (e) {
                console.warn('Email check failed, continuing with registration:', e);
            }
            
            setLoading('btn-user-action', true);
            try {
                const cred = await createUserWithEmailAndPassword(auth, email, password);
                await cred.user.updateProfile({
                    displayName: nama
                });
                await sendSession(cred.user, 'user');
            } catch (e) {
                // Handle specific Firebase errors
                let errorMsg = 'Registrasi gagal: ' + e.message;
                
                if (e.code === 'auth/email-already-in-use') {
                    errorMsg = 'Email ini sudah terdaftar. <br><strong>Silakan login</strong> dengan akun Anda atau gunakan email lain untuk mendaftar.';
                } else if (e.code === 'auth/weak-password') {
                    errorMsg = 'Password terlalu lemah. Gunakan kombinasi huruf, angka, dan simbol.';
                } else if (e.code === 'auth/invalid-email') {
                    errorMsg = 'Format email tidak valid!';
                } else if (e.code === 'auth/operation-not-allowed') {
                    errorMsg = 'Registrasi sedang dinonaktifkan. Hubungi admin.';
                }
                
                showError(errorMsg);
                setLoading('btn-user-action', false);
            }
        };

        // Switch user login vs register
        window.currentUserAction = 'login';
        window.switchUserAction = function(action) {
            window.currentUserAction = action;
            const groupNama = document.getElementById('user-group-nama');
            const btnText = document.querySelector('#btn-user-action .btn-text');
            const toggleLogin = document.getElementById('userToggleLogin');
            const toggleRegister = document.getElementById('userToggleRegister');

            if (action === 'login') {
                if (groupNama) groupNama.style.display = 'none';
                if (btnText) btnText.innerHTML = '<i class="bi bi-box-arrow-in-right"></i> Masuk';
                if (toggleLogin) toggleLogin.classList.add('active');
                if (toggleRegister) toggleRegister.classList.remove('active');
            } else {
                if (groupNama) groupNama.style.display = 'block';
                if (btnText) btnText.innerHTML = '<i class="bi bi-person-plus"></i> Daftar Baru';
                if (toggleLogin) toggleLogin.classList.remove('active');
                if (toggleRegister) toggleRegister.classList.add('active');
            }
        };

        window.handleUserAction = async function() {
            if (window.currentUserAction === 'login') {
                await window.loginUser();
            } else {
                await window.registerUser();
            }
        };
    </script>

    <script>
        function switchTab(tab) {
            document.getElementById('formAdmin').style.display = (tab === 'admin') ? 'block' : 'none';
            document.getElementById('formUser').style.display = (tab === 'user') ? 'block' : 'none';
            document.getElementById('tabAdmin').classList.toggle('active', tab === 'admin');
            document.getElementById('tabUser').classList.toggle('active', tab === 'user');
        }

        function togglePass(inputId, btn) {
            const input = document.getElementById(inputId);
            const icon = btn.querySelector('i');
            if (input.type === 'password') {
                input.type = 'text';
                icon.className = 'bi bi-eye-slash';
            } else {
                input.type = 'password';
                icon.className = 'bi bi-eye';
            }
        }
    </script>
</body>

</html>