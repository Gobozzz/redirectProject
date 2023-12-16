$("#signUp").on("submit", function (e) {
  //регистрация
  e.preventDefault();
  var data = $(this).serializeArray();
  $(".msg").empty();
  $.ajax({
    url: "controller/signUp",
    method: "post",
    dataType: "json",
    data: data,
    success: function (data) {
      $(".msg").append(`<p class='succes'>${data.succesText}</p>`);
      $(".msg").append(
        `<a href='signIn' class='succes'>Перейти к авторизации&#8594;</a>`
      );
    },
    error: function (err) {
      $(".msg").empty();
      arrErrors = err.responseJSON.error;
      arrErrors.forEach((element) => {
        $(".msg").append(`<p class='err'>${element}</p>`);
      });
    },
  });
});

$("#signIn").on("submit", function (e) {
  //авторизация
  e.preventDefault();
  var data = $(this).serializeArray();
  $(".msg").empty();
  $.ajax({
    url: "controller/signIn",
    method: "post",
    dataType: "json",
    data: data,
    success: function (data) {
      document.location.href = "/";
    },
    error: function (err) {
      $(".msg").empty();
      arrErrors = err.responseJSON.error;
      arrErrors.forEach((element) => {
        $(".msg").append(`<p class='err'>${element}</p>`);
      });
    },
  });
});

$("#addLink").on("submit", function (e) {
  //создание ссылки
  e.preventDefault();
  var data = $(this).serializeArray();
  $(".msg").empty();
  $.ajax({
    url: "controller/link",
    method: "post",
    dataType: "json",
    data: data,
    success: function (data) {
      $('.link').empty()
      $(".link").append(
        `Ваша ссылка:<a href='${data.shortLink}'> ${data.shortLink}</a>`
      );
      $(".msg").append(`<p class='succes'>Ссылка готова</p>`);
      
    },
    error: function (err) {
      
      $(".msg").empty();
      arrErrors = err.responseJSON.error;
      arrErrors.forEach((element) => {
        $(".msg").append(`<p class='err'>${element}</p>`);
      });
    },
  });
});