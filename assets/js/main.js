jQuery(document).ready(function ($) {
  $('#stm_search_form').on('submit', function (event) {
    var preloader = $('.lds-facebook');
    event.preventDefault();

    var stm_search = $(this).find('input[name="stm_search"]').val();
    preloader.addClass('active');

    $.ajax({
      url: ajaxurl, // Используем глобальную переменную ajaxurl
      type: 'POST',
      data: {
        action: 'custom_search_action', // Имя вашей функции на сервере
        stm_search: stm_search
      },
      success: function (response) {
        preloader.removeClass('active');
        // Если есть результаты поиска
        if (response !== "undefined") {
          // Выводим результаты
          $('.search-results').html(response?.html);
          $('#baki_pagination').html('')

          $('#baki_pagination').append(`<a href="#">&laquo;</a>`);
          response?.letters.forEach((item) => {
            $('#baki_pagination').append(`<a id="baki_pagination_ss" href="#">${item}</a>`);
          });
          $('#baki_pagination').append(`<a href="#">&raquo;</a>`);

          handleAjaxSuccess();

        } else {
          $('.search-results').html('Ничего не найдено');
        }
      }
    });
  });



  // Функция для сортировки элементов
  function sortCompanyItems(letter) {
    const companyItems = document.querySelectorAll(".stm_company_item");

    companyItems.forEach((item) => {
      const description = item.querySelector(".stm_company_description").textContent;
      if (description.trim().charAt(0).toUpperCase() === letter) {
        item.style.display = "block";
      } else {
        item.style.display = "none";
      }
    });
  }

// Функция для назначения обработчика события клика на пагинации
  function setupPaginationClickHandler() {
    const paginationLinks = document.querySelectorAll("#baki_pagination a");

    paginationLinks.forEach((link) => {
      link.addEventListener("click", (e) => {
        e.preventDefault();

        // Очищаем классы "active" у всех ссылок пагинации
        paginationLinks.forEach((pLink) => {
          pLink.classList.remove("active");
        });

        // Добавляем класс "active" только к выбранной ссылке пагинации
        link.classList.add("active");

        // Получаем букву, по которой нужно сортировать
        const letter = link.textContent;

        // Вызываем функцию для сортировки элементов
        sortCompanyItems(letter);
      });
    });
  }

// Обработка успешной загрузки AJAX (предполагается, что вы знаете, как обрабатывать AJAX в вашем коде)
  function handleAjaxSuccess() {
    // Назначаем обработчик кликов на пагинации после успешной загрузки AJAX
    setupPaginationClickHandler();
  }


// ...

// После успешной загрузки и вставки пагинации, вызываем функцию handleAjaxSuccess
// чтобы назначить обработчик кликов на пагинации









  let ppp = 5; // Post per page
  let pageNumber = 1;


  function load_posts() {
    let postId = $('.btn_span_ajax').attr('data-id');
    console.log(postId)
    pageNumber++;
    let str = '&postid=' + postId + '&pageNumber=' + pageNumber + '&ppp=' + ppp + '&action=more_post_ajax';
    $.ajax({
      type: "POST",
      dataType: "html",
      url: ajaxurl,
      data: str,
      success: function (data) {
        var $data = $(data);
        if ($data.length) {
          $(".stm_single_company_posts").append($data);
          $("#more_posts").attr("disabled", false);
        } else {
          $("#more_posts").attr("disabled", true);
        }
        if ($data.length === 0) {
          $("#more_posts").addClass('false');
        }
      },
      beforeSend: function () {
        $('.lds-ellipsis').show();
        $('.btn_span_ajax').hide();
      },
      complete: function () {
        $('.lds-ellipsis').hide();
        $('.btn_span_ajax').show();
      },
      error: function (jqXHR, textStatus, errorThrown) {
        $loader.html(jqXHR + " :: " + textStatus + " :: " + errorThrown);
      }

    });
    return false;
  }


  $("#more_posts").on("click", function () { // When btn is pressed.
    $("#more_posts").attr("disabled", true); // Disable the button, temp.
    load_posts();

  });

});


