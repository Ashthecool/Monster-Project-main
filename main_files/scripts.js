currentPage = 2;

// Don't call goToPage before DOM is ready — we'll initialize after DOMContentLoaded

function goToPage(page, offset) {
    currentPage = page;
    for (pageNum = 1; pageNum <= 4; pageNum++) {
        const pageElement = document.getElementById("page" + pageNum);
        if (!pageElement) continue; // skip missing pages
        if (pageNum === currentPage) {
            pageElement.classList.remove("hidden");
            pageElement.style.display = "block";
        } else {
            pageElement.classList.add("hidden");
            pageElement.style.display = "none";
        }
        
        const yOffset = offset; // adjust as needed
        const element = document.getElementById('searchResults');
        const y = element.getBoundingClientRect().top + window.pageYOffset + yOffset;
        window.scrollTo({ top: y, behavior: 'smooth' });
    }
}

function filterMonsters() {
    const input = document.getElementById("searchbar");
    const filter = input.value.toUpperCase();
    const cards = document.querySelectorAll(".drink-card");
    
    cards.forEach(card => {
        const name = card.getAttribute("data-name").toUpperCase();
        if (name.indexOf(filter) > -1) {
            card.style.display = "";
        } else {
            card.style.display = "none";
        }
    });
}

window.addEventListener('DOMContentLoaded', () => {
const modal = document.getElementById('drinkModal');
const modalImage = document.getElementById('modalDrinkImage');
const modalName = document.getElementById('modalDrinkName');
const modalDesc = document.getElementById('modalDrinkDescription');
const modalStatus = document.getElementById('modalStatus');
const closeBtn = document.getElementById('modalCloseBtn');

if (!modal) return;

function openDrinkModal(name, description, imageSrc, disc = '0', category = '1') {
    modalName.textContent = name;
    modalDesc.textContent = description;
    modalImage.src = imageSrc;
    modalImage.alt = name;

    if(modalStatus){
        if(disc === "1"){
            modalStatus.textContent = "DISCONTINUED";
            modalStatus.classList.remove("status-continued");
            modalStatus.classList.add("status-discontinued");
        } else {
            modalStatus.textContent = "AVAILABLE";
            modalStatus.classList.remove("status-discontinued");
            modalStatus.classList.add("status-continued");
        }
    }

    const modalContainer = modalImage.parentElement;
    modalContainer.querySelectorAll('.bubble, .spark, .vapor, .droplet, .ripple').forEach(el => el.remove());

    let animClass = 'bubble';
    let count = 6;
    switch(category){
        case "1": animClass="bubble"; count=6; break;
        case "2": animClass="spark"; count=20; break;
        case "3": animClass="vapor"; count=4; break;
        case "4": animClass="droplet"; count=60; break;
        case "5": animClass="ripple"; count=3; break;
    }

    for(let i=0;i<count;i++){
        const el = document.createElement('span');
        el.className = animClass;

        if (animClass === 'spark') {
            el.style.left = `${Math.random() * 95}%`;
            el.style.top = `${Math.random() * 90}%`;
            el.style.animationDelay = `${Math.random() * 2}s`;

        } else if (animClass === 'bubble') {
            el.style.left = `${Math.random() * 90}%`;
            el.style.animationDelay = `${Math.random() * 2}s`;

        } else if (animClass === 'vapor') {
            el.style.left = `${Math.random() * 90}%`;
            el.style.top = `${50 + Math.random() * 40}%`;
            el.style.animationDelay = `${Math.random() * 3}s`;
            el.style.animationDuration = `${3 + Math.random() * 3}s`;

        } else if (animClass === 'droplet') {
            el.style.left = `${Math.random() * 95}%`;
            el.style.top = `${70 + Math.random() * 40}%`;
            el.style.animationDelay = `${Math.random() * 2}s`;
            el.style.animationDuration = `${1.5 + Math.random()}s`;

        } else if (animClass === 'ripple') {
            el.style.left = `${20 + Math.random() * 60}%`;
            el.style.top = `${20 + Math.random() * 60}%`;
            el.style.animationDelay = `${Math.random() * 2}s`;
        }

        // Append to the modal container for **all** animation types
        modalContainer.appendChild(el);


    }

    modal.classList.add('active');
    modal.setAttribute('aria-hidden', 'false');
    document.body.style.overflow = 'hidden';
}

function closeDrinkModal() {
    if (document.activeElement && modal.contains(document.activeElement)) {
        document.activeElement.blur();
    }
    modal.classList.remove('active');
    modal.setAttribute('aria-hidden', 'true');
    if (modalImage) modalImage.src = '';
    document.body.style.overflow = 'auto';
}

// --- Delegated Clicks ---
document.addEventListener('click', (e) => {
    const card = e.target.closest('.drink-card');
    if (!card) return;

    // Pass the category properly
    const category = card.dataset.category || '1';

    openDrinkModal(
        card.dataset.name || '',
        card.dataset.desc || '',
        card.dataset.src || '',
        card.dataset.discontinued || '0',
        category
    );
});

if(closeBtn) closeBtn.addEventListener('click', closeDrinkModal);
modal.addEventListener('click', e => { if(e.target === modal) closeDrinkModal(); });
document.addEventListener('keydown', e => { if(e.key === 'Escape') closeDrinkModal(); });

});

document.addEventListener('DOMContentLoaded', () => {
    const menuToggle = document.getElementById('bgMenuToggle');
    const menuPanel = document.getElementById('bgMenuPanel');
    const body = document.body;

    if (!menuToggle || !menuPanel) return;

    // Toggle menu
    menuToggle.addEventListener('click', () => {
        menuPanel.classList.toggle('active');
    });

const backgrounds = {
    'green-black': { background: 'linear-gradient(to bottom right, black, green, black, green, black)', color: 'white' },
    'white-silver': { background: 'linear-gradient(to bottom right, white, silver, white, silver, white)', color: 'black' },
    'blue-yellow': { background: 'linear-gradient(to bottom right, blue, yellow, blue, yellow, blue)', color: 'black' },
    'brown-golden': { background: 'linear-gradient(to bottom right, brown, goldenrod, brown, goldenrod, brown)', color: 'white' },
    'red-black': { background: 'linear-gradient(to bottom right, red, black, red, black, red)', color: 'white' }
};


    // Change background on button click
    menuPanel.querySelectorAll('button').forEach(btn => {
        btn.addEventListener('click', () => {
            const bg = backgrounds[btn.dataset.bg] || backgrounds['green-black'];
            document.body.style.background = bg.background; 

            // Apply text color to all relevant elements
            const textElems = document.querySelectorAll('body, h1, h2, p, .drink-status');
            textElems.forEach(el => el.style.color = bg.color);
        });
    });
});
