function createItemAJAX() {
    const formNode = document.getElementById("form");
    formNode.addEventListener("submit", async function (event) {
        event.preventDefault();

        const response = await fetch(formNode.attributes.action.value, {
            method: "POST",
            body: new FormData(formNode),
        });
        const data = await response.json();

        switch (response.status) {
            case 201:
                const errorElements = document.querySelectorAll(".input-error");
                errorElements.forEach((element) => {
                    while (element.firstChild) {
                        element.removeChild(element.firstChild);
                    }
                });
                window.location.reload();
                break;
            case 422:
                const validationErrors = data.errors;
                for (const [key, values] of Object.entries(validationErrors)) {
                    console.log(values);
                    const errorElement = document.querySelector(
                        `.input-error.${key}`
                    );
                    while (errorElement.firstChild) {
                        errorElement.removeChild(errorElement.firstChild);
                    }
                    errorElement.classList.add("mt-2");
                    values.forEach((element) => {
                        const li = document.createElement("li");
                        li.innerHTML = element;
                        errorElement.appendChild(li);
                    });
                }
                break;
        }
    });
}

async function deleteItemAJAX() {
    const buttons = document.querySelectorAll(".delete-item-button");

    buttons.forEach((button) => {
        button.addEventListener("click", async function () {
            const url = this.getAttribute("data-url");

            const response = await fetch(url, {
                headers: {
                    "X-CSRF-TOKEN": document.querySelector(
                        'meta[name="csrf-token"]'
                    ).content,
                },
                method: "DELETE",
            });

            if (response.ok) window.location.reload();
        });
    });
}
