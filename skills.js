const skills = JSON.parse(localStorage.getItem("skills")) || [];

const skillsList = document.getElementById("skills-list");

function displaySkills() {
    skillsList.innerHTML = ""; 

    skills.forEach((skill, index) => {
        const li = document.createElement("li");
        li.innerHTML = `
            <div class="info-skills">
                <i class="bx ${skill.icon} icon"></i>
                <strong>${skill.name}</strong> &thinsp; &thinsp; &thinsp;
                <em>${skill.description ? `(${skill.description})` : ""}</em> &thinsp; &thinsp;&thinsp;
                <p class="level">${getSkillLevel(skill.level)}</p>

            </div>
            <div class="actions">
                <button class="edit-btn" data-index="${index}">Modifier</button>
                <button class="delete-btn" data-index="${index}">Supprimer</button>
            </div>

        `;
        skillsList.appendChild(li);
    });

    document.querySelectorAll(".edit-btn").forEach((btn) =>
        btn.addEventListener("click", editSkill)
    );
    document.querySelectorAll(".delete-btn").forEach((btn) =>
        btn.addEventListener("click", deleteSkill)
    );
}

function getSkillLevel(level) {
    switch (level) {
        case "beginner":
            return "Débutant";
        case "intermediate":
            return "Intermédiaire";
        case "advanced":
            return "Avancé";
        default:
            return "";
    }
}

function editSkill(event) {
    const index = event.target.dataset.index;
    const skill = skills[index];

    const newName = prompt("Modifier le nom de la compétence :", skill.name);
    const newDescription = prompt(
        "Modifier la description :",
        skill.description || ""
    );
    const newLevel = prompt(
        "Modifier le niveau (beginner, intermediate, advanced) :",
        skill.level
    );

    if (newName) skills[index].name = newName;
    if (newDescription !== null) skills[index].description = newDescription;
    if (newLevel) skills[index].level = newLevel;

    localStorage.setItem("skills", JSON.stringify(skills));

    displaySkills();
}

function deleteSkill(event) {
    const index = event.target.dataset.index;
    skills.splice(index, 1); 

    localStorage.setItem("skills", JSON.stringify(skills));

    displaySkills();
}

displaySkills();
