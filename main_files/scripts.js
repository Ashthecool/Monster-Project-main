currentPage = 1;

const Startset = goToPage(1);

function goToPage(page) {
    currentPage = page;
    for (pageNum = 1; pageNum <= 3; pageNum++) {
        const pageElement = document.getElementById("page" + pageNum);
        if (pageNum === currentPage) {
            pageElement.classList.remove("hidden");
            pageElement.style.display = "block";
        } else {
            pageElement.classList.add("hidden");
            pageElement.style.display = "none";
        }
    }
}