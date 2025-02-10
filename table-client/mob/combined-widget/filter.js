document.addEventListener("DOMContentLoaded", function() {
    const filters = document.querySelectorAll(".widget_models_theamailorderbride_radio");

    filters.forEach(filter => {
        filter.addEventListener("click", function() {
            let selectedTag = this.getAttribute("data-tag");

            filters.forEach(f => f.classList.remove("widget_models_theamailorderbride_active"));
            this.classList.add("widget_models_theamailorderbride_active");

            let formData = new FormData();
            formData.append("action", "filter_models");
            formData.append("tag", selectedTag);

            fetch(ajax_params.ajax_url, {
                method: "POST",
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                document.getElementById("filtered-models").innerHTML = data;
            })
            .catch(error => console.error("Error fetching filtered models:", error));
        });
    });

    if (filters.length > 0) {
        filters[0].classList.add("widget_models_theamailorderbride_active");
        filters[0].click();
    }
});
