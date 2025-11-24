// dashboard.js - JavaScript untuk dashboard.php dengan logika modal diperbaiki

let currentSection = 'statistics';
let currentAction = 'add';
const userRole = document.querySelector('meta[name="role"]').getAttribute('content')

// Load data on page load
document.addEventListener('DOMContentLoaded', function () {
    loadStatistics();
    loadStudents();
    loadTeachers();
    if (document.getElementById('users')) loadUsers();
    showSection('statistics');
});

async function loadStatistics() {
    const endpoints = [
        { url: '/db/api.php/students', element: 'studentsCount' },
        { url: '/db/api.php/teachers', element: 'teachersCount' },
    ];

    if (userRole === 'admin') {
        endpoints.push({ url: '/db/api.php/users', element: 'usersCount' });
    }

    try {
        for (const { url, element } of endpoints) {
            const response = await fetch(url);
            const data = await response.json();
            document.getElementById(element).textContent = data.length;
        }
    } catch (error) {
        console.error("Error loading statistics:", error);
    }
}

// Show Section
function showSection(section) {
    document.querySelectorAll('.dashboard-section').forEach(sec => sec.classList.remove('active'));
    document.getElementById(section).classList.add('active');
}

// Logout function
function logout() {
    fetch('/db/api.php/logout', {
        method: 'POST'
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.href = 'index.php';
            }
        });
}

// Load students with card
function loadStudents() {
    fetch('/db/api.php/students')
        .then(response => response.json())
        .then(data => {
            const container = document.getElementById('studentsCards');
            container.innerHTML = '';
            data.forEach(student => {
                container.innerHTML += `
                <div class="card">
                    <h3>${student.name}</h3>
                    <p><strong>NIM:</strong> ${student.nim}</p>
                    <p><strong>Jurusan:</strong> ${student.major}</p>
                    <p><strong>Email:</strong> ${student.email}</p>
                    <p><strong>Status:</strong> ${student.status}</p>
                    <div class="actions">
                        ${userRole === 'admin' ?
                        `<button onclick="editStudent(${student.id})">Edit</button>
                            <button onclick="deleteStudent(${student.id})">Hapus</button>` : ''
                    }
                    </div>
                </div>
            `;
            });
        });
}

// Load Teachers with Cards
function loadTeachers() {
    fetch('/db/api.php/teachers')
        .then(response => response.json())
        .then(data => {
            const container = document.getElementById('teachersCards');
            container.innerHTML = '';
            data.forEach(teacher => {
                container.innerHTML += `
                <div class="card">
                    <h3>${teacher.name}</h3>
                    <p><strong>NIP:</strong> ${teacher.nip}</p>
                    <p><strong>Mata Kuliah:</strong> ${teacher.subject}</p>
                    <p><strong>Email:</strong> ${teacher.email}</p>
                    <p><strong>Status:</strong> ${teacher.status}</p>
                    <div class="actions">
                        ${userRole === 'admin' ?
                        `<button onclick="editTeacher(${teacher.id})">Edit</button>
                            <button onclick="deleteTeacher(${teacher.id})">Hapus</button>` : ''
                    }
                    </div>
                </div>
            `;
            });
        });
}

// Load Users with Cards (for admin)
function loadUsers() {
    fetch('/db/api.php/users')
        .then(response => response.json())
        .then(data => {
            const container = document.getElementById('usersCards');
            container.innerHTML = '';
            data.forEach(user => {
                container.innerHTML += `
                <div class="card">
                    <h3>${user.username}</h3>
                    <p><strong>Role:</strong> ${user.role}</p>
                    <p><strong>Dibuat Pada:</strong> ${user.created_at}</p>
                    <div class="actions">
                        ${userRole === 'admin' ?
                        `<button onclick="editUser(${user.id})">Edit</button>
                        <button onclick="deleteUser(${user.id})">Hapus</button>` : ''
                    }
                    </div>
                </div>
            `;
            });
        });
}

// Show Modal
function showModal(action, id = null) {
    currentAction = action;
    document.getElementById('modal').style.display = 'flex';
    document.getElementById('modalTitle').textContent = action === 'addStudent' ? 'Tambah Mahasiswa' : action === 'editStudent' ? 'Edit Mahasiswa' : action === 'addTeacher' ? 'Tambah Dosen' : action === 'editTeacher' ? 'Edit Dosen' : action === 'addUser' ? 'Tambah User' : 'Edit User';

    // Reset form
    document.getElementById('modalForm').reset();
    document.getElementById('itemId').value = '';

    // Hide all fields first
    hideAllFields();

    if (action.includes('Student')) {
        currentSection = 'students';
        showStudentFields();
        document.getElementById('nim').placeholder = 'NIM';
        document.getElementById('date').placeholder = 'Tanggal Pendaftaran';
    } else if (action.includes('Teacher')) {
        currentSection = 'teachers';
        showTeacherFields();
        document.getElementById('nim').placeholder = 'NIP';
        document.getElementById('date').placeholder = 'Tanggal Hire';
    } else if (action.includes('User')) {
        currentSection = 'users';
        showUserFields();
    }

    if (action.includes('edit') && id) {
        loadItemForEdit(id);
    }
}

// Helper functions for fields
function hideAllFields() {
    const fields = ['name', 'nim', 'major', 'email', 'phone', 'address', 'date', 'status', 'username', 'password', 'userRole'];
    fields.forEach(field => {
        document.getElementById(field).style.display = 'none';
    });
}

