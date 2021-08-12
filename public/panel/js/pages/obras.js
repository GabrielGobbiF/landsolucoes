$(document).ready(function () {
    $('.js-btn-etapa-show').on('click', function (e) {
        showEtapa($(this).attr('data-id'))
    });
})

let obraId = $('#input--obra_id').val();
let BASE_URL_API = $('meta[name="js-base_url_api"]').attr('content');
let BASE_URL_API_OBRA = `${BASE_URL_API}obra/${obraId}/`;
var $modal = $('.right-bar-etp');

//Iniciar Etapas
function showEtapa(etpId) {
    //if ($('#js-etapa-id').val() == etpId) {
    //    return;
    //}

    $.ajax({
        url: `${BASE_URL_API_OBRA}etapa/${etpId}`,
        type: "GET",
        ajax: true,
        dataType: "JSON",
        beforeSend: () => {
            $modal.find('.etp').addClass('d-none');
            $modal.find('.form-control').val('');
            $('.etp-show').append(preload())
            $('body').addClass('right-bar-etp-enabled');
        },
        success: function (j) {
            var data = j.data;

            $modal.find('#js-etapa-id').val(etpId)
            $modal.find('.box-title').html(data.name);
            $modal.find('.js-textarea-description').html(data.observacao)
            $modal.find('.js-input-etapa-n-nota').html(data.n_nota)

            $.each(data, function (index, value) {
                $modal.find(`#input--${index}`).val(value)
            });

            $('.js-input-etapa-n-nota').editable({
                pk: 'nota_numero',
                url: `${BASE_URL_API_OBRA}etapa/${etpId}`,
            })

            $('.js-edit-description').click(function (e) {
                e.stopPropagation();

                var btnEdit = $(this);
                btnEdit.addClass('d-none')

                $('.js-textarea-description', this.$e).editable({
                    pk: 'observacao',
                    url: `${BASE_URL_API_OBRA}etapa/${etpId}`,
                    success: function (response, newValue) {
                        if (newValue != '') {
                            $('.js-textarea-description').html(newValue);
                        }
                    }
                }).editable('toggle');

                $('.js-textarea-description').editable().on('hidden', function (e, params) {
                    if (params == "cancel") {
                        $('.js-textarea-description').editable('destroy');
                        btnEdit.removeClass('d-none')
                    }
                    btnEdit.removeClass('d-none')
                });
            })

            getCommentsEtp(etpId);

            const txHeight = 200;
            const tx = document.querySelector(".js-textarea-description");
            if(tx){
                for (let i = 0; i < tx.length; i++) {
                    if (tx[i].value == '') {
                        tx[i].setAttribute("style", "height:" + txHeight + "rem;overflow-y:hidden;");
                    } else {
                        tx[i].setAttribute("style", "height:" + (tx[i].scrollHeight) + "rem;overflow-y:hidden;");
                    }
                }
            }
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            toastr.error(errorThrown);
        },
        complete: function () {
            $('#preloader-content-etp').remove();
            $modal.find('.etp').removeClass('d-none');
        },
    });

}

function getCommentsEtp(etpId) {

    $.ajax({
        url: `${BASE_URL_API}etapa/${etpId}/comments`,
        type: "GET",
        ajax: true,
        dataType: "JSON",
        beforeSend: (jqXHR, settings) => {
            $modal.find('.etapas-comments').html(preload('preload-comments'));
        },
        success: function (j) {
            var data = j.data;
            if (data.length > 0) {
                var options = '';
                $.each(data, function (index, value) {
                    options += '<div class="media mt-4">';
                    options += '<div class="avatar-sm font-weight-bold d-inline-block">'
                    options += '    <span class="avatar-title rounded-circle bg-soft-purple tx-14">'
                    options += value.user
                    options += '    </span>'
                    options += '</div>'
                    options += '    <div class="media-body overflow-hidden ml-2">';
                    options += '        <h5 class="tx-black text-truncate mb-1 tx-14 ">' + value.user_name + '</h5>';
                    options += `        <div class="direct-chat-text"><span style="word-break: break-all;">  ${value.text}  </span></div>`
                    options += '    </div>';
                    options += '    <div class="font-size-11">' + value.date + '</div>';
                    options += '</div>';
                });
                $modal.find('.etapas-comments').html(options);
            }
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            toastr.error('erro ao carregar os comentários');
        },
        complete: function () {
            $modal.find('#preload-comments').remove();
        },
    });
}

function newComment() {
    var input = $('#input-new-comment').val();
    var obra_id = $('#input--obra_id').val();
    var etp_id = $('#js-etapa-id').val();
    if (input != '') {
        $('.js-btn-new-comment').attr('disabled', true);
        $.ajax({
            headers: {
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            },
            url: BASE_URL_API + 'obra/' + obra_id + '/etapa/' + etp_id + '/comment/store ',
            type: 'POST',
            ajax: true,
            dataType: "JSON",
            data: {
                obs_texto: input
            }
        }).done(function (response) {
            $('#input-new-comment').val('').focus();
            $('.js-btn-new-comment').attr('disabled', false);
            getCommentsEtp(etp_id)
        });
    }
}

function preload(typ = 'preloader-content-etp') {
    var preload = ''
    preload += `<div class="text-center col-md-12 align-self-center preload" id="${typ}">`;
    preload += `    <div class="spinner-border text-primary m-1 align-self-center" role="status">`;
    preload += `        <span class="sr-only"></span>`;
    preload += `    </div>`;
    preload += `</div>`;
    return preload;
}

var textarea = document.querySelector('textarea');

textarea.addEventListener('keydown', autosize);

