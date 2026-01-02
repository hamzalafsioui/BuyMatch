document.addEventListener("DOMContentLoaded", () => {
  const loginForm = document.getElementById("loginForm");

  if (loginForm) {
    loginForm.addEventListener("submit", async (e) => {
      e.preventDefault();

      const formData = new FormData(loginForm);
      const btn = loginForm.querySelector("button");
      const originalText = btn.innerText;

      // Reset feedback
      btn.innerText = "SIGNING IN...";
      btn.disabled = true;

      try {
        const response = await fetch("../../actions/Auth/login.action.php", {
          method: "POST",
          body: formData,
        });

        const result = await response.json();

        if (result.success) {
          window.location.href = result.redirect;
        } else {
          alert(result.message || "Login failed");
          btn.innerText = originalText;
          btn.disabled = false;
        }
      } catch (error) {
        console.error("Login Error:", error);
        alert("An error occurred during login. Please try again.");
        btn.innerText = originalText;
        btn.disabled = false;
      }
    });
  }
});