function showStudentFields() {
    const fields = ['name', 'nim', 'major', 'email', 'phone', 'address', 'date', 'status'];
    fields.forEach(field => {
        document.getElementById(field).style.display = 'block';
    });
}

function showTeacherFields() {
    const fields = ['name', 'nim', 'major', 'email', 'phone', 'address', 'date', 'status'];
    fields.forEach(field => {
        document.getElementById(field).style.display = 'block';
    });
    document.getElementById('nim').placeholder = 'NIP';
    document.getElementById('major').placeholder = 'Mata Kuliah';
}

function showUserFields() {
    const fields = ['username', 'password', 'userRole'];
    fields.forEach(field => {
        document.getElementById(field).style.display = 'block';
    });
}

// Load item for edit
function loadItemForEdit(id) {
    fetch(`/db/api.php/${currentSection}`)
        .then(response => response.json())
        .then(data => {
            const item = data.find(i => i.id == id);
            if (item) {
                document.getElementById('itemId').value = item.id;
                if (currentSection === 'students') {
                    document.getElementById('name').value = item.name;
                    document.getElementById('nim').value = item.nim;
                    document.getElementById('major').value = item.major;
                    document.getElementById('email').value = item.email;
                    document.getElementById('phone').value = item.phone || '';
                    document.getElementById('address').value = item.address || '';
                    document.getElementById('date').value = item.enrollment_date;
                    document.getElementById('status').value = item.status;
                } else if (currentSection === 'teachers') {
                    document.getElementById('name').value = item.name;
                    document.getElementById('nim').value = item.nip;
                    document.getElementById('major').value = item.subject;
                    document.getElementById('email').value = item.email;
                    document.getElementById('phone').value = item.phone || '';
                    document.getElementById('address').value = item.address || '';
                    document.getElementById('date').value = item.hire_date;
                    document.getElementById('status').value = item.status;
                } else if (currentSection === 'users') {
                    document.getElementById('username').value = item.username;
                    document.getElementById('userRole').value = item.role;
                }
            }
        });
}

// Close Modal
function closeModal() {
    document.getElementById('modal').style.display = 'none';
}

// Handle Form Submit
document.getElementById('modalForm').addEventListener('submit', function (e) {
    e.preventDefault();

    // Basic validation
    if (!validateForm()) return;

    let formData = {};
    if (currentSection === 'students') {
        formData = {
            id: document.getElementById('itemId').value,
            name: document.getElementById('name').value,
            nim: document.getElementById('nim').value,
            major: document.getElementById('major').value,
            email: document.getElementById('email').value,
            phone: document.getElementById('phone').value,
            address: document.getElementById('address').value,
            enrollment_date: document.getElementById('date').value,
            status: document.getElementById('status').value
        };
    } else if (currentSection === 'teachers') {
        formData = {
            id: document.getElementById('itemId').value,
            name: document.getElementById('name').value,
            nip: document.getElementById('nim').value,
            subject: document.getElementById('major').value,
            email: document.getElementById('email').value,
            phone: document.getElementById('phone').value,
            address: document.getElementById('address').value,
            hire_date: document.getElementById('date').value,
            status: document.getElementById('status').value
        };
    } else if (currentSection === 'users') {
        formData = {
            id: document.getElementById('itemId').value,
            username: document.getElementById('username').value,
            password: document.getElementById('password').value,
            role: document.getElementById('userRole').value
        };
    }

    const method = currentAction.includes('add') ? 'POST' : 'PUT';
    fetch(`/db/api.php/${currentSection}`, {
        method: method,
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(formData)
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                closeModal();
                loadStatistics();
                if (currentSection === 'students') loadStudents();
                else if (currentSection === 'teachers') loadTeachers();
                else if (currentSection === 'users') loadUsers();
            } else {
                alert('Error: ' + data.error);
            }
        })
        .catch(error => {
            alert('Network error: ' + error.message);
        });
});

// Basic validation
function validateForm() {
    if (currentSection === 'students' || currentSection === 'teachers') {
        if (!document.getElementById('name').value || !document.getElementById('nim').value || !document.getElementById('email').value) {
            alert('Nama, NIM/NIP, dan Email wajib diisi!');
            return false;
        }
    } else if (currentSection === 'users') {
        if (!document.getElementById('username').value || !document.getElementById('password').value) {
            alert('Username dan Password wajib diisi!');
            return false;
        }
    }
    return true;
}

// Edit functions
function editStudent(id) {
    showModal('editStudent', id);
}

function editTeacher(id) {
    showModal('editTeacher', id);
}

function editUser(id) {
    showModal('editUser', id);
}

// Delete functions
function deleteStudent(id) {
    if (confirm('Hapus mahasiswa ini?')) {
        fetch(`/db/api.php/students`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ id: id })
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    loadStudents();
                    loadStatistics();
                }
            });
    }
}

function deleteTeacher(id) {
    if (confirm('Hapus dosen ini?')) {
        fetch(`/db/api.php/teachers`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ id: id })
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    loadTeachers();
                    loadStatistics();
                }
            });
    }
}

function deleteUser(id) {
    if (confirm('Hapus user ini?')) {
        fetch(`/db/api.php/users`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ id: id })
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    loadUsers();
                    loadStatistics();
                }
            });
    }
}
