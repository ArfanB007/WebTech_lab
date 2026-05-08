function loadStudentData() {
    const outputDiv = document.getElementById("output");
    outputDiv.innerHTML = '<div class="loading">⏳ Loading student data...</div>';

    const xhr = new XMLHttpRequest();
    // IMPORTANT: filename matches exactly -> JSON_student.php
    xhr.open("GET", "JSON_student.php", true);
    xhr.setRequestHeader("Content-Type", "application/json");

    xhr.onload = function() {
        if (xhr.status === 200) {
            try {
                const student = JSON.parse(xhr.responseText);
                displayStudent(student);
            } catch (e) {
                outputDiv.innerHTML = `<div class="error">❌ Invalid JSON response<br><small>${e.message}</small></div>`;
                console.error("Parse error:", xhr.responseText);
            }
        } else {
            outputDiv.innerHTML = `<div class="error">⚠️ HTTP Error ${xhr.status} - ${xhr.statusText}</div>`;
        }
    };

    xhr.onerror = function() {
        outputDiv.innerHTML = '<div class="error">🌐 Network error. Is Apache running?</div>';
    };

    xhr.send();
}

function displayStudent(data) {
    const outputDiv = document.getElementById("output");
    // Escape HTML to prevent XSS
    const safeName = escapeHtml(data.name);
    const safeId = escapeHtml(data.id);
    const safeDept = escapeHtml(data.department);
    const cgpa = parseFloat(data.cgpa).toFixed(2);

    outputDiv.innerHTML = `
        <div style="background:white; border-radius:16px; padding:5px 0;">
            <h3 style="color:#e67e22; margin-bottom:15px;">🎓 Student Details</h3>
            <p><strong>Name:</strong> ${safeName}</p>
            <p><strong>ID:</strong> ${safeId}</p>
            <p><strong>Department:</strong> ${safeDept}</p>
            <p><strong>CGPA:</strong> ${cgpa}</p>
        </div>
    `;
}

function escapeHtml(str) {
    if (!str) return '';
    return String(str)
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#39;');
}

// Wait for the DOM to be fully loaded before attaching event
document.addEventListener("DOMContentLoaded", function() {
    const btn = document.getElementById("fetchBtn");
    if (btn) {
        btn.addEventListener("click", loadStudentData);
    }
});