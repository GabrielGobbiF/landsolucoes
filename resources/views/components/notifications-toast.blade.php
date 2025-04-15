<!-- Notifications Toast Component -->
<div id="notifications-container" class="notifications-toast-container">
    <!-- As notificações serão carregadas aqui via JavaScript -->
    <div id="notifications-placeholder" style="display: contents"></div>

    <!-- Container de overflow (para quando houver mais de 3 notificações) -->
    <div id="notifications-overflow" class="d-none">
        <div class="notification-blur-overlay">
            <span class="notification-more-text">+<span id="more-count">0</span> notificações</span>
        </div>
    </div>
</div>

<!-- Preloader para o sistema de notificações (invisível) -->
<div id="notifications-preloader" style="display: none;">
    <div class="spinner-border text-primary" role="status">
        <span class="sr-only">Carregando...</span>
    </div>
</div>
