/**
 * Sistema de notificações Toast
 *
 * Este script gerencia o carregamento, exibição e interação com notificações
 * no formato de toast no canto inferior direito da tela.
 */

class NotificationsToast {
    constructor() {
        this.container = document.getElementById('notifications-container');
        this.placeholder = document.getElementById('notifications-placeholder');
        this.overflowContainer = document.getElementById('notifications-overflow');
        this.moreCountElement = document.getElementById('more-count');
        this.apiUrl = `${base_url}/api/notifications/unread`;
        this.markAsReadUrl = `${base_url}/api/notifications/mark-as-read`;
        this.notifications = [];
        this.maxVisibleNotifications = 3;
        this.fetchInterval = 30000; // 30 segundos
        this.initialized = false;
        this.lastNotificationCount = 0;
        this.browserNotificationsEnabled = false;
        this.storageKey = 'browser_notifications_enabled';
    }

    init() {
        if (this.initialized) return;

        this.loadNotifications();

        // Verificar se notificações do navegador estão habilitadas
        this.checkBrowserNotificationStatus();

        // Configurar intervalo para buscar notificações
        setInterval(() => this.loadNotifications(), this.fetchInterval);

        // Verificar periodicamente o status das notificações do navegador (caso seja alterado por outro meio)
        setInterval(() => this.checkBrowserNotificationStatus(), 10000);

        // Adicionar evento para mostrar todas notificações ao clicar no overlay de blur
        this.overflowContainer.addEventListener('click', () => this.showAllNotifications());

        this.initialized = true;
    }

    /**
     * Verifica o status das notificações do navegador
     */
    checkBrowserNotificationStatus() {
        // Verifica se o navegador suporta notificações
        if (!("Notification" in window)) {
            console.log("Este navegador não suporta notificações de desktop");
            return;
        }

        // Verifica se já existe configuração salva no localStorage
        const savedPreference = localStorage.getItem(this.storageKey);

        // Atualiza o status das notificações baseado no localStorage
        if (savedPreference === 'granted' && Notification.permission === 'granted') {
            this.browserNotificationsEnabled = true;
        } else {
            this.browserNotificationsEnabled = false;

            Notification.requestPermission().then(permission => {
                switch (permission) {
                    case "granted":
                        console.log("Permissão concedida. Notificações ativadas.");
                        break;
                    case "denied":
                        console.log("Permissão negada. Notificações desativadas.");
                        break;
                    case "default":
                        console.log("O usuário não tomou uma decisão.");
                        break;
                }
            });

            if (savedPreference === null && Notification.permission !== 'denied') {
                this.showNotificationPermissionButton();
            }
        }
    }

    /**
     * Mostra botão para solicitar permissão de notificações
     */
    showNotificationPermissionButton() {
        const permissionBtn = document.createElement('div');
        permissionBtn.classList.add('notification-permission-btn');
        permissionBtn.innerHTML = `
            <div class="notification-toast permission-toast">
                <div class="notification-toast-header">
                    <h6 class="notification-toast-title">Ativar notificações</h6>
                    <button type="button" class="notification-toast-close" aria-label="Fechar">&times;</button>
                </div>
                <div class="notification-toast-body">
                    Receba notificações mesmo quando não estiver com o sistema aberto.
                </div>
                <div class="notification-toast-footer">
                    <div class="notification-actions">
                        <button type="button" class="notification-allow-btn">Permitir</button>
                        <button type="button" class="notification-deny-btn">Não, obrigado</button>
                    </div>
                </div>
            </div>
        `;

        this.container.prepend(permissionBtn);

        // Adicionar eventos
        const allowBtn = permissionBtn.querySelector('.notification-allow-btn');
        const denyBtn = permissionBtn.querySelector('.notification-deny-btn');
        const closeBtn = permissionBtn.querySelector('.notification-toast-close');

        allowBtn.addEventListener('click', () => {
            this.requestBrowserNotificationPermission();
            permissionBtn.remove();
        });

        denyBtn.addEventListener('click', () => {
            localStorage.setItem(this.storageKey, 'denied');
            permissionBtn.remove();
        });

        closeBtn.addEventListener('click', () => {
            permissionBtn.remove();
        });
    }

    /**
     * Solicita permissão para notificações do navegador
     */
    requestBrowserNotificationPermission() {
        Notification.requestPermission().then(permission => {
            if (permission === "granted") {
                this.browserNotificationsEnabled = true;
                localStorage.setItem(this.storageKey, 'granted');

                // Mostrar notificação de teste
                this.showBrowserNotification(
                    'Notificações ativadas!',
                    'Você receberá notificações mesmo quando não estiver com o sistema aberto.'
                );
            } else {
                localStorage.setItem(this.storageKey, 'denied');
            }
        });
    }

    /**
     * Exibe uma notificação do navegador
     */
    showBrowserNotification(title, message, link = null) {
        if (!this.browserNotificationsEnabled || Notification.permission !== 'granted') {
            return;
        }

        const options = {
            body: message,
            icon: `${base_url}/favicon.ico`,
            badge: `${base_url}/favicon.ico`,
            silent: false
        };

        const notification = new Notification(title, options);

        if (link) {
            notification.onclick = function () {
                window.open(link, '_blank');
                notification.close();
            };
        }

        // Fechar automaticamente após 5 segundos
        setTimeout(() => {
            notification.close();
        }, 5000);
    }

