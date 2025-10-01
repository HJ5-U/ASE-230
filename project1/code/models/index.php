<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

// robust loader for sessionauth.php
$authCandidates = [
    __DIR__ . '/sessionauth.php',

];
$authPath = null;
foreach ($authCandidates as $p) {
    if (file_exists($p)) { $authPath = $p; break; }
}
if (!$authPath) {
    http_response_code(500);
    echo "<!DOCTYPE html><html><body><h1>Server error</h1><p>Missing sessionauth.php. Looked in: " . htmlspecialchars(implode(', ', $authCandidates)) . "</p></body></html>";
    exit;
}
require_once $authPath;

$session = new sessionauth();

if ($session->is_logged_in()) {
    $user = $session->get_current_user();
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="utf-8">
        <title>Main Menu</title>
        <style>body{font-family:Arial,Helvetica,sans-serif;max-width:800px;margin:20px auto;padding:10px;} a.button{display:inline-block;padding:10px 15px;margin:6px;background:#007cba;color:#fff;text-decoration:none;border-radius:4px;}</style>
    </head>
    <body>
        <h1>Welcome, <?= htmlspecialchars($user['username']) ?> to the Student Infromation Database.</h1>
        <p>Selete from list:</p>
        <div>
            <a class="button" href="user_dash.php">User Dashboard</a>
            <?php if ($user['username'] === 'admin'): ?>
                <a class="button" href="user_man.php">User Management</a>
            <?php endif; ?>
            <a class="button" href="logout.php">Logout</a>
        </div>
        <h3>Search Database</h3>
        <button type="button" class="button" onclick="search('all')">List All Students from database</button>
        <div style="margin-top:10px;">
            <div style="margin-bottom:8px;">
                <label>Course: </label>
                <input id="s_course" placeholder="Enter a Course Code." />
                <button onclick="search('course')">Search</button>
            </div>
            <div style="margin-bottom:8px;">
                <label>Major: </label>
                <input id="s_major" placeholder="Enter a Major." />
                <button onclick="search('major')">Search</button>
            </div>
            <div style="margin-bottom:8px;">
                <label>Year: </label>
                <input id="s_year" placeholder="Enter a Academic Year." />
                <button onclick="search('year')">Search</button>
            </div>
            <div style="margin-bottom:8px;">
                <label>Name: </label>
                <input id="s_name" placeholder="Enter a student's name." />
                <button onclick="search('name')">Search</button>
            </div>
            <div style="margin-bottom:8px;">
                <label>ID: </label>
                <input id="s_id" placeholder="Enter a assigned database Id number." />
                <button onclick="search('get')">Get By ID</button>
            </div>
            <pre id="search_output" style="background:#f4f4f4;padding:10px;border:1px solid #ddd;white-space:pre-wrap;font-family:monospace;"></pre>
        </div>
        <script>
        function search(type) {
            const out = document.getElementById('search_output');
            let url = 'EPindex.php?action=' + encodeURIComponent(type);
            if (type === 'course') {
                const v = document.getElementById('s_course').value.trim(); if (!v) { out.textContent='Enter course'; return; }
                url += '&course=' + encodeURIComponent(v);
            } else if (type === 'major') {
                const v = document.getElementById('s_major').value.trim(); if (!v) { out.textContent='Enter major'; return; }
                url += '&major=' + encodeURIComponent(v);
            } else if (type === 'year') {
                const v = document.getElementById('s_year').value.trim(); if (!v) { out.textContent='Enter year'; return; }
                url += '&year=' + encodeURIComponent(v);
            } else if (type === 'name') {
                const v = document.getElementById('s_name').value.trim(); if (!v) { out.textContent='Enter name'; return; }
                url += '&name=' + encodeURIComponent(v);
            } else if (type === 'get') {
                const v = document.getElementById('s_id').value.trim(); if (!v) { out.textContent='Enter id'; return; }
                url += '&id=' + encodeURIComponent(v);
            }

            out.textContent = 'Loading...';
            fetch(url, { credentials: 'same-origin' })
            .then(r => r.json())
            .then(data => { out.textContent = JSON.stringify(data, null, 2); })
            .catch(e => { out.textContent = 'Error: ' + e.message; });
        }
        </script>
        <h3 style="margin-top:20px;">Add / Update Student</h3>
        <div style="background:#fafafa;padding:12px;border:1px solid #eee;">
            <p>To add a new student leave <strong>ID</strong> blank and click <em>Create</em>. To update an existing student enter the ID and click <em>Update</em>.</p>
            <div style="margin-bottom:8px;"><label>Name: </label><input id="stu_name" placeholder="Full name" style="width:60%"/></div>
            <div style="margin-bottom:8px;"><label>Course: </label><input id="stu_course" placeholder="Course Code" /></div>
            <div style="margin-bottom:8px;"><label>Major: </label><input id="stu_major" placeholder="Major Name" /></div>
            <div style="margin-bottom:8px;"><label>Year: </label><input id="stu_year" placeholder="Academic Year" /></div>
            <div style="margin-bottom:8px;"><label>ID (for update): </label><input id="stu_id" placeholder="Leave blank to create" /></div>
            <div>
                <button onclick="createStudent()">Create</button>
                <button onclick="updateStudent()">Update</button>
            </div>
            <pre id="stu_output" style="background:#fff;padding:10px;border:1px solid #ddd;margin-top:10px;white-space:pre-wrap;font-family:monospace;"></pre>
        </div>

        <script>
        async function handleJsonResponse(res) {
            const text = await res.text();
            try {
                return JSON.parse(text);
            } catch (e) {
                // return an object that indicates non-JSON response so UI can show it
                return { __raw_response: text, __status: res.status, __ok: res.ok };
            }
        }

        function createStudent(){
            const out = document.getElementById('stu_output');
            const name = document.getElementById('stu_name').value.trim();
            const course = document.getElementById('stu_course').value.trim();
            const major = document.getElementById('stu_major').value.trim();
            const year = document.getElementById('stu_year').value.trim();

            if (!name) { out.textContent='Name is required.'; return; }

            const payload = { name: name, course: course, major: major, year: year };
            out.textContent = 'Creating...';
            fetch('EPindex.php?action=create', {
                method: 'POST',
                credentials: 'same-origin',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(payload)
            })
            .then(handleJsonResponse)
            .then(data => {
                if (data && data.__raw_response) {
                    out.textContent = 'Server returned non-JSON response:\n' + data.__raw_response;
                } else {
                    out.textContent = JSON.stringify(data, null, 2);
                }
            })
            .catch(e => { out.textContent = 'Network error: ' + e.message; });
        }

        function updateStudent(){
            const out = document.getElementById('stu_output');
            const id = document.getElementById('stu_id').value.trim();
            const name = document.getElementById('stu_name').value.trim();
            const course = document.getElementById('stu_course').value.trim();
            const major = document.getElementById('stu_major').value.trim();
            const year = document.getElementById('stu_year').value.trim();

            if (!id) { out.textContent = 'ID is required to update.'; return; }

            const payload = {};
            if (name) payload.name = name;
            if (course) payload.course = course;
            if (major) payload.major = major;
            if (year) payload.year = year;

            out.textContent = 'Updating...';
            fetch('EPindex.php?action=update&id=' + encodeURIComponent(id), {
                method: 'POST',
                credentials: 'same-origin',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(payload)
            })
            .then(handleJsonResponse)
            .then(data => {
                if (data && data.__raw_response) {
                    out.textContent = 'Server returned non-JSON response:\n' + data.__raw_response;
                } else {
                    out.textContent = JSON.stringify(data, null, 2);
                }
            })
            .catch(e => { out.textContent = 'Network error: ' + e.message; });
        }

        function deleteStudent(){
            const out = document.getElementById('del_output');
            const id = document.getElementById('del_id').value.trim();
            if (!id) { out.textContent = 'Enter ID to delete.'; return; }
            if (!confirm('Are you sure you want to delete student ID ' + id + '? This cannot be undone.')) return;

            out.textContent = 'Deleting...';
            fetch('EPindex.php?action=delete&id=' + encodeURIComponent(id), {
                method: 'POST',
                credentials: 'same-origin'
            })
            .then(handleJsonResponse)
            .then(data => {
                if (data && data.__raw_response) {
                    out.textContent = 'Server returned non-JSON response:\n' + data.__raw_response;
                } else {
                    out.textContent = JSON.stringify(data, null, 2);
                }
            })
            .catch(e => { out.textContent = 'Network error: ' + e.message; });
        }
        </script>
        
        <h3 style="margin-top:20px;">Delete Student</h3>
        <div style="background:#fff7f7;padding:12px;border:1px solid #f1dcdc;">
            <p>Enter the ID of the student you want to delete and confirm.</p>
            <div style="margin-bottom:8px;"><label>ID: </label><input id="del_id" placeholder="Student ID" /></div>
            <div>
                <button onclick="deleteStudent()" style="background:#dc3545;color:#fff;padding:6px 10px;border:none;border-radius:3px;">Delete</button>
                 <?php if ($user['username'] === 'admin'): ?>
                <button type="button" onclick="deleteAllStudents()" style="background:#b02a37;color:#fff;padding:6px 10px;border:none;border-radius:3px; margin-left:10px;">Delete All Students</button>
                <?php endif; ?>
            </div>
            <pre id="del_output" style="background:#fff;padding:10px;border:1px solid #ddd;margin-top:10px;white-space:pre-wrap;font-family:monospace;"></pre>
        </div>

        <script>
        function deleteStudent(){
            const out = document.getElementById('del_output');
            const id = document.getElementById('del_id').value.trim();
            if (!id) { out.textContent = 'Enter ID to delete.'; return; }
            if (!confirm('Are you sure you want to delete student ID ' + id + '? This cannot be undone.')) return;

            out.textContent = 'Deleting...';
            fetch('EPindex.php?action=delete&id=' + encodeURIComponent(id), {
                method: 'POST',
                credentials: 'same-origin'
            })
            .then(handleJsonResponse)
            .then(data => {
                if (data && data.__raw_response) {
                    out.textContent = 'Server returned non-JSON response:\n' + data.__raw_response;
                } else {
                    out.textContent = JSON.stringify(data, null, 2);
                }
            })
            .catch(e => { out.textContent = 'Network error: ' + e.message; });
        }
        </script>

            <script>
                async function deleteAllStudents() {
                    if (!confirm('Are you sure you want to delete all students? This action cannot be undone.')) return;
                    const out = document.getElementById('del_output') || document.getElementById('search_output') || document.getElementById('stu_output');
                    if (out) out.textContent = 'Deleting all students...';
                    try {
                        const res = await fetch('EPindex.php?action=delete_all', { method: 'POST', credentials: 'same-origin' });
                        const text = await res.text();
                        let data;
                        try { data = JSON.parse(text); } catch (e) { data = { __raw_response: text, __status: res.status, __ok: res.ok }; }
                        if (out) out.textContent = JSON.stringify(data, null, 2);
                    } catch (err) {
                        if (out) out.textContent = 'Network error: ' + err.message;
                    }
                }
            </script>
        
        <p style="margin-top:20px; font-size:0.9em; color:#555;">Note: API links return JSON and require session cookie.</p>
    </body>
    </html>
    <?php
} else {
    // Not logged in — show links to login and some public info
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="utf-8">
        <title>Welcome to the Student information database.
        </title>
        <style>body{font-family:Arial,Helvetica,sans-serif;max-width:800px;margin:20px auto;padding:10px;} a.button{display:inline-block;padding:10px 15px;margin:6px;background:#007cba;color:#fff;text-decoration:none;border-radius:4px;}</style>
    </head>
    <body>
        <h1>Student Database</h1>
        <p>Please login to access the database. If you don't got a account to login to, then please contact the admin for one.</p>
        <div>
            <a class="button" href="login.php">Login</a>
        </div>
        <p style="margin-top:20px; font-size:0.9em; color:#555;">If you are testing APIs, login first via the login page to obtain a session cookie.</p>
    </body>
    </html>
    <?php
}

?>