function autosize() {
    var el = this;
    setTimeout(function () {
        el.style.cssText = 'height:auto; padding:0';
        // for box-sizing other than "content-box" use:
        // el.style.cssText = '-moz-box-sizing:content-box';
        el.style.cssText = 'height:' + el.scrollHeight + 'px';
    }, 0);
}


  //  var obra_id = $('#input--obra_id').val();
  //  const BASE_URL_API_OBRA = `${BASE_URL_API}obra/${obra_id}/`;
//
  //  $(document).ready(function() {
//
  //      $('.right-bar-etp-toggle').on('click', function(e) {
  //          showEtapa($(this).attr('data-id'))
  //      });
//
  //      //$("textarea").each(function() {
  //      //    this.setAttribute("style", "height:" + (this.scrollHeight) + "px;overflow-y:hidden;");
  //      //}).on("input", function() {
  //      //    this.style.height = "auto";
  //      //    this.style.height = (this.scrollHeight) + "px";
  //      //});
//
  //  })
//
  //  function showEtapa(etp_id) {
  //      const BASE_URL_API_OBRA_ETAPA = `${BASE_URL_API}obra/${obra_id}/etapa/${etp_id}`
//
  //      $('body').addClass('right-bar-etp-enabled');
  //      $('#preloader-content-etp').removeClass('d-none');
  //      $('.etp').addClass('d-none');
//
  //      $.ajax({
  //          url: `${BASE_URL_API_OBRA}etapa/${etp_id}`,
  //          type: 'GET',
  //          ajax: true,
  //          dataType: "JSON",
  //          success: function(j) {
  //              var data = j.data;
  //              var $modal = $('.right-bar-etp');
//
  //              $modal.find('#js-etapa-id').val(etp_id)
  //              $modal.find('.box-title').html(data.name);
  //              $modal.find('#preloader-content-etp').addClass('d-none');
  //              $modal.find('.etp').removeClass('d-none');
//
  //              $modal.find('.js-textarea-description').html(data.observacao)
  //              $modal.find('.js-input-etapa-n-nota').html(data.n_nota)
//
  //              $modal.find('.etapas-comments').html('');
//
  //              if (data.comments.length > 0) {
  //                  var options = '';
  //                  $.each(data.comments, function(index, value) {
  //                      options += '<div class="media mt-4">';
  //                      options += '<div class="avatar-sm font-weight-bold d-inline-block">'
  //                      options += '    <span class="avatar-title rounded-circle bg-soft-purple tx-14">'
  //                      options += value.user
  //                      options += '    </span>'
  //                      options += '</div>'
  //                      options += '    <div class="media-body overflow-hidden ml-2">';
  //                      options += '        <h5 class="text-truncate mb-1 tx-14 ">' + value.user_name + '</h5>';
  //                      options += '        <p class="text-truncate mb-0 text-wrap-content">' + value.text + '</p>';
  //                      options += '    </div>';
  //                      options += '    <div class="font-size-11">' + value.date + '</div>';
  //                      options += '</div>';
  //                  });
//
  //                  $modal.find('.etapas-comments').html(options);
  //              }
//
  //              const txHeight = 50;
  //              const tx = document.getElementsByTagName("textarea");
  //              for (let i = 0; i < tx.length; i++) {
  //                  if (tx[i].value == '') {
  //                      tx[i].setAttribute("style", "height:" + txHeight + "px;overflow-y:hidden;");
  //                  } else {
  //                      tx[i].setAttribute("style", "height:" + (tx[i].scrollHeight) + "px;overflow-y:hidden;");
  //                  }
  //              }
  //          },
  //      });
//
  //      /* Configurações Mudar  */
//
  //      $('.js-input-etapa-n-nota').editable({
  //          pk: 'nota_numero',
  //          url: BASE_URL_API_OBRA_ETAPA,
  //      })
//
  //      $('.js-edit-description').click(function(e) {
  //          e.stopPropagation();
//
  //          var btnEdit = $(this);
  //          btnEdit.addClass('d-none')
//
  //          $('.js-textarea-description', this.$e).editable({
  //              pk: 'observacao',
  //              url: BASE_URL_API_OBRA_ETAPA,
  //              success: function(response, newValue) {
  //                  if (newValue != '') {
  //                      $('.js-textarea-description').html(newValue);
  //                  }
  //              }
  //          }).editable('toggle');
//
  //          $('.js-textarea-description').editable().on('hidden', function(e, params) {
  //              if (params == "cancel") {
  //                  $('.js-textarea-description').editable('destroy');
  //                  btnEdit.removeClass('d-none')
  //              }
  //              btnEdit.removeClass('d-none')
  //          });
  //      })
  //      /* Configurações Mudar  */
//
  //  }
//
  //  function newComment() {
  //      var input = $('#input-new-comment').val();
  //      var obra_id = $('#input--obra_id').val();
  //      var etp_id = $('#js-etapa-id').val();
  //      $.ajax({
  //          headers: {
  //              'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
  //          },
  //          url: BASE_URL_API + 'obra/' + obra_id + '/etapa/' + etp_id + '/comment/store ',
  //          type: 'POST',
  //          ajax: true,
  //          dataType: "JSON",
  //          data: {
  //              obs_texto: input
  //          }
  //      }).done(function(response) {
  //          $('#input-new-comment').val('')
  //          //showEtapa(etp_id);
  //      });
  //  }
//
  //  function updateStatus(v) {
  //      var obra_id = $('#input--obra_id').val();
  //      var etp_id = $(v).attr('data-id');
  //      var value = $(v).is(":checked") ? 'C' : 'EM';
  //      $.ajax({
  //          headers: {
  //              'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
  //          },
  //          url: BASE_URL_API + 'obra/' + obra_id + '/etapa/' + etp_id + '/status',
  //          type: 'POST',
  //          ajax: true,
  //          dataType: "JSON",
  //          data: {
  //              check: value
  //          }
  //      })
//
  //  }
