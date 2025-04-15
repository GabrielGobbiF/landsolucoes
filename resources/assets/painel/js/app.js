
window.feather = require('feather-icons');

(function ($) {

    document.addEventListener("DOMContentLoaded", function () {
        const navContainers = document.querySelectorAll(".nav-tabs, .nav-pills"); // Adapta ao tipo de navegação
        const currentUrl = window.location.pathname; // Obtém a URL atual

        navContainers.forEach((container, index) => {
            const navPills = container.querySelectorAll(".nav-link");
            const storageKey = `activeTab_${currentUrl}_container${index}`; // Chave única por URL e contêiner

            // Função para verificar se é uma URL externa
            function isExternalUrl(href) {
                return href.startsWith("http://") || href.startsWith("https://");
            }

            // Função para verificar se o href é um seletor válido para querySelector
            function isValidSelector(href) {
                return href && href.startsWith("#");
            }

            // Restaura a aba ativa do localStorage
            const savedHref = localStorage.getItem(storageKey);
            if (savedHref && !isExternalUrl(savedHref) && isValidSelector(savedHref)) {
                const savedTab = Array.from(navPills).find(tab => tab.getAttribute("href") === savedHref);
                if (savedTab) {
                    // Simula o clique para ativar a aba
                    savedTab.classList.add("active");
                    document.querySelector(savedHref)?.classList.add("show", "active");
                    // Remove a classe 'active' de outras abas/tabs no mesmo contêiner
                    navPills.forEach(tab => {
                        if (tab !== savedTab) {
                            tab.classList.remove("active");
                            const href = tab.getAttribute("href");
                            if (isValidSelector(href)) {
                                document.querySelector(href)?.classList.remove("show", "active");
                            }
                        }
                    });
                }
            }

            // Evento para salvar a aba ativa no localStorage
            navPills.forEach(tab => {
                tab.addEventListener("click", function () {
                    const href = tab.getAttribute("href");

                    // Ignora abas com URLs externas ou com data-save presente
                    if (!tab.hasAttribute("data-save") && !isExternalUrl(href) && isValidSelector(href)) {
                        localStorage.setItem(storageKey, href);
                    }
                });
            });
        });
    });

    'use strict';

    function initMetisMenu() {
        //metis menu
        $("#side-menu").metisMenu();
    }

    function initLeftMenuCollapse() {
        $('#vertical-menu-btn').on('click', function (event) {
            event.preventDefault();
            $('body').toggleClass('sidebar-enable');
            if ($(window).width() >= 992) {
                $('body').toggleClass('vertical-collpsed');
            } else {
                $('body').removeClass('vertical-collpsed');
            }
        });

        $('body,html').on('click', function (e) {
            var container = $("#vertical-menu-btn");
            if (!container.is(e.target) && container.has(e.target).length === 0 && !(e.target).closest('div.vertical-menu')) {
                $("body").removeClass("sidebar-enable");
            }
        });

    }

    function initSideBarCollpsed() { }

    function initActiveMenu() {
        // === following js will activate the menu in left side bar based on url ====
        $("#sidebar-menu a").each(function () {
            var pageUrl = window.location.href.split(/[?#]/)[0];
            if (this.href == pageUrl) {
                $(this).addClass("active");
                $(this).parent().addClass("mm-active"); // add active to li of the current link
                $(this).parent().parent().addClass("mm-show");
                $(this).parent().parent().prev().addClass("mm-active"); // add active class to an anchor
                $(this).parent().parent().parent().addClass("mm-active");
                $(this).parent().parent().parent().parent().addClass("mm-show"); // add active to li of the current link
                $(this).parent().parent().parent().parent().parent().addClass("mm-active");
            }
        });
    }

    function initMenuItem() {
        $(".navbar-nav a").each(function () {
            var pageUrl = window.location.href.split(/[?#]/)[0];
            if (this.href == pageUrl) {
                $(this).addClass("active");
                $(this).parent().addClass("active");
                $(this).parent().parent().addClass("active");
                $(this).parent().parent().parent().addClass("active");
                $(this).parent().parent().parent().parent().addClass("active");
                $(this).parent().parent().parent().parent().parent().addClass("active");
            }
        });
    }

    function initFullScreen() {
        $('[data-toggle="fullscreen"]').on("click", function (e) {
            e.preventDefault();
            $('body').toggleClass('fullscreen-enable');
            if (!document.fullscreenElement && /* alternative standard method */ !document.mozFullScreenElement && !document.webkitFullscreenElement) {  // current working methods
                if (document.documentElement.requestFullscreen) {
                    document.documentElement.requestFullscreen();
                } else if (document.documentElement.mozRequestFullScreen) {
                    document.documentElement.mozRequestFullScreen();
                } else if (document.documentElement.webkitRequestFullscreen) {
                    document.documentElement.webkitRequestFullscreen(Element.ALLOW_KEYBOARD_INPUT);
                }
            } else {
                if (document.cancelFullScreen) {
                    document.cancelFullScreen();
                } else if (document.mozCancelFullScreen) {
                    document.mozCancelFullScreen();
                } else if (document.webkitCancelFullScreen) {
                    document.webkitCancelFullScreen();
                }
            }
        });
        document.addEventListener('fullscreenchange', exitHandler);
        document.addEventListener("webkitfullscreenchange", exitHandler);
        document.addEventListener("mozfullscreenchange", exitHandler);
        function exitHandler() {
            if (!document.webkitIsFullScreen && !document.mozFullScreen && !document.msFullscreenElement) {
                console.log('pressed');
                $('body').removeClass('fullscreen-enable');
            }
        }
    }

    function initRightSidebar() {
        // right side-bar toggle
        $('.right-bar-toggle').on('click', function (e) {
            $('body').toggleClass('right-bar-enabled');
        });

        $(document).on('click', 'body', function (e) {
            if ($(e.target).closest('.right-bar-toggle, .right-bar').length > 0) {
                return;
            }

            if ($(e.target).closest('.offcanvas').length > 0) {
                return;
            }

            $('body').removeClass('right-bar-enabled');
            $('#offcanvasRight').removeClass('show');
            $('#rightbar-etp-overlay').removeClass('show');
            return;
        });
    }

    function initDropdownMenu() {
        $('.dropdown-menu a.dropdown-toggle').on('click', function (e) {
            if (!$(this).next().hasClass('show')) {
                $(this).parents('.dropdown-menu').first().find('.show').removeClass("show");
            }
            var $subMenu = $(this).next(".dropdown-menu");
            $subMenu.toggleClass('show');

            return false;
        });
    }

    function initComponents() {
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })

        $(function () {
            $('[data-toggle="popover"]').popover()
        })
    }

    function initPreloader() {
        $(window).on('load', function () {
            $('#status').fadeOut();
            $('#preloader').delay(350).fadeOut('slow');
        });
    }

    function initSettings() {
        if (window.sessionStorage) {
            var alreadyVisited = localStorage.getItem("is_visited");
            var layoutMode = localStorage.getItem("layout_mode");
            var collapseMode = localStorage.getItem("collapse_mode");

            if (!alreadyVisited) {
                localStorage.setItem("is_visited", "light-mode-switch");
            } else {
                $(".right-bar input:checkbox").prop('checked', false);
                $("#" + alreadyVisited).prop('checked', true);
                updateThemeSetting(alreadyVisited);
            }

            if (!layoutMode) {
                localStorage.setItem("layout_mode", "horizontal-mode-switch");
            } else {
                $(".right-bar .theme-layout-choice input:checkbox").prop('checked', false);
                $("#" + layoutMode).prop('checked', true);
                updateThemeSetting(layoutMode);
            }

            if (!collapseMode) {
                localStorage.setItem("collapse_mode", "");
            } else {
                $('body').toggleClass('sidebar-enable vertical-collpsed');
                updateThemeSetting(collapseMode);
            }
        }

        $("#light-mode-switch, #dark-mode-switch").on("change", function (e) {
            updateThemeSetting(e.target.id);
        });

        $("#vertical-menu-btn").on("click", function (e) {
            var mode = $('body').hasClass('vertical-collpsed') ? 'vertical-collpsed' : '';
            updateThemeSetting(mode);
        });

        $("#vertical-mode-switch, #horizontal-mode-switch").on("change", function (e) {
            var layout = e.target.id === "horizontal-mode-switch" ? 'horizontal' : 'vertical'
            updateThemeSetting(e.target.id);
            updateSettingsUser(layout);
        });
    }

    function updateThemeSetting(id) {
        var base_url = $('meta[name="js-base_url"]').attr('content');

        if ($("#light-mode-switch").prop("checked") == true && id === "light-mode-switch") {
            $("#dark-mode-switch").prop("checked", false);
            $("#bootstrap-style").attr('href', `${base_url}/panel/css/bootstrap.css`);
            $("#app-style").attr('href', `${base_url}/panel/css/app.css`);
            localStorage.setItem("is_visited", "light-mode-switch");
        } else if ($("#dark-mode-switch").prop("checked") == true && id === "dark-mode-switch") {
            $("#light-mode-switch").prop("checked", false);
            $("#bootstrap-style").attr('href', `${base_url}/panel/css/bootstrap-dark.css`);
            $("#app-style").attr('href', `${base_url}/panel/css/app-dark.css`);
            localStorage.setItem("is_visited", "dark-mode-switch");
        }

        if ($("#horizontal-mode-switch").prop("checked") == true && id === "horizontal-mode-switch") {
            $("#vertical-mode-switch").prop("checked", false);
            localStorage.setItem("layout_mode", "horizontal-mode-switch");
        } else if ($("#vertical-mode-switch").prop("checked") == true && id === "vertical-mode-switch") {
            $("#horizontal-mode-switch").prop("checked", false);
            localStorage.setItem("layout_mode", "vertical-mode-switch");
        }

        if (id === "vertical-collpsed") {
            $('body').addClass('vertical-collpsed');
            $('body').addClass('sidebar-enable');
            localStorage.setItem("collapse_mode", "vertical-collpsed");
        } else {
            $('body').removeClass('sidebar-enable');
            $('body').removeClass('vertical-collpsed');
            localStorage.setItem("collapse_mode", "");
        }
    }

    function updateSettingsUser(id) {
        var base_url_api = $('meta[name="js-base_url_api"]').attr('content');
        axios({
            method: 'POST',
            url: `${base_url_api}users/settings`,
            data: {
                layout: id,
            }
        }).then(response => {
            location.reload();
        })
    }

    window.debounce = (func, wait, immediate) => {
        var timeout;
        return function executedFunction() {
            var context = this;
            var args = arguments;
            var later = function () {
                timeout = null;
                if (!immediate) func.apply(context, args);
            };
            var callNow = immediate && !timeout;
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
            if (callNow) func.apply(context, args);
        };
    };

    /* --------------------------------------------------------------
#
HOW TO USE THIS
        < div class="card-body" >
            <button class="btn btn-outline-danger"
                data-js="btn-confirm-submit"
                data-action="delete"
                data-route="{{route('')}}"
                data-btnText="Deletar">
                <i class="fa-solid fa-triangle-exclamation"></i>
                Reembolsar Pagamento
            </button>
</div >
        --------------------------------------------------------------*/

    const addModalConfirmInTheDom = btn => {
        btn.preventDefault();
        let token = document.querySelector('meta[name="csrf-token"]').content;
        let route = btn.target.dataset.route;
        let text = btn.target.dataset.btnText || 'Deletar';
        let action = btn.target.dataset.action || 'POST';
        let btnClass = btn.target.dataset.btnClass || btn.target.getAttribute('class');
        let btnHtml = btn.target.innerHTML;

        let htmlModalEl = `
        <div class="modal fade effect-scale" id="modal-delete" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
                <div class="modal-content">
                    <form id="form-confirm" role="form" class="needs-validation" action="${route}" method="POST">
                        <div class="modal-header">
                            <h6 class="modal-title"></h6>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body text-center">
                            <span class="mg-b-0 modal-text-body"></span>
                        </div>
                        <div class="modal-footer gap-1">
                            <button type="button" id="modal-cancel" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <input type="hidden" name="_token" value="${token}">
                            <input type="hidden" name="_method" value="${action}">
                            <button type="submit" data-btn-text="" class="btn-modal ${btnClass}">
                                ${btnHtml}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>`
        document.body.insertAdjacentHTML('beforeend', htmlModalEl);

        var $modal = $("#modal-delete");

        // Ajusta título e texto do corpo do modal
        $modal.find('.modal-title').text(text);
        $modal.find('.modal-text-body').text(`Tem certeza que deseja ${text}?`);

        // Adiciona campo de observação caso necessário
        if ($(btn.target).data('observation')) {
            $modal.find('.modal-body').append(`
                <div class="form-group mt-2">
                    <label for="input-observations">Motivo</label>
                    <textarea name="observations" type="text" class="form-control" rows="5"
                        id="input-observations" required></textarea>
                </div>
            `);
        }
        // Mostra o modal
        $modal.modal('show');

        // Remove o modal após ser fechado
        $modal.on('hidden.bs.modal', function () {
            $modal.remove();
        });
    }

    document.querySelectorAll('[data-js=btn-confirm-submit]').forEach(item => {
        item.addEventListener('click', addModalConfirmInTheDom);
    })

    function init() {
        //initMetisMenu();
        initLeftMenuCollapse();
        initActiveMenu();
        initMenuItem();
        initFullScreen();
        initRightSidebar();
        initDropdownMenu();
        initComponents();
        initSettings();
        initPreloader();

        feather.replace()

        //Waves.init()
    }

    init();

})(jQuery)
