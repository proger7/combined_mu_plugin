document.addEventListener("DOMContentLoaded", function() {
    const filters = document.querySelectorAll(".theamailorderbride_radio");
    const profiles = document.querySelectorAll(".theamailorderbride_girl");

    filters.forEach(filter => {
        filter.addEventListener("click", function() {
            let category = this.getAttribute("data-filter");

            filters.forEach(f => f.classList.remove("theamailorderbride_active"));
            this.classList.add("theamailorderbride_active");

            profiles.forEach(profile => {
                if (profile.getAttribute("data-category") === category || category === "all") {
                    profile.style.display = "block";
                } else {
                    profile.style.display = "none";
                }
            });
        });
    });
});
