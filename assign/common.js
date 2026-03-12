document.addEventListener("DOMContentLoaded", function () {
   // ------------------ Logout Buttons ------------------
    function setupLogoutHandler(id) {
        const elmId = document.getElementById(id);
        if (elmId) {
            elmId.addEventListener("click", function (event) {
                event.preventDefault();
                let isSignOut = confirm("Are you sure you want to sign out?");
                if (isSignOut) {
                    window.location.href = "../index.html";
                }
            });
        }
    }
  
    setupLogoutHandler("signOut");
});
