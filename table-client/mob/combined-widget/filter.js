document.addEventListener("DOMContentLoaded", function() {
    const filters = document.querySelectorAll(".theamailorderbride_radio");

    filters.forEach(filter => {
        filter.addEventListener("click", function() {
            let selectedTag = this.getAttribute("data-tag");

            filters.forEach(f => f.classList.remove("theamailorderbride_active"));
            this.classList.add("theamailorderbride_active");

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
});
