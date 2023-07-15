let bannerForm = document.getElementById("banner-form");

bannerForm.addEventListener("submit", async (e) => {
  e.preventDefault();

  let name = document.getElementById("banner-form__field-name");
  let phone = document.getElementById("banner-form__field-phone");

  if (name.value == "" || phone.value == "") {
    alert("Оба поля должны быть заполнены!");
  } else {
    //console.log(`${name.value} and ${phone.value}`);

    const formData = new URLSearchParams();
    formData.append("banner-form__field-name", name.value);
    formData.append("banner-form__field-phone", phone.value);

    let response = await fetch("/cgi-bin/mail.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/x-www-form-urlencoded",
      },
      body: formData.toString(),
    });

    let result = await response.text();
    //console.log(result);

    let message = document.getElementById("banner-form__messages");
    message.innerHTML = result;
    message.classList.remove("hidden");
    setTimeout(() => message.classList.add("hidden"), 5000);

    bannerForm.reset();
  }
});
