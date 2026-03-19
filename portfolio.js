
const typingElement = document.getElementById("typing-text");

const phrases = [
    "A Front-End Developer",
    "HTML & CSS Enthusiast",
    "JavaScript Learner"
];

let phraseIndex = 0;
let charIndex = 0;
let isDeleting = false;

function typeText() {
    let current = phrases[phraseIndex];

    if (isDeleting) {
        typingElement.textContent = current.substring(0, charIndex--);
    } else {
        typingElement.textContent = current.substring(0, charIndex++);
    }

    if (!isDeleting && charIndex === current.length) {
        isDeleting = true;
        setTimeout(typeText, 1000);
        return;
    }

    if (isDeleting && charIndex === 0) {
        isDeleting = false;
        phraseIndex = (phraseIndex + 1) % phrases.length;
    }

    setTimeout(typeText, isDeleting ? 40 : 80);
}

typeText();



const projects = [
    { title: "Portfolio Website", desc: "My personal website" },
    { title: "Calculator", desc: "Simple calculator app" },
    { title: "Todo App", desc: "Task manager app" }
];

const container = document.getElementById("project-container");

projects.forEach(p => {
    const div = document.createElement("div");
    div.className = "card";

    div.innerHTML = `
        <h3>${p.title}</h3>
        <p>${p.desc}</p>
    `;

    container.appendChild(div);
});



document.getElementById("contact-form").addEventListener("submit", function(e) {
    e.preventDefault();

    let valid = true;

    const name = document.getElementById("name");
    const email = document.getElementById("email");
    const subject = document.getElementById("subject");
    const message = document.getElementById("message");

    document.getElementById("name-error").textContent = "";
    document.getElementById("email-error").textContent = "";
    document.getElementById("subject-error").textContent = "";
    document.getElementById("message-error").textContent = "";

    if (name.value === "") {
        document.getElementById("name-error").textContent = "Name required";
        valid = false;
    }

    if (!email.value.includes("@")) {
        document.getElementById("email-error").textContent = "Invalid email";
        valid = false;
    }

    if (subject.value === "") {
        document.getElementById("subject-error").textContent = "Subject required";
        valid = false;
    }

    if (message.value === "") {
        document.getElementById("message-error").textContent = "Message required";
        valid = false;
    }

    if (valid) {
        alert("Form submitted successfully!");
    }
});



const toggle = document.getElementById("theme-toggle");

toggle.addEventListener("click", () => {
    document.body.classList.toggle("dark");

    if (document.body.classList.contains("dark")) {
        localStorage.setItem("theme", "dark");
    } else {
        localStorage.setItem("theme", "light");
    }
});

if (localStorage.getItem("theme") === "dark") {
    document.body.classList.add("dark");
}



const btn = document.getElementById("scrollTop");

window.onscroll = () => {
    if (window.scrollY > 200) {
        btn.style.display = "block";
    } else {
        btn.style.display = "none";
    }
};

btn.onclick = () => {
    window.scrollTo({ top: 0, behavior: "smooth" });
};