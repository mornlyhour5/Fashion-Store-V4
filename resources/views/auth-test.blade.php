<!-- resources/views/auth-test.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Auth Test</title>
<meta name="csrf-token" content="{{ csrf_token() }}">
<style>
    body { font-family: sans-serif; max-width: 480px; margin: 40px auto; }
    .box { margin-bottom: 24px; padding: 16px; border: 1px solid #ddd; }
    .box h3 { margin-top: 0; }
    label { display: block; margin-top: 8px; font-size: 13px; }
    input, select { width: 100%; padding: 6px; margin-top: 2px; box-sizing: border-box; }
    button { margin-top: 12px; padding: 8px 16px; cursor: pointer; }
    pre { background: #f4f4f4; padding: 12px; white-space: pre-wrap; word-break: break-all; }
</style>
</head>
<body>

<h2>Auth Test</h2>

<div class="box">
    <h3>Register</h3>
    <label>Name <input type="text" id="reg_name"></label>
    <label>Email <input type="email" id="reg_email"></label>
    <label>Password <input type="password" id="reg_password"></label>
    <label>Confirm Password <input type="password" id="reg_password_confirmation"></label>
    <label>First Name <input type="text" id="reg_first_name"></label>
    <label>Last Name <input type="text" id="reg_last_name"></label>
    <label>Phone <input type="text" id="reg_phone"></label>
    <button id="registerBtn">Register</button>
</div>

<div class="box">
    <h3>Login</h3>
    <label>Email <input type="email" id="login_email"></label>
    <label>Password <input type="password" id="login_password"></label>
    <button id="loginBtn">Login</button>
</div>

<div class="box">
    <h3>Logout</h3>
    <button id="logoutBtn">Logout</button>
</div>

<h3>Response</h3>
<pre id="output">—</pre>

<script>
const output = document.getElementById('output');

async function ensureCsrfCookie() {
    await fetch('/sanctum/csrf-cookie', { credentials: 'include' });
}

function getCookie(name) {
    const match = document.cookie.match(new RegExp('(^| )' + name + '=([^;]+)'));
    return match ? decodeURIComponent(match[2]) : null;
}

async function apiRequest(url, payload) {
    await ensureCsrfCookie();
    const xsrfToken = getCookie('XSRF-TOKEN');

    const res = await fetch(url, {
        method: 'POST',
        credentials: 'include',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-XSRF-TOKEN': xsrfToken,
        },
        body: JSON.stringify(payload),
    });

    const data = await res.json().catch(() => ({ message: 'No JSON response' }));
    output.textContent = JSON.stringify(data, null, 2);
    return data;
}

document.getElementById('registerBtn').addEventListener('click', async () => {
    await apiRequest('/api/register', {
        name: document.getElementById('reg_name').value,
        email: document.getElementById('reg_email').value,
        password: document.getElementById('reg_password').value,
        password_confirmation: document.getElementById('reg_password_confirmation').value,
        first_name: document.getElementById('reg_first_name').value,
        last_name: document.getElementById('reg_last_name').value,
        phone: document.getElementById('reg_phone').value,
    });
});

document.getElementById('loginBtn').addEventListener('click', async () => {
    await apiRequest('/api/login', {
        email: document.getElementById('login_email').value,
        password: document.getElementById('login_password').value,
    });
});

document.getElementById('logoutBtn').addEventListener('click', async () => {
    await ensureCsrfCookie();
    const xsrfToken = getCookie('XSRF-TOKEN');
    const res = await fetch('/api/logout', {
        method: 'POST',
        credentials: 'include',
        headers: {
            'Accept': 'application/json',
            'X-XSRF-TOKEN': xsrfToken,
        },
    });
    const data = await res.json().catch(() => ({ message: 'No JSON response' }));
    output.textContent = JSON.stringify(data, null, 2);
});
</script>

</body>
</html>
