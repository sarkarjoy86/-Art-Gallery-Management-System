document.addEventListener("DOMContentLoaded", function () {
    const bookButtons = document.querySelectorAll(".btn-book");

    bookButtons.forEach(button => {
        button.addEventListener("click", function (event) {
            event.preventDefault();

            const form = this.closest("form");
            const exhibition_id = form.querySelector("input[name='exhibition_id']").value;

            const xhr = new XMLHttpRequest();
            xhr.open("POST", form.action, true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    const response = JSON.parse(xhr.responseText);
                    let messageElement = document.createElement("div");
                    messageElement.classList.add("message");

                    if (response.status === "success") {
                        messageElement.classList.add("success");
                        messageElement.innerHTML = `
                            <strong>${response.message}</strong><br>
                            <strong>User ID:</strong> ${response.user_id}<br>
                            <strong>Booking ID:</strong> ${response.booking_id}<br>
                            <strong>Exhibition ID:</strong> ${response.exhibition_id}<br>
                            <strong>Start Date:</strong> ${response.start_date}<br>
                            <strong>End Date:</strong> ${response.end_date}
                        `;
                    } else {
                        messageElement.classList.add("error");
                        messageElement.innerHTML = `<strong>${response.message}</strong>`;
                    }

                    form.parentNode.insertBefore(messageElement, form);
                }
            };

            xhr.send("exhibition_id=" + exhibition_id);
        });
    });
});
