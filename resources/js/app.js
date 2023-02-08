require("./bootstrap");

// Echo.channel("notifications").listen("UserSessionChanged", (e) => {
Echo.private("notifications").listen("UserSessionChanged", (e) => {
    console.log("hai");
    console.log(e);
    const getElement = document.getElementById("notification");
    getElement.innerText = e.message;
    getElement.classList.remove("invisible");
    getElement.classList.remove("alert-danger");
    getElement.classList.remove("alert-success");
    getElement.classList.add("alert-" + e.type);
});
