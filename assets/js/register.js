document.addEventListener("DOMContentLoaded", () => {
  // console.log("REGISTER JS LOADED");

  const registerForm = document.getElementById("registerForm");
  const roleRadios = document.querySelectorAll('input[name="role"]');
  const organizerFields = document.getElementById("organizerFields");

  function updateRoleVisibility() {
    const selectedRole = document.querySelector(
      'input[name="role"]:checked'
    )?.value;
    console.log("Selected role:", selectedRole);
    if (selectedRole === "organizer") {
      organizerFields.classList.remove("hidden");
      setTimeout(() => {
        organizerFields.style.maxHeight = "1000px";
        organizerFields.style.opacity = "1";
      }, 10);
    } else {
      organizerFields.style.maxHeight = "0";
      organizerFields.style.opacity = "0";
      setTimeout(() => {
        if (
          document.querySelector('input[name="role"]:checked')?.value !==
          "organizer"
        ) {
          organizerFields.classList.add("hidden");
        }
      }, 500);
    }
  }

  roleRadios.forEach((radio) => {
    radio.addEventListener("change", updateRoleVisibility);
  });

  // Initial check
  updateRoleVisibility();

  if (registerForm) {
    registerForm.addEventListener("submit", async (e) => {
      e.preventDefault();

      const formData = new FormData(registerForm);
      const btn = registerForm.querySelector("button");
      const originalText = btn.innerText;

      btn.innerText = "CREATING ACCOUNT...";
      btn.disabled = true;

      try {
        const response = await fetch("../../actions/Auth/register.action.php", {
          method: "POST",
          body: formData,
        });

        const text = await response.text();
        // console.log("Raw Server Response:", text); 

        let result;
        try {
          result = JSON.parse(text);
        } catch (e) {
          // console.error("JSON Parse Error:", e);
          throw new Error("Invalid server response: " + text);
        }

        if (result.success) {
          alert("Account created successfully!");
          window.location.href = result.redirect;
        } else {
          alert(result.message || "Registration failed");
          btn.innerText = originalText;
          btn.disabled = false;
        }
      } catch (error) {
        // console.error("Registration Error:", error);
        alert("An error occurred. Please try again.");
        btn.innerText = originalText;
        btn.disabled = false;
      }
    });
  }
});
