
document.addEventListener('DOMContentLoaded', function() {
    
    
    const studentForm = document.getElementById('student-form');
    const rollNoInput = document.getElementById('roll-no');
    const studentNameInput = document.getElementById('student-name');
    const addBtn = document.getElementById('add-btn');
    const studentList = document.getElementById('student-list');
    const searchInput = document.getElementById('search-input');
    const sortBtn = document.getElementById('sort-btn');
    const highlightBtn = document.getElementById('highlight-btn');
    const totalStudentsPara = document.getElementById('total-students');
    const presentCountPara = document.getElementById('present-count');
    
    
    let students = []; 
    
    
    
    
    studentForm.addEventListener('submit', addStudent);
    
    
    studentNameInput.addEventListener('input', validateForm);
    rollNoInput.addEventListener('input', validateForm);
    
   
    searchInput.addEventListener('input', filterStudents);
    
   
    sortBtn.addEventListener('click', sortStudents);
    
    
    highlightBtn.addEventListener('click', highlightFirstStudent);
    
    
    validateForm();
    
    
    
    
    function addStudent(event) {
        event.preventDefault(); 
        
        
        let rollNo = rollNoInput.value.trim();
        let studentName = studentNameInput.value.trim();
        
        if (studentName === '' || rollNo === '') {
            alert('Please enter both student name and roll number');
            return;
        }
        
        
        const student = {
            id: Date.now(), 
            rollNo: rollNo,
            name: studentName,
            present: false
        };
        
        students.push(student);
        renderStudent(student);
        
        
        rollNoInput.value = '';
        studentNameInput.value = '';
        
        
        updateTotalCount();
        updatePresentCount();
        validateForm();
    }
    
    
    function renderStudent(student) {
        
        let li = document.createElement('li');
        li.classList.add('student-item');
        li.dataset.id = student.id;
        li.dataset.rollNo = student.rollNo;
        li.dataset.name = student.name;
        
        
        let infoSpan = document.createElement('span');
        infoSpan.classList.add('student-info');
        infoSpan.textContent = `${student.rollNo} – ${student.name}`;
        
        
        let presentCheckbox = document.createElement('input');
        presentCheckbox.type = 'checkbox';
        presentCheckbox.classList.add('present-checkbox');
        presentCheckbox.checked = student.present;
        presentCheckbox.addEventListener('change', function() {
            togglePresent(li, student.id, this.checked);
        });
        
        let presentLabel = document.createElement('label');
        presentLabel.textContent = 'Present';
        presentLabel.classList.add('present-label');
        presentLabel.htmlFor = presentCheckbox.id;
        
        
        let editButton = document.createElement('button');
        editButton.textContent = 'Edit';
        editButton.classList.add('btn-edit');
        editButton.addEventListener('click', function() {
            editStudent(li, student.id);
        });
        
        
        let deleteButton = document.createElement('button');
        deleteButton.textContent = 'Delete';
        deleteButton.classList.add('btn-delete');
        deleteButton.addEventListener('click', function() {
            deleteStudent(li, student.id);
        });
        
        
        li.appendChild(infoSpan);
        li.appendChild(presentCheckbox);
        li.appendChild(presentLabel);
        li.appendChild(editButton);
        li.appendChild(deleteButton);
        
        
        studentList.appendChild(li);
    }
    
    
    function updateTotalCount() {
        const totalStudents = students.length;
        totalStudentsPara.textContent = `Total students: ${totalStudents}`;
    }
    
    //
    function togglePresent(li, studentId, isPresent) {
        const student = students.find(s => s.id === studentId);
        if (student) {
            student.present = isPresent;
            if (isPresent) {
                li.classList.add('present');
            } else {
                li.classList.remove('present');
            }
            updatePresentCount();
        }
    }
    
    
    function updatePresentCount() {
        const presentCount = students.filter(s => s.present).length;
        const absentCount = students.length - presentCount;
        presentCountPara.textContent = `Present: ${presentCount}, Absent: ${absentCount}`;
    } //
    
    
    function validateForm() {
        const rollValue = rollNoInput.value.trim();
        const nameValue = studentNameInput.value.trim();
        addBtn.disabled = rollValue === '' || nameValue === '';
    }
    
   
    function filterStudents() {
        const searchTerm = searchInput.value.toLowerCase();
        const studentItems = document.querySelectorAll('.student-item');
        
        studentItems.forEach(item => {
            const name = item.dataset.name.toLowerCase();
            const rollNo = item.dataset.rollNo.toLowerCase();
            const text = `${rollNo} – ${name}`;
            
            if (text.includes(searchTerm)) {
                item.classList.remove('hidden');
            } else {
                item.classList.add('hidden');
            }
        });
    }
    
    
    function sortStudents() {
        
        students.sort((a, b) => a.name.toLowerCase().localeCompare(b.name.toLowerCase()));
        
        
        studentList.innerHTML = '';
        students.forEach(student => renderStudent(student));
        
        
        updateTotalCount();
        updatePresentCount();
    }
    
    
    function deleteStudent(li, studentId) {
        if (confirm('Are you sure you want to delete this student?')) {
            
            students = students.filter(s => s.id !== studentId);
            
            
            li.remove();
            
            
            updateTotalCount();
            updatePresentCount();
        }
    }
    
    
    function editStudent(li, studentId) {
        const student = students.find(s => s.id === studentId);
        if (!student) return;
        
        const newName = prompt('Enter the new name:', student.name);
        const newRollNo = prompt('Enter the new roll number:', student.rollNo);
        
        if (newName !== null && newName.trim() !== '' && 
            newRollNo !== null && newRollNo.trim() !== '') {
            
            
            student.name = newName.trim();
            student.rollNo = newRollNo.trim();
            
            
            li.dataset.name = student.name;
            li.dataset.rollNo = student.rollNo;
            li.querySelector('.student-info').textContent = `${student.rollNo} – ${student.name}`;
        }
    }
    
    
    function highlightFirstStudent() {
        const studentItems = document.querySelectorAll('.student-item');
        
        
        studentItems.forEach(item => {
            item.classList.remove('first-highlight');
        });
        
        
        if (studentItems.length > 0) {
            studentItems[0].classList.add('first-highlight');
            
            
            setTimeout(() => {
                studentItems[0].classList.remove('first-highlight');
            }, 3000);
        }
    }
    
    
    function isHighlighted() {
        return document.querySelector('.first-highlight') !== null;
    }
});