    /**
     * Busca notificações não lidas da API
     */
    loadNotifications() {
        fetch(this.apiUrl, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            },
        })
            .then(response => response.json())
            .then(data => {
                const newNotifications = data.notifications || [];

                // Verificar se há novas notificações desde a última vez
                if (this.lastNotificationCount < newNotifications.length) {
                    // Obter apenas as novas notificações
                    const brandNewNotifications = newNotifications.slice(0, newNotifications.length - this.lastNotificationCount);

                    // Enviar notificações do navegador para as novas notificações
                    if (this.browserNotificationsEnabled && brandNewNotifications.length > 0) {
                        brandNewNotifications.forEach(notification => {
                            this.showBrowserNotification(
                                notification.data.title || 'Nova notificação',
                                notification.data.message || '',
                                notification.data.url || null
                            );
                        });
                    }
                }

                this.lastNotificationCount = newNotifications.length;
                this.notifications = newNotifications;
                this.renderNotifications();
            })
            .catch(error => {
                console.error('Erro ao carregar notificações:', error);
            });
    }

    /**
     * Renderiza as notificações na tela
     */
    renderNotifications() {
        // Limpa o container de notificações
        this.placeholder.innerHTML = '';

        if (this.notifications.length === 0) {
            this.overflowContainer.classList.add('d-none');
            return;
        }

        // Determina se há mais notificações do que o limite visível
        const hasOverflow = this.notifications.length > this.maxVisibleNotifications;

        // Exibe apenas as primeiras X notificações
        const visibleNotifications = hasOverflow
            ? this.notifications.slice(0, this.maxVisibleNotifications)
            : this.notifications;

        // Cria e adiciona as notificações visíveis
        visibleNotifications.forEach(notification => {
            const toast = this.createToastElement(notification);
            this.placeholder.appendChild(toast);
        });

        // Configura o container de overflow se necessário
        if (hasOverflow) {
            const moreCount = this.notifications.length - this.maxVisibleNotifications;
            this.moreCountElement.textContent = moreCount;
            this.overflowContainer.classList.remove('d-none');
        } else {
            this.overflowContainer.classList.add('d-none');
        }
    }

    /**
     * Cria um elemento de toast para uma notificação
     */
    createToastElement(notification) {
        const toastElement = document.createElement('div');
        toastElement.classList.add('notification-toast');
        toastElement.classList.add('unread');
        toastElement.dataset.id = notification.id;

        // Adiciona classe baseada no tipo de notificação (se existir)
        if (notification.data && notification.data.type) {
            toastElement.classList.add(notification.data.type);
        }

        // Formata a data
        const createdAt = new Date(notification.created_at);
        const formattedDate = this.formatDate(createdAt);

        // Verifica se a notificação tem um URL
        const hasUrl = notification.data && notification.data.url;

        // Constrói o HTML do toast
        toastElement.innerHTML = `
            <div class="notification-toast-header">
                <h6 class="notification-toast-title">${notification.data.title || 'Nova notificação'}</h6>
                <button type="button" class="notification-toast-close" aria-label="Fechar">&times;</button>
            </div>
            <div class="notification-toast-body">
                ${notification.data.message || ''}
            </div>
            <div class="notification-toast-footer">
                <span class="notification-toast-time">${formattedDate}</span>
                <div class="notification-actions">
                    ${hasUrl ? `<a target="_blank" href="${notification.data.url}" class="notification-view-link">Visualizar</a>` : ''}
                    <button type="button" class="notification-mark-read">Marcar como lida</button>
                </div>
            </div>
        `;

        // Adiciona eventos
        const closeButton = toastElement.querySelector('.notification-toast-close');
        closeButton.addEventListener('click', () => this.markAsRead(notification.id));

        const markAsReadButton = toastElement.querySelector('.notification-mark-read');
        markAsReadButton.addEventListener('click', () => this.markAsRead(notification.id));

        // Se tiver link, adiciona evento para marcar como lida ao clicar no link
        if (hasUrl) {
            const viewLink = toastElement.querySelector('.notification-view-link');
            viewLink.addEventListener('click', () => this.markAsRead(notification.id));
        }

        return toastElement;
    }

    /**
     * Formata a data para exibição amigável
     */
    formatDate(date) {
        const now = new Date();
        const diffMs = now - date;
        const diffSec = Math.round(diffMs / 1000);
        const diffMin = Math.round(diffSec / 60);
        const diffHour = Math.round(diffMin / 60);
        const diffDay = Math.round(diffHour / 24);

        if (diffSec < 60) {
            return 'Agora mesmo';
        } else if (diffMin < 60) {
            return `${diffMin} ${diffMin === 1 ? 'minuto' : 'minutos'} atrás`;
        } else if (diffHour < 24) {
            return `${diffHour} ${diffHour === 1 ? 'hora' : 'horas'} atrás`;
        } else if (diffDay < 7) {
            return `${diffDay} ${diffDay === 1 ? 'dia' : 'dias'} atrás`;
        } else {
            return date.toLocaleDateString('pt-BR', {
                day: '2-digit',
                month: '2-digit',
                year: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });
        }
    }

    /**
     * Marca uma notificação como lida na API
     */
    markAsRead(notificationId) {
        fetch(`${this.markAsReadUrl}/${notificationId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            }
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    this.removeNotificationFromList(notificationId);
                }
            })
            .catch(error => {
                console.error('Erro ao marcar notificação como lida:', error);
            });
    }

    /**
     * Remove uma notificação sem marcá-la como lida
     */
    dismissNotification(notificationId) {
        this.removeNotificationFromList(notificationId);
    }

    /**
     * Remove uma notificação da lista e atualiza a interface
     */
    removeNotificationFromList(notificationId) {
        // Remove a notificação da lista
        this.notifications = this.notifications.filter(n => n.id !== notificationId);
        this.lastNotificationCount = this.notifications.length;

        // Remove o elemento da interface com animação
        const toastElement = this.placeholder.querySelector(`.notification-toast[data-id="${notificationId}"]`);
        if (toastElement) {
            toastElement.style.opacity = '0';
            toastElement.style.transform = 'translateX(50px)';

            setTimeout(() => {
                toastElement.remove();
                this.renderNotifications(); // Re-renderiza para ajustar o layout
            }, 300);
        }
    }

    /**
     * Mostra todas as notificações (remove o limite)
     */
    showAllNotifications() {
        this.maxVisibleNotifications = this.notifications.length;
        this.renderNotifications();
    }
}

// Inicializa o sistema de notificações quando o documento estiver pronto
document.addEventListener('DOMContentLoaded', () => {
    const notificationsSystem = new NotificationsToast();
    notificationsSystem.init();

    // Configurar o switch de notificações no painel de configurações
    setupBrowserNotificationSettings(notificationsSystem);
});

/**
 * Configura os controles de notificações do navegador no painel de configurações
 */
function setupBrowserNotificationSettings(notificationsSystem) {
    const notificationSwitch = document.getElementById('browser-notification-switch');
    const testNotificationBtn = document.getElementById('test-notification-btn');

    if (!notificationSwitch || !testNotificationBtn) return;

    // Verifica se o navegador suporta notificações
    if (!("Notification" in window)) {
        notificationSwitch.disabled = true;
        testNotificationBtn.disabled = true;
        return;
    }

    // Atualiza o estado do switch baseado na configuração atual
    const savedPreference = localStorage.getItem(notificationsSystem.storageKey);

    if (savedPreference === 'granted' && Notification.permission === 'granted') {
        notificationSwitch.checked = true;
    } else {
        notificationSwitch.checked = false;
    }

    // Adiciona evento para o switch de notificações no elemento parent (label) para garantir o comportamento visual
    notificationSwitch.parentElement.addEventListener('click', function (e) {
        // Prevenir comportamento padrão para poder controlar manualmente
        e.preventDefault();

        // Alternando o valor do checkbox manualmente
        notificationSwitch.checked = !notificationSwitch.checked;

        if (notificationSwitch.checked) {
            // Solicita permissão se não tiver ainda
            if (Notification.permission !== 'granted') {
                Notification.requestPermission().then(permission => {
                    if (permission === 'granted') {
                        localStorage.setItem(notificationsSystem.storageKey, 'granted');
                        notificationsSystem.browserNotificationsEnabled = true;

                        // Mostra notificação de teste
                        notificationsSystem.showBrowserNotification(
                            'Notificações ativadas!',
                            'Você receberá notificações mesmo quando não estiver com o sistema aberto.'
                        );
                    } else {
                        // Se o usuário negou, desmarque o switch
                        notificationSwitch.checked = false;
                        localStorage.setItem(notificationsSystem.storageKey, 'denied');
                    }
                });
            } else {
                // Se já tem permissão, apenas ativa
                localStorage.setItem(notificationsSystem.storageKey, 'granted');
                notificationsSystem.browserNotificationsEnabled = true;
            }
        } else {
            // Desativa as notificações
            localStorage.setItem(notificationsSystem.storageKey, 'denied');
            notificationsSystem.browserNotificationsEnabled = false;
        }
    });

    // Adiciona evento para o botão de teste
    testNotificationBtn.addEventListener('click', function () {
        if (Notification.permission === 'granted') {
            notificationsSystem.showBrowserNotification(
                'Notificação de teste',
                'Esta é uma notificação de teste para verificar se as configurações estão corretas.',
                `${base_url}/notifications`
            );
        } else {
            // Se não tem permissão, solicita
            Notification.requestPermission().then(permission => {
                if (permission === 'granted') {
                    notificationSwitch.checked = true;
                    localStorage.setItem(notificationsSystem.storageKey, 'granted');
                    notificationsSystem.browserNotificationsEnabled = true;

                    notificationsSystem.showBrowserNotification(
                        'Notificação de teste',
                        'Esta é uma notificação de teste para verificar se as configurações estão corretas.',
                        `${base_url}/notifications`
                    );
                }
            });
        }
    });
}